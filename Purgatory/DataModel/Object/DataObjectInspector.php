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
use \Purgatory\DataModel\Column as Col;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory\DataModel\Object
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
abstract class DataObjectInspector {
	/**
	 * Vrati asociativne pole public fieldov objektu $o, ktore su datovymi stlpcami
	 *
	 * @param DataObject $o
	 * @return array asociativne pole public fieldov a ich datovych stlpcov
	 */
	public static final function getDOPublicDOC(DataObject $o) {
		$tmp = get_object_vars($o);
		$result = array();
		foreach($tmp as $key => &$val) {
			if($val instanceof Col\DataColumn) $result[$key] = $val;
		}
		return $result;

/* 		return array_filter(get_object_vars($o),
							function(&$col) {
								return $col instanceof Col\DataColumn;
							}); */
	}

	public static final function getDOC(DataObject $o) {
		return get_object_vars($o);
	}
}