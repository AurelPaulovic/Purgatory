<?php
namespace Abyss\DataModel\Column;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\DataModel\Column
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
 */
class DataColumnIterator implements \Iterator {
    private $cols = array();

    function __construct($cols) {
        $this->cols = $cols;
    }

    /**
     * @see Iterator::current()
     * @return DataColumn
     */
    public function current() {
        return current($this->cols);
    }

    /**
     * @see Iterator::next()
     * @return void
     */
    public function next() {
        next($this->cols);
    }

	/**
	 * @see Iterator::key()
	 * @return mixed
	 */
    public function key() {
        return key($this->cols);
    }

	/**
	 * @see Iterator::valid()
	 * @return boolean
	 */
    public function valid() {
        $key = key($this->cols);
        return ($key!==NULL && $key!==FALSE);
    }

	/**
	 * @see Iterator::rewind()
	 * @return void
	 */
    public function rewind() {
        reset($this->cols);
    }


}