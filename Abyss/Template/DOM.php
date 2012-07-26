<?php
namespace Abyss\Template;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
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
	 * @see \Abyss\Template\iQueryable::css()
	 */
	public function css($query) {
		$xquery = $this->css2xpath($query);
		if($xquery === NULL) return new DOMNodeList();

		return $this->xp($xquery);
	}

	/**
	 * @see \Abyss\Template\iQueryable::xp()
	 */
	public function xp($query) {
		if($this->xpath === NULL) $this->xpath = new \DOMXPath($this->dom);

		$tmpList = $this->xpath->query($query);
		if($tmpList === false) return new DOMNodeList();
		else new DOMNodeList($tmpList);
	}

	/**
	 * @see \Abyss\Template\iQueryable::getNodeById()
	 */
	public function getNodeById($id) {
		$nodes = $this->xp("//*[@id='$id']");
		return ($nodes->getLength() === 0 ? NULL : $nodes->getNode(0));
	}

	/**
	 * @see \Abyss\Template\iQueryable::getNodesByClass()
	 */
	public function getNodesByClass($class) {
		return $this->xp("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");
	}

	/**
	 * @see \Abyss\Template\iQueryable::getNodesByName()
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
	 * @return string XPath query or NULL, if could not convert the query
	 */
	private function css2xpath($query) {
		//TODO stub

		return NULL;
	}
}