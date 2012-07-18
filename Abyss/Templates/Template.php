<?php
namespace Abyss\Templates;

abstract class Template {
	/**
	 * @var \DOMDocument
	 */
	protected $dom = null;

	protected function __construct($version,$encoding) {
		$this->dom = new \DOMDocument($version,$encoding);
	}

	public static abstract function loadFile($file);

	public static abstract function loadString($string);

	public abstract function save();

	public function process() {
		$xpath = new \DOMXpath($this->dom);
		$context = $this->dom;

		while(($nodeList = $xpath->query("//*[@abyss][1]")) !==false and $nodeList->length > 0) {
			/* @var $nodeList \DOMNodeList */
			$element = $nodeList->item(0);
			/* @var $element \DOMElement */
			list($class,$func,$para) = array_pad(preg_split('/(\.|\?)/', $element->getAttribute('abyss'),3),3,null);
			$element->removeAttribute('abyss');

			if($para!==null) parse_str($para,$para);

			if(file_exists("fw_test/components/$class.php")) {
				include_once("fw_test/components/$class.php");
				$o = new $class();

				$newDom = new \DOMDocument();
				$newNode = $newDom->importNode($element,true);
				$newDom->appendChild($newNode);

				$o->$func($newDom);

				$element->parentNode->replaceChild($this->dom->importNode($newDom->documentElement,true), $element);
			} else throw new \Exception("'$class': no such class");
		}
	}
}
