<?php
namespace Abyss\DataModel\Object;

/**
 * Requires the implementing object to be clonable
 *
 * Default implementation: tClonable
 *
 * @author APA
 * @since 0.1
 * @version 0.1
 */
interface iClonable {
	/**
	 * @see __clone()
	 * @return void
	 */
	public function __clone();
}
?>