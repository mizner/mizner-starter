<?php
class Elm_ReverseLogParser implements OuterIterator {
	/**
	 * @var array Recognized error levels. See PHP source code: /main/main.c, function php_error_cb.
	 * The "unknown error" case was intentionally omitted.
	 */
	private static $builtinSeverityLevels = array(
		'fatal error' => true,
		'catchable fatal error' => true,
		'parse error' => true,
		'warning' => true,
		'notice' => true,
		'strict standards' => true,
		'deprecated' => true,
	);

	/**
	 * @var string Most PHP versions prefix the severity with "PHP ".
	 */
	private static $severityPrefix = 'PHP ';

	/**
	 * @var Iterator
	 */
	private $lineIterator;
	private $currentEntry = null;
	private $currentKey = 0;

	private $backtrackingLineStack = array();
	private $backtrackingIndexStack = array();
	private $readBuffer = array();

	/**
	 * @var bool Attempt to parse XDebug stack traces.
	 */
	private $isXdebugTraceEnabled = false;

	public function __construct(Iterator $lineIterator) {
		$this->lineIterator = $lineIterator;
		$this->isXdebugTraceEnabled = function_exists('extension_loaded') && extension_loaded('xdebug');
	}

	/**
	 * Read the next entry from the log and store it in $currentEntry.
	 */
	private function readNextEntry() {
		$this->currentEntry = null;
		if ( !$this->lineIterator->valid() && empty($this->readBuffer) ) {
			return;
		}

		$this->currentKey++;

		//Try to read a log entry with an XDebug stack trace.
		if ( $this->isXdebugTraceEnabled ) {
			$this->saveState();
			$this->currentEntry = $this->parseEntryWithXdebugTrace();
			if ( $this->currentEntry !== null ) {
				$this->complete();
				return;
			} else {
				$this->backtrack();
			}
		}

		//Try to read a normal log entry.
		$this->currentEntry = $this->readParsedLine();
	}

	private function parseEntryWithXdebugTrace() {
		$stackTraceRegex = '/^PHP[ ]{1,5}?(\d{1,3}?)\.\s./';
		$stackTrace = null;

		$line = $this->readParsedLine();
		if ( isset($line) && preg_match($stackTraceRegex, $line['message'], $matches) ) {
			$stackTrace = array($line['message']);
			$remainingTraceLines = intval($matches[1]) - 1;
		} else {
			return null;
		}

		for ( $traceIndex = $remainingTraceLines; $traceIndex > 0; $traceIndex-- ) {
			$line = $this->readParsedLine();
			if ( isset($line) && preg_match($stackTraceRegex, $line['message'], $matches) && (intval($matches[1]) === $traceIndex) ) {
				$stackTrace[] = $line['message'];
			} else {
				return null;
			}
		}

		$line = $this->readParsedLine();
		if ( isset($line) && ($line['message'] == 'PHP Stack trace:' ) ) {
			$stackTrace[] = $line['message'];
		} else {
			return null;
		}

		$entry = $this->readParsedLine();
		if ( $entry === null ) {
			return null;
		}

		$entry['stacktrace'] = array_reverse($stackTrace);
		return $entry;
	}

	/**
	 * Save the current read state for later backtracking.
	 */
	private function saveState() {
		$this->backtrackingIndexStack[] = count($this->backtrackingLineStack);
	}

	/**
	 * Backtrack to the last saved state.
	 */
	private function backtrack() {
		if ( empty($this->backtrackingIndexStack) ) {
			throw new LogicException('Tried to backtrack but the stack is empty!');
		}

		//Move the lines from the backtracking stack to the read buffer.
		$index = array_pop($this->backtrackingIndexStack);
		$linesToMove = array_splice($this->backtrackingLineStack, $index);

		//The read buffer is in LIFO order.
		for($i = count($linesToMove) - 1; $i >= 0; $i--) {
			$this->readBuffer[] = $linesToMove[$i];
		}
	}

	/**
	 * Discard the last saved backtracking state. Call this when parsing succeeds.
	 */
	private function complete() {
		$index = array_pop($this->backtrackingIndexStack);
		array_splice($this->backtrackingLineStack, $index);
	}

	/**
	 * Read a single line from the log, parsed into basic components (timestamp, the message itself, etc).
	 *
	 * @param bool $skipEmptyLines
	 * @return array|null
	 */
	private function readParsedLine($skipEmptyLines = true) {
		$line = $this->readNextLine($skipEmptyLines);
		if ( $line === null ) {
			return null;
		}
		return $this->parseLogLine($line);
	}

	private function parseLogLine($line) {
		$line = rtrim($line);
		$timestamp = null;
		$message = $line;

		//Attempt to parse the timestamp, if any. Timestamp format can vary by server.
		//We expect log entries to be structured like this: "[date-and-time] error message".
		if ( (substr($line, 0, 1) === '[') &&  (strpos($line, ']') !== false) ) {
			list($parsedTimestamp, $remainder) = explode(']', $line, 2);
			$parsedTimestamp = strtotime(trim($parsedTimestamp, '[]'));
			if ( !empty($parsedTimestamp) ) {
				$timestamp = $parsedTimestamp;
				$message = $remainder;

				//Remove the space that follows the timestamp.
				if ( substr($message, 0, 1) === ' ' ) {
					$message = substr($message, 1);
				}
			}
		}

		//Parse the severity level.
		$level = null;
		$prefixLength = strlen(self::$severityPrefix);

		$firstColon = strpos($message, ':');
		if ( $firstColon && ($firstColon > 0) ) {
			$levelName = trim(substr($message, 0, $firstColon));

			//Drop the "PHP " prefix. Some old PHP versions don't use, and it's redundant anyway.
			if ( substr($levelName, 0, $prefixLength) === self::$severityPrefix ) {
				$levelName = substr($levelName, $prefixLength);
			}

			$levelName = strtolower($levelName);
			if ( isset(self::$builtinSeverityLevels[$levelName]) ) {
				$level = $levelName;
			}
		}

		return compact('timestamp', 'message', 'level');
	}

	/**
	 * Read a single line from the log.
	 *
	 * @param bool $skipEmptyLines
	 * @return string|null
	 */
	private function readNextLine($skipEmptyLines = true) {
		//Check the internal buffer first.
		while ( !empty($this->readBuffer) ) {
			$line = array_pop($this->readBuffer);

			if ( !empty($this->backtrackingIndexStack) ) {
				$this->backtrackingLineStack[] = $line;
			}

			if ( !$skipEmptyLines || ($line !== '') ) {
				return $line;
			}
		}

		//Then check the actual file iterator.
		while ( $this->lineIterator->valid() ) {
			$line = $this->lineIterator->current();
			$this->lineIterator->next();

			if ( !empty($this->backtrackingIndexStack) ) {
				$this->backtrackingLineStack[] = $line;
			}

			if ( !$skipEmptyLines || ($line !== '') ) {
				return $line;
			}
		}

		return null;
	}

	/**
	 * Return the current log entry.
	 *
	 * @return array
	 */
	public function current() {
		return $this->currentEntry;
	}

	/**
	 * Move forward to next log entry.
	 */
	public function next() {
		$this->readNextEntry();
	}

	/**
	 * Return the key of the current entry.
	 * The key is not actually used by the plugin, but it is required by the Iterator interface.
	 *
	 * @return int|null
	 */
	public function key() {
		return $this->currentKey;
	}

	/**
	 * Checks if current position is valid.
	 *
	 * @return boolean
	 */
	public function valid() {
		return isset($this->currentEntry);
	}

	/**
	 * Rewind the iterator to the last log entry.
	 */
	public function rewind() {
		$this->lineIterator->rewind();
		$this->currentKey = 0;

		$this->readBuffer = array();
		$this->backtrackingIndexStack = array();
		$this->backtrackingLineStack = array();

		$this->readNextEntry();
	}

	/**
	 * Returns the inner iterator.
	 *
	 * @return Iterator
	 */
	public function getInnerIterator() {
		return $this->lineIterator;
	}
}