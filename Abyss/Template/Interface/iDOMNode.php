<?php
namespace Abyss\Template;

interface iDOMNode {
	/**
	 * Detaches the node from its DOM
	 *
	 * @return iDOMNode $this
	 */
	public function detach();
}