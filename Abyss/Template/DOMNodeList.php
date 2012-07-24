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
class DOMNodeList implements iDOMNodeList {
	/**
	 * List of matched Nodes
	 * @var \Abyss\Template\iDOMNode[]
	 */
	private $list = array();

	/**
	 * Current number of Nodes in $this->list
	 * @var integer
	 */
	private $length = 0;

	/**
	 * Constructs a new DOMNodeList
	 *
	 * Optionally, Nodes that should be inserted into the list can be supplied as an argument
	 *
	 * @param \Traversable|array|\Abyss\Template\iDOMNode $nodes an array (\Traversable) of \Abyss\Template\iDOMNode-s or a single node
	 * @throws \InvalidArgumentException
	 */
	public function __construct($nodes = NULL) {
		if($nodes !== NULL ){
			if(is_array($nodes) || $nodes instanceof \Traversable) {
				//an array of nodes
				foreach($nodes as $node) {
					if($node instanceof iDOMNode) $this->list[] = $node;
					else throw new \InvalidArgumentException('All elements in $nodes must implement the \Abyss\Template\iDOMNode interface.');
				}
			} elseif($nodes instanceof iDOMNode) {
				//single node
				$this->list[] = $nodes;
			} else {
				//any other value
				throw new \InvalidArgumentException('Argument $nodes is not of supported type \Traversable|array|\Abyss\Template\iDOMNode');
			}
		}

		$this->length = count($this->list);
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::detachAllNodes()
	 */
	public function detachAllNodes() {
		foreach($this->list as $ele) {
			/* @var $ele \Abyss\Template\iDOMNode */
			if(!$ele->detach()) {
				//should never happen; if it does, some nodes might be left detached and others attached
				return false;
			}
		}

		return true;
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::sliceList()
	 */
	public function sliceList($lowerBound, $upperBound) {
		$tmpList = array();

		$_lowerBound = (integer) $lowerBound;
		$_upperBound = (integer) $upperBound;
		if($_lowerBound > $_upperBound) throw new \OutOfBoundsException("\$lowerBound ($lowerBound given) must be not greater than \$upperBound ($upperBound)");
		if($_lowerBound < 0 || $_upperBound >= $this->length) throw new \OutOfBoundsException("Given bounds are not within the range <0,(getLength()-1)> ($lowerBound,$upperBound given)");

		return new self(array_slice($this->list,$_lowerBound,(1 + $_upperBound - $_lowerBound)));
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::getLength()
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::prependNodeToList()
	 */
	public function prependNodeToList(iDOMNode $node) {
		$this->length = array_unshift($this->list,$node);
		return true;
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::appendNodeToList()
	 */
	public function appendNodeToList(iDOMNode $node) {
		$this->length = array_push($this->list,$node);
		return true;
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::insertNodeInList()
	 */
	public function insertNodeInList($pos,iDOMNode $node) {
		$_pos = (integer) $pos;
		if($_pos < 0 || $_pos > $this->length) throw new \OutOfBoundsException("Provided position \$pos ($pos given) is not a valid position.");

		array_splice($this->list,$_pos,0,array($node));
		$this->length++;

		return true;
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::removeNodeFromList()
	 */
	public function removeNodeFromList($pos) {
		$_pos = (integer) $pos;
		//this covers also the case when there are no elements in the list
		if($_pos < 0 || $_pos >= $this->length) throw new \OutOfBoundsException("Provided position \$pos ($pos given) is not a valid position.");

		$node = $this->list[$_pos];
		array_splice($this->list,$_pos,1);
		$this->length--;

		return $node;
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::getNode()
	 */
	public function getNode($pos) {
		$_pos = (integer) $pos;
		if($_pos < 0 ||  $_pos >= $this->length) throw new \OutOfBoundsException("Provided position \$pos ($pos given) is not a valid position.");

		return $this->list[$_pos];
	}

	/**
	 * @see \Abyss\Template\iDOMNodeList::sortList()
	 */
	public function sortList($fnc) {
		usort($this->list,$fnc);
	}

	/***************
	 * Iterator implementation
	 ***************/
	/**
	 * Current position of the iterator in list
	 * @var integer
	 */
	private $p_position = NULL;

	/**
	 * Returns the current Node
	 *
	 * @implements \Iterator::current()
	 * @return Abyss\Template\iDOMNode current Node
	 */
	public function current () {
		return ($this->p_position === NULL ? NULL : $this->list[$this->p_position]);
	}

	/**
	 * Returns the current iterator position in list
	 *
	 * @implements \Iterator::key()
	 * @return integer current position in list or NULL on failure
	 */
	public function key() {
		return $this->p_position;
	}

	/**
	 * Advances the current iterator position to next element
	 *
	 * @implements \Iterator::next();
	 * @return void
	 */
	public function next() {
		if($this->length <= (++$this->p_position)) $this->p_position = NULL;
	}

	/**
	 * Rewinds the iterator position to the first element
	 *
	 * @implements \Iterator::rewind();
	 * @return void
	 */
	public function rewind() {
		if($this->length === 0) $this->p_position = NULL;
		else $this->p_position = 0;
	}

	/**
	 * Checks if current iterator position is valid
	 *
	 * @implements \Iterator::valid()
	 * @return boolean true, if the iterator position is valid, false otherwise
	 */
	public function valid() {
		return ($this->p_position === NULL ? false : true);
	}
}