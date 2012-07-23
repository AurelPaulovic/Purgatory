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
interface iDOMNode {
	/**
	 * Detaches the node from its DOM
	 *
	 * @return boolean true, if the Node was successfully detached from its DOM, false otherwise
	 */
	public function detach();
}