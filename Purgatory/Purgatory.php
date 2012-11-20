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

namespace Purgatory;

/**
 * Main Purgatory framework class
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
final class Purgatory {
	/**
	 * Creates singleton instance of Purgatory framework
	 *
	 * @return Purgatory singleton instance of Purgatory framework
	 */
	public static function create() {
		static $abyss=null;

		if($abyss===null) $abyss = new self;
		return $abyss;
	}

	/**
	 * Private constructor
	 *
	 * @throws \ErrorException
	 * @return void
	 */
	private function __construct() {
		if(!spl_autoload_register(array($this,'autoloadHandler'))) throw new \ErrorException('Could not register Purgatory autoload handler.');
	}

	/**
	 * Initializes the Purgatory framework
	 *
	 * @return boolean true, if the initialization run successfully
	 */
	public function init() {
		static $ran=false;
		if($ran) return true;

		//TODO set default values, DI, etc.

		$ran=true;
		return true;
	}

	/**
	 * Autoload for Purgatory classes, interfaces and traits
	 *
	 * @param string $name name of the loading resurce
	 * @return void
	 */
	private function autoloadHandler($name) {
		static $root = NULL;
		if($root===NULL) $root = __DIR__ . DIRECTORY_SEPARATOR;

		$parts = explode('\\',$name);
		if($parts[0]==='Purgatory' && count($parts)>1) {
			array_shift($parts);
			$file = array_pop($parts) . '.php';
			$path = $root . implode(DIRECTORY_SEPARATOR,$parts) . DIRECTORY_SEPARATOR;

			$locations = array(
				$file,
				'Interface' . DIRECTORY_SEPARATOR . $file,
				'Trait' . DIRECTORY_SEPARATOR . $file
			);

			foreach($locations as $loc) {
				if(file_exists($path . $loc)) {
					require($path . $loc);
					return;
				}
			}
		}
	}
}