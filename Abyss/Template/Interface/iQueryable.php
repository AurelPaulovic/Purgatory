<?php
namespace Abyss\Template;

/**
 * Requires the implementing object to support querying by CSS and XPath selectors and a few convenience methods
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
 */
interface iQueryable {
	/**
	 * Queries the DOM object with a CSS query for a list of matching nodes
	 *
	 * @param string|Array $query single CSS query or an array of queries
	 * @return Abyss\Template\iDOMNodeList
	 */
	public function css($query);

	/**
	 * Queries the DOM object with a XPath query for a list of matching nodes
	 *
	 * @param string|Array $query single XPath query or an array of queries
	 * @return Abyss\Template\iDOMNodeList
	 */
	public function xp($query);

	/**
	 * Returns a Node with id attribute equals to $id
	 *
	 * Does NOT assume any constraints on ID names (e.g. starting with a letter), simply matches the $id as string.
	 * Does NOT perform check, if the Node is the only matching Node.
	 * In the case that multiple nodes should match (invalid document), returns the first node.
	 *
	 * @param string $id value of id attribute
	 * @return \Abyss\Template\iDOMNode the matching node or NULL if no such node exists
	 */
	public function getNodeById($id);

	/**
	 * Returns a list of nodes, whose class attribute contains $class
	 *
	 * Does NOT assume any constraints on class names (e.g. spaces), simply matches the $class as string
	 *
	 * @param string $class class name
	 * @return \Abyss\Template\iDOMNodeList list (possibly empty) of matching nodes
	 */
	public function getNodesByClass($class);

	/**
	 * Returns a list of nodes, whose name attribute equals to $name
	 *
	 * Does NOT assume any constraints on names (e.g. starting with a letter), simply matches the $name as string.
	 *
	 * @param string $name value of name attribute
	 * @return \Abyss\Template\iDOMNodeList list (possibly empty) of matching nodes
	 */
	public function getNodesByName($name);
}