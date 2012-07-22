<?php
namespace Abyss\Utility;

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