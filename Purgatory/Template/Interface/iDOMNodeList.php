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
 * Requires the implementing object to provide \Iterator access to the Nodes in list, their sort, insertion and removal and an convenience detach function
 *
 * Objects implementing this interface are required to maintain the order of its elements and allow duplicates (the same node can be listed multiple times)
 *
 * @extends \Iterator
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
interface iDOMNodeList extends \Iterator {
	/**
	 * Detaches all nodes in list from the DOM
	 *
	 * Convenience function for:
	 * <pre>
	 * foreach(iDOMNodeList as iDOMNode) {
	 *     iDOMNode->detach();
	 * }
	 * </pre>
	 *
	 * If the nodes could be not detached, the function will return false and leave the nodes in incosistent state, i.e.:
	 * some nodes might be detached while others could be left attached
	 *
	 * @return boolean true, if the nodes were sucessfully detached, false if not
	 */
	public function detachAllNodes();

	/**
	 * Returns a new list consisting of nodes in the slice defined by its lower and upper bound indexes
	 *
	 * The indexes must be within interval <0,(getLength()-1)>
	 *
	 * @param integer $lowerBound lower index (zero based, inclusive)
	 * @param integer $upperBound (zero based, inclusive)
	 * @return \Purgatory\Template\iDOMNodeList new list
	 * @throws \OutOfBoundsException
	 */
	public function sliceList($lowerBound,$upperBound);

	/**
	 * Returns the number of nodes in list
	 *
	 * @return integer number of Nodes in list
	 */
	public function getLength();

	/**
	 * Prepends a Node to the list
	 *
	 * Does NOT insert the node into the DOM
	 *
	 * @param \Purgatory\Template\iDOMNode $node
	 * @return boolean true, if the node was successfully inserted to the list, false if not
	 */
	public function prependNodeToList(iDOMNode $node);

	/**
	 * Appends a Node to the list
	 *
	 * Does NOT insert the node into the DOM
	 *
	 * @param \Purgatory\Template\iDOMNode $node
	 * @return boolean true, if the node was successfully inserted to the list, false if not
	 */
	public function appendNodeToList(iDOMNode $node);

	/**
	 * Inserts a node into the list at the $pos
	 *
	 * The $pos must be from the interval <0,getLength()>. If the $pos is equal to the value
	 * of getLength() ({@link \Purgatory\Template\iDOMNodeList::getLength()}), the node will be
	 * inserted at the end of the list.
	 *
	 * Does NOT insert the node into the DOM
	 *
	 * @param integer $pos position in list (zero based, <0,getLength()>)
	 * @param \Purgatory\Template\iDOMNode $node new node
	 * @return boolean true, if the node was cussessfully inserted to the list, false if not
	 * @throws \OutOfBoundsException
	 */
	public function insertNodeInList($pos,iDOMNode $node);

	/**
	 * Removes node on the $pos from the list
	 *
	 * Does NOT delete or remove the node from its DOM
	 *
	 * @param integer $pos position of the node in list (zero based)
	 * @return \Purgatory\Template\iDOMNode the removed node
	 * @throws \OutOfBoundsException
	 */
	public function removeNodeFromList($pos);

	/**
	 * Returns the node at the $pos
	 *
	 * @param integer $pos position in list
	 * @return \Purgatory\Template\iDOMNode
	 * @throws \OutOfBoundsException
	 */
	public function getNode($pos);

	/**
	 * Sorts the Nodes in list
	 *
	 * <p>
	 * The comparsion function has to take two compared iDOMNode parameters (the compared nodes) and
	 * must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * </p>
	 *
	 * @param \Closure|callback $fnc comparsion function(\Purgatory\Template\iDOMNode $node1,\Purgatory\Template\iDOMNode $node2) returning integer
	 * @return void
	 */
	public function sortList($fnc);
}