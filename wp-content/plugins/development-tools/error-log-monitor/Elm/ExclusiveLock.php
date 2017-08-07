<?php
class Elm_ExclusiveLock {
	protected $handle = null;
	protected $isAcquired = false;
	protected $fileName;

	public function __construct($name) {
		//Usually the /wp-content/uploads directory is writable. Use that to store lock files.
		$uploads = wp_upload_dir();
		$this->fileName = $uploads['basedir'] . '/' . $name . '.lock';
		$this->handle = fopen($this->fileName, 'w+');
	}

	public function acquire() {
		//Don't try to take the same lock twice.
		if ( $this->isAcquired ) {
			return true;
		}
		if ( !$this->handle ) {
			return false;
		}

		if ( flock($this->handle, LOCK_EX) ) {
			$this->isAcquired = true;
			fwrite($this->handle, 'Locked on ' . date('c')); //For debugging.
		} else {
			trigger_error(
				sprintf('%s::%s failed to acquire a lock on file "%s"', __CLASS__, __METHOD__, $this->fileName),
				E_USER_WARNING
			);
		}
		return $this->isAcquired;
	}

	public function release() {
		if ( $this->handle && $this->isAcquired ) {
			flock($this->handle, LOCK_UN);
			$this->isAcquired = false;
		}
	}

	public function __destruct() {
		if ( $this->isAcquired ) {
			$this->release();
		}
		if ( $this->handle ) {
			fclose($this->handle);
		}
	}
}