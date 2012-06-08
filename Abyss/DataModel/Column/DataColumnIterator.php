<?php
namespace Abyss\DataModel\Column;

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