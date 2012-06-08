<?php
namespace Abyss\DataModel\Object;
use \Abyss\DataModel\Column as Col;

/**
 *
 * @author APA
 *
 * TODO: change doc language
 *
 */
abstract class DataObject implements \ArrayAccess, \IteratorAggregate, iClonable {

    /********************
     * IteratorAggregate interface
     ********************/
    /**
     * Vrati iterator (pouzije sa vo foreach)
     * @return DataColumnIterator
     */
    public function getIterator() {
        return new Col\DataColumnIterator($this->getPublicDataColumns());
    }

    /**
     * Vrati pole datovych stlpcov datoveho objektu
     * @return array
     */
    public function getPublicDataColumns() {
        $return = DataObjectInspector::getDOPublicDOC($this);
        $this->publicDOCnames = array_keys($return);
        return $return;
    }

    /********************
     * ArrayAccess interface
     ********************/
    /**
     * Cache nazvov public datovych stlpcov objektu
     * @var array
     */
    private $publicDOCnames = array();

    /**
     * Zisti ci $offset existuje (musi ist o DataColumn)
     *
     * @see ArrayAccess::offsetExists()
     * @param string $offset nazov fieldu datoveho stlpca
     * @return boolean
     */
    public function offsetExists($offset) {
    	if(in_array($offset,$this->publicDOCnames,true) && isset($this->$offset)) return true;
    	else {
    		$this->publicDOCnames = array_keys(DataObjectInspector::getDOPublicDOC($this));
    		return in_array($offset,$this->publicDOCnames,true);
    	}
    }

    /**
     * Vrati hodnotu $offset ak je to DataColumn (vola {@link DataColumn::getValue()})
     *
     * @see ArrayAccess::offsetGet()
     * @param string $offset nazov fieldu datoveho stlpca
     * @return mixed hodnota stlpca
     */
    public function offsetGet($offset) {
    	if($this->offsetExists($offset)) {
    		return $this->$offset->getValue();
    	}
        return null;
    }

    /**
     * Nastavi hodnotu DataColumn na $offset na novu hodnotu $value
     * $this[$offset] musi existovat a musi byt typu DataColumn
     *
     * TODO: nezachovava celkom semantiku ArrayAccess::offsetSet ale asi to chceme nechat takto aby sme prinutili developerov definovat stlpce
     *
     * @throws InvalidArgumentException ak $this[$offset]neexistuje alebo je ineho typu ako DataColumn
     * @see ArrayAccess::offsetSet()
     * @param string $offset nazov fieldu datoveho stlpca
     * @param mixed $value nova hodnota
     * @return void
     */
    public function offsetSet($offset, $value) {
    	if($this->offsetExists($offset)) {
    		$this->$offset->setValue($value);
    	} else throw new \InvalidArgumentException("\$this[$offset] does not exist or is not DataColumn");
    }

    /**
     * Unsetne $offset ak ide o DataColumn
     *
     * @see ArrayAccess::offsetUnset()
     * @param string $offset nazov fieldu datoveho stlpca
     * @return void
     */
    public function offsetUnset($offset) {
    	if($this->offsetExists($offset)) {
    		unset($this->$offset);
    		$this->publicDOCnames = array_keys(DataObjectInspector::getDOPublicDOC($this));
    	}
    }
}
?>