<?php
/**
 * This class iterates over the lines in a file in reverse order (i.e. starting from the last line).
 *
 * Empty lines are included. Supports LF, CR and CRLF line endings.
 */
class Elm_ReverseLineIterator implements Iterator {
	/**
	 * @var resource
	 */
	private $filePointer;

	/**
	 * @var int|null How many lines to read from the log (max).
	 */
	private $maxLinesToRead = null;

	private $currentLine = null;
	private $currentLineNumber = 0;

	/**
	 * @var string[]
	 */
	private $lineBuffer = array();

	/**
	 * @var int Current seek position.
	 */
	private $position = 0;

	/**
	 * @var int Read buffer size.
	 */
	private $bufferSizeInBytes = 8192;

	/**
	 * @var string Buffer data left over from the previous readNextLine() iteration.
	 */
	private $remainder = '';

	public function __construct($fileName, $maxLines = null) {
		$this->maxLinesToRead = $maxLines;

		$this->filePointer = fopen($fileName, 'rb');
		if ( $this->filePointer === false ) {
			throw new RuntimeException(
				sprintf(
					__('Could not open the log file "%s".', 'error-log-monitor'),
					esc_html($fileName)
				)
			);
		}
	}

	public function __destruct() {
		if ( $this->filePointer ) {
			fclose($this->filePointer);
			$this->filePointer = null;
		}
	}

	public function rewind() {
		//Start reading from the end of the file. Then move back towards the start
		//of the file, reading it in $bufferSizeInBytes blocks.
		fseek($this->filePointer, 0, SEEK_END);
		$this->position = ftell($this->filePointer);

		$this->lineBuffer = array();
		$this->currentLine = null;
		$this->currentLineNumber = 0;

		$this->readNextLine();
	}

	private function readNextLine() {
		//Stop after $maxLinesToRead. Note that $this->currentLineNumber is zero-based.
		if ( isset($this->maxLinesToRead) && ($this->currentLineNumber >= $this->maxLinesToRead - 1) ) {
			$this->currentLine = null;
			return;
		}

		//Populate the internal buffer.
		while ( (count($this->lineBuffer) < 1) && ($this->position > 0) ) {
			//Since $position is an offset from the start of the file,
			//it's also equal to the total amount of remaining data.
			$bytesToRead = ($this->position > $this->bufferSizeInBytes) ? $this->bufferSizeInBytes : $this->position;

			$this->position = $this->position - $bytesToRead;
			fseek($this->filePointer, $this->position, SEEK_SET);
			$buffer = fread($this->filePointer, $bytesToRead);

			//We may have a partial line left over from the previous iteration.
			$buffer .= $this->remainder;

			$newLines = preg_split('@\n|\r\n?@', $buffer, -1);

			//It's likely that we'll start reading in the middle of a line (unless we're at
			//the start of the file), so lets leave the first line for later.
			if ( $this->position != 0 ) {
				$this->remainder = array_shift($newLines);
			}

			$this->lineBuffer = $newLines;
		}

		//Get the next line from the buffer.
		if ( count($this->lineBuffer) > 0 ) {
			$this->currentLine = array_pop($this->lineBuffer);
			$this->currentLineNumber++;
		} else {
			$this->currentLine = null;
		}
	}

	public function valid() {
		return isset($this->currentLine) && ($this->position >= 0);
	}

	public function current() {
		return $this->currentLine;
	}

	public function key() {
		return $this->currentLineNumber;
	}

	public function next() {
		$this->readNextLine();
	}
}