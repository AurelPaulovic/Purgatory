<?php
namespace Abyss\Template;

/**
 * TODO
 *
 * Objects implementing this interface are required to maintain order of its elements and allow duplicates (the same node can be listed multiple times)
 *
 * @author APA
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\Template
 */
interface iDOMNodeList {
	/**
	 * Detaches all nodes in list from the DOM
	 *
	 * @return Abyss\Template\iDOMNodeList $this
	 */
	public function detachAllNodes();

	/**
	 * Returns a new list consisting of nodes in the slice defined by its lower and upper bound indexes
	 *
	 * @param integer $lowerBound lower index (zero based, inclusive)
	 * @param integer $upperBound (zero based, inclusive)
	 * @return Abyss\Template\iDOMNodeList new list
	 */
	public function sliceList($lowerBound,$upperBound);

	/**
	 * Returns the number of nodes in list
	 *
	 * @return integer number of Nodes in list
	 */
	public function getLength();

	/**
	 * Inserts a node into the list at the $index
	 *
	 * Does NOT insert the node into the DOM
	 *
	 * @param integer $idx index (zero based)
	 * @param Abyss\Template\iDOMNode $node new node
	 * @return Abyss\Template\iDOMNode inserted node \\TODO return the node or the list ?
	 */
	public function insertNodeInList($idx,Abyss\Template\iDOMNode $node);

	/**
	 * Removes node on the $index from the list
	 *
	 * Does NOT delete or remove the node from its DOM
	 *
	 * @param integer $idx index of the node (zero based)
	 * @return Abyss\Template\iDOMNode removed node \\TODO return the node or the list ?
	 */
	public function removeNodeFromList($idx);

	/**
	 * Returns the node at the $index
	 *
	 * @param integer $idx index
	 * @return Abyss\Template\iDOMNode
	 */
	public function getNode($idx);

	/**
	 * Sorts the Nodes in list
	 *
	 * <p>
	 * The comparsion function has to take two compared Abyss\Template\iDOMNode parameters (the compared nodes) and
	 * must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * </p>
	 *
	 * @param \Closure|callback $fnc comparsion function(Abyss\Template\iDOMNode $node1,Abyss\Template\iDOMNode $node2) returning integer
	 * @return void
	 */
	public function sortList($fnc);
}