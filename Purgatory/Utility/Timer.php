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

namespace Purgatory\Utility;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory\Utility
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
class Timer {
	static $timers = array();

	public static function start($name) {
		self::$timers[$name]=microtime(true);
	}

	public static function printTime($name,$msg=null) {
		if(array_key_exists($name,self::$timers)) {
			echo "\n<br />",($msg===null?"":$msg.": "),(microtime(true) - self::$timers[$name])*1000,"ms<br />\n";
		} else throw new \ErrorException("No such timer: $name");
	}
}