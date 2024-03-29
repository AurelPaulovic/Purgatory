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
class DOM implements iQueryable {
	/**
	 * Attached DOM
	 * @var \DOMDocument
	 */
	private $dom = null;

	/**
	 * XPath instance
	 * @var \DOMXPath
	 */
	private $xpath = null;

	/**
	 * @see \Purgatory\Template\iQueryable::css()
	 */
	public function css($query) {
		$xquery = $this->css2xpath($query);
		if($xquery !== null) {
			try { //we do this just to get a proper source of the exception, the does not need to know, that we do CSS to XPath translation
				return $this->xp($xquery);
			} catch(\Exception $e) {}
		}

		throw new \InvalidArgumentException("The query '$query' is invalid.");
	}

	/**
	 * @see \Purgatory\Template\iQueryable::xp()
	 */
	public function xp($query) {
		if($this->xpath === null) $this->xpath = new \DOMXPath($this->dom);

		$tmpList = $this->xpath->query($query);
		if($tmpList === false) throw new \InvalidArgumentException("The query '$query' is invalid.");
		else new DOMNodeList($tmpList);
	}

	/**
	 * @see \Purgatory\Template\iQueryable::getNodeById()
	 */
	public function getNodeById($id) {
		$nodes = $this->xp("//*[@id='$id']");
		return ($nodes->getLength() === 0 ? null : $nodes->getNode(0));
	}

	/**
	 * @see \Purgatory\Template\iQueryable::getNodesByClass()
	 */
	public function getNodesByClass($class) {
		return $this->xp("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");
	}

	/**
	 * @see \Purgatory\Template\iQueryable::getNodesByName()
	 */
	public function getNodesByName($name) {
		return $this->xp("//*[@name='$name']");
	}

	/**
	 * Converts CSS selector query to XPath query
	 *
	 * TODO: possibly refactor to utility class
	 *
	 * @param string $query CSS query
	 * @return string XPath query or null, if could not convert the query
	 */
	private function css2xpath($query) {
		//TODO stub

		return null;
	}
}