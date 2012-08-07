<?php
/*
	Copyright 2012 Aurel Paulovic

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

		http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
*/

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
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
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