<?php

/**
 * Filters log entries by the severity level.
 */
class Elm_SeverityFilter implements Iterator {
	const UNKNOWN_LEVEL_GROUP = 'other';

	private $logIterator;
	private $isGroupIncluded = array();

	private $skippedEntryCount = 0;

	//Some severity levels have the same general meaning, so we map them to the same group.
	private static $severityMap = array(
		'fatal error' => 'error',
		'catchable fatal error' => 'error',
		'parse error' => 'error',
	);

	public function __construct(Iterator $logIterator, $includedGroups = null) {
		$this->logIterator = $logIterator;

		//Include everything by default.
		$allGroups = self::getAvailableOptions();
		if ( !isset($includedGroups) ) {
			$includedGroups = $allGroups;
		}

		//Keep only supported levels.
		$includedGroups = array_intersect($includedGroups, $allGroups);

		$this->isGroupIncluded = array_merge(
			array_fill_keys($allGroups, false),
			array_fill_keys($includedGroups, true)
		);
	}

	public static function getAvailableOptions() {
		static $options = array(
			'error', 'warning', 'notice',
			'deprecated', 'strict standards',
			self::UNKNOWN_LEVEL_GROUP
		);
		return $options;
	}

	/**
	 * Read the last N entries from a PHP error log.
	 *
	 * @param int $count How many lines to read.
	 * @return array|WP_Error
	 */
	public function readLastEntries($count) {
		$filtered = array();

		foreach($this as $entry) {
			$filtered[] = $entry;

			if ( count($filtered) >= $count ) {
				break;
			}
		}

		return array_reverse($filtered);
	}

	/**
	 * Move to the next log entry that matches the filter settings.
	 */
	private function findMatchingEntry() {
		while ( $this->logIterator->valid() ) {
			$entry = $this->logIterator->current();
			if ( $this->isSeverityLevelIncluded($entry['level']) ) {
				break;
			}

			$this->skippedEntryCount++;
			$this->logIterator->next();
		}
	}

	private function isSeverityLevelIncluded($severityLevel) {
		if ( !isset($severityLevel) ) {
			$group = self::UNKNOWN_LEVEL_GROUP;
		} else if ( isset(self::$severityMap[$severityLevel]) ) {
			$group = self::$severityMap[$severityLevel];
		} else {
			$group = $severityLevel;
		}

		if ( !isset($this->isGroupIncluded[$group]) ) {
			$group = self::UNKNOWN_LEVEL_GROUP;
		}

		return $this->isGroupIncluded[$group];
	}

	public function getSkippedEntryCount() {
		return $this->skippedEntryCount;
	}

	public function formatSkippedEntryCount() {
		printf(
			_n(
				'%d entry was filtered out.',
				'%d entries were filtered out.',
				$this->getSkippedEntryCount(),
				'error-log-monitor'
			),
			$this->getSkippedEntryCount()
		);
	}

	/**
	 * Return the current log entry.
	 *
	 * @return array
	 */
	public function current() {
		return $this->logIterator->current();
	}

	/**
	 * Move forward to next log entry that matches the filter.
	 */
	public function next() {
		$this->logIterator->next();
		$this->findMatchingEntry();
	}

	/**
	 * Return the key of the current entry.
	 *
	 * @return mixed scalar on success, or NULL on failure.
	 */
	public function key() {
		return $this->logIterator->key();
	}

	/**
	 * Checks if current position is valid.
	 *
	 * @return boolean
	 */
	public function valid() {
		return $this->logIterator->valid();
	}

	/**
	 * Rewind the Iterator to the first entry that matches the filter.
	 */
	public function rewind() {
		$this->logIterator->rewind();
		$this->findMatchingEntry();
	}
}