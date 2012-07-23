<?php
namespace Abyss\DataModel\Object;
use \Abyss\DataModel\Column as Col;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\DataModel\Object
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
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
		foreach($tmp as $key=>&$val) {
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