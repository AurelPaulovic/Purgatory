<?php
namespace Abyss;

/**
 * Main Abyss framework class
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
 */
final class Abyss {
	/**
	 * Creates singleton instance of Abyss framework
	 *
	 * @return Abyss singleton instance of Abyss framework
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
		if(!spl_autoload_register(array($this,'autoloadHandler'))) throw new \ErrorException('Could not register Abyss autoload handler.');
	}

	/**
	 * Initializes the Abyss framework
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
	 * Autoload for Abyss classes, interfaces and traits
	 *
	 * @param string $name name of the loading resurce
	 * @return void
	 */
	private function autoloadHandler($name) {
		static $root = NULL;
		if($root===NULL) $root = realpath('.') . DIRECTORY_SEPARATOR;

		$parts = explode('\\',$name);
		if($parts[0]==='Abyss' && count($parts)>1) {
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