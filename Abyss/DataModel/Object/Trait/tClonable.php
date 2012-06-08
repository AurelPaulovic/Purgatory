<?php
namespace Abyss\DataModel\Object;
use \Abyss\DataModel\Column\DataColumn;

/**
 * Default implementation of iClonable for DataObject
 *
 * @author APA
 * @since 0.1
 * @version 0.1
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