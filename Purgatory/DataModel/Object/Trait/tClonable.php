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

namespace Purgatory\DataModel\Object;
use \Purgatory\DataModel\Column\DataColumn;

/**
 * Default implementation of iClonable for DataObject
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory\DataModel\Object
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
  */
trait tClonable {
	/**
	 * Clones DataColumns of the object
	 *
	 * @return void
	 */
	function __clone() {
		foreach(get_object_vars($this) as $key => $col) {
			if($col instanceof DataColumn)
				$this->$key = clone $col;
		}
	}
}


?>