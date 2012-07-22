<?php
namespace Abyss\Component;

/**
 * Requires the implementing object to be able to be persisted (serialize, unserialize, etc.)
 *
 * Default implementation: tAppPersistent, tUserPersistent
 *
 * @author APA
 * @since 0.1
 * @version 0.1
 */
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