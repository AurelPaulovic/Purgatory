<?php
namespace Abyss\Component;

/**
 * Requires the implementing object to be able to be persisted (serialize, unserialize, etc.)
 *
 * Default implementation: tAppPersistent, tUserPersistent
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\Component
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
 * */
interface iPersistent {
	/**
	 * Saves the state of the object to persistent store
	 *
	 * @return boolean
	 */
	public function save();

	/**
	 * Creates new instance of the object using the saved state or returns null
	 *
	 * @return Object|null
	 */
	public function load();
}

?>