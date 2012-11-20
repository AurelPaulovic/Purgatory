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

namespace Purgatory\Template;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
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
