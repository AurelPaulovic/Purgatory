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
abstract class DataColumn {
    private $value=null;

    function __construct($value) {
        $this->value = $value;
    }

    /**
     * Vrati hodnotu stlpca
     *
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Nastavi hodnotu stlpca
     *
     * @param mixed $value nova hodnota
     * @return DataColumn
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    function __toString() {
        return (string) $this->value;
    }
}