<?php
namespace Abyss\Template;

/**
 * Requires the implementing object to support querying by CSS and XPath selectors
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
}