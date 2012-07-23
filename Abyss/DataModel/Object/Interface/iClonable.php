<?php
namespace Abyss\DataModel\Object;

/**
 * Requires the implementing object to be clonable
 *
 * Default implementation: tClonable
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\DataModel\Object
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
 */
interface iClonable {
	/**
	 * @see __clone()
	 * @return void
	 */
	public function __clone();
}
?>