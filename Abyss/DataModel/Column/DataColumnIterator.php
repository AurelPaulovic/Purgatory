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

namespace Abyss\DataModel\Column;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\DataModel\Column
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
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