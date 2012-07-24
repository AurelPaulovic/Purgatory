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
	 * @see \Abyss\Template\iQueryable::css()
	 */
	public function css($query) {
		// TODO Auto-generated method stub

		return new DOMNodeList();
	}

	/**
	 * @see \Abyss\Template\iQueryable::xp()
	 */
	public function xp($query) {
		// TODO Auto-generated method stub
	}

	/**
	 * @see \Abyss\Template\iQueryable::getNodeById()
	 */
	public function getNodeById($id) {
		// TODO Auto-generated method stub
	}

	/**
	 * @see \Abyss\Template\iQueryable::getNodesByClass()
	 */
	public function getNodesByClass($class) {
		// TODO Auto-generated method stub
	}

	/**
	 * @see \Abyss\Template\iQueryable::getNodesByName()
	 */
	public function getNodesByName($name) {
		// TODO Auto-generated method stub
	}

}