<?php
require_once 'Abyss\Template\Interface\iDOMNodeList.php';
require_once 'Abyss\Template\Interface\iDOMNode.php';
require_once 'Abyss\Template\DOMNodeList.php';

use Abyss\Template\DOMNodeList;
use Abyss\Template\iDOMNode;

require_once 'PHPUnit\Framework\TestCase.php';


class DOMNodeMock implements iDOMNode {
	public $id;

	public function detach() {
		return true;
	}

	public function setId($id) { $this->id = $id; return $this; }
}

/**
 * DOMNodeList test case.
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @copyright Copyright (c) 2012, Aurel Paulovic
 */
class DOMNodeListTest extends \PHPUnit_Framework_TestCase {

	/**
	 *
	 * @var DOMNodeList
	 */
	private $DOMNodeList;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();

		// TODO Auto-generated DOMNodeListTest::setUp()

		//$this->DOMNodeList = new DOMNodeList(/* parameters */);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated DOMNodeListTest::tearDown()
		//$this->DOMNodeList = null;

		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}

	/**
	 * Tests DOMNodeList->__construct()
	 *
	 * DOMNodeList::__construct() should support:
	 * - create empty
	 * - create from existing DOMNodeList
	 * - create from single iDOMNode
	 * - create from multiple iDOMNode-s in array or traversable
	 *
	 */
	public function test__construct() {
		//empty DOMNodeList
		$dnl = new DOMNodeList();
		$this->assertEquals(0,$dnl->getLength());

		//empty array
		$dnl = new DOMNodeList(array());
		$this->assertEquals(0,$dnl->getLength());


		$ele = new DOMNodeMock();
		$ele2 = new DOMNodeMock();

		//single ele
		$dnl = new DOMNodeList($ele);
		$this->assertEquals(1,$dnl->getLength());

		//multiple ele
		$dnl = new DOMNodeList(array($ele,$ele2,$ele));
		$this->assertEquals(3,$dnl->getLength());

		//made form other DOMNodeList
		$dnl = new DOMNodeList($ele);
		$dnl2 = new DOMNodeList($dnl);
		$this->assertEquals(1,$dnl2->getLength());
	}

	/**
	 * Test DOMNodeList->__construct()
	 *
	 * DOMNodeList::__construct() should fail if:
	 * - is costructed with a single non iDOMNode parameter
	 * - is costructed from array or traversable with some non iDOMNode parameter
	 */
	public function test__constructException() {
		//invalid single item
		try {
			$dnl = new DOMNodeList(new \stdClass());
			$this->fail("Expected InvalidArgumentException");
		} catch(\InvalidArgumentException $e) {}

		//multiple nodes, one item invalid
		try {
			$ele = new DOMNodeMock();
			$dnl = new DOMNodeList(array($ele,$ele,5));
			$this->fail("Expected InvalidArgumentException");
		} catch(\InvalidArgumentException $e) {}
	}

	/**
	 * Tests DOMNodeList->detachAllNodes()
	 */
	public function testDetachAllNodes() {
		$ele = new DOMNodeMock();
		$ele2 = new DOMNodeMock();
		$dnl = new DOMNodeList($ele,$ele,$ele2);

		$this->assertTrue($dnl->detachAllNodes());
	}

	/**
	 * Tests DOMNodeList->sliceList()
	 */
	public function testSliceList() {
		$ele1 = (new DOMNodeMock())->setId(1);
		$ele2 = (new DOMNodeMock())->setId(2);
		$ele3 = (new DOMNodeMock())->setId(3);
		$ele4 = (new DOMNodeMock())->setId(4);
		$ele5 = (new DOMNodeMock())->setId(5);

		$allEle = array($ele1,$ele2,$ele3,$ele4,$ele5);

		$dnl = new DOMNodeList($allEle);

		//all nodes
		$dnl2 = $dnl->sliceList(0,$dnl->getLength() - 1);
		$this->assertEquals($dnl->getLength(),count($allEle));
		$this->assertEquals($dnl2->getLength(),$dnl->getLength());

		$tmpAllEle = $allEle;
		foreach($dnl2 as $_ele) {
			$this->assertTrue(in_array($_ele,$tmpAllEle,true),"Failed to find the object instance");
			unset($tmpAllEle[array_search($_ele,$tmpAllEle,true)]);
		}
		$this->assertEquals(0,count($tmpAllEle));

		//only some nodes
		$dnl2 = $dnl->sliceList(1,3); //$ele2,$ele3,$ele4
		$this->assertEquals($dnl2->getLength(),3);

		$tmpAllEle = array($ele2,$ele3,$ele4);
		foreach($dnl2 as $_ele) {
			$this->assertTrue(in_array($_ele,$tmpAllEle,true),"Failed to find the object instance");
			unset($tmpAllEle[array_search($_ele,$tmpAllEle,true)]);
		}
		$this->assertEquals(0,count($tmpAllEle));
	}

	public function testSliceListException() {
		$ele1 = (new DOMNodeMock())->setId(1);
		$ele2 = (new DOMNodeMock())->setId(2);
		$ele3 = (new DOMNodeMock())->setId(3);
		$ele4 = (new DOMNodeMock())->setId(4);
		$ele5 = (new DOMNodeMock())->setId(5);

		$allEle = array($ele1,$ele2,$ele3,$ele4,$ele5);

		$dnl = new DOMNodeList($allEle);

		//lower bound
		try {
			$dnl2 = $dnl->sliceList(-1,1);
			$this->fail("Expected OutOfBoundsException 1");
		} catch(\OutOfBoundsException $e) {}

		//upper bound
		try {
			$dnl2 = $dnl->sliceList(0,$dnl->getLength());
			$this->fail("Expected OutOfBoundsException 2");
		} catch(\OutOfBoundsException $e) {}

		//both
		try {
			$dnl2 = $dnl->sliceList(-1,$dnl->getLength());
			$this->fail("Expected OutOfBoundsException 3");
		} catch(\OutOfBoundsException $e) {}

		//lower bound greater than upper bound
		try {
			$dnl2 = $dnl->sliceList(2,1);
			$this->fail("Expected OutOfBoundsException 4");
		} catch(\OutOfBoundsException $e) {}
	}

	/**
	 * Tests DOMNodeList->getLength()
	 */
	public function testGetLength() {
		$ele1 = new DOMNodeMock();
		$ele2 = new DOMNodeMock();

		//empty
		$dnl = new DOMNodeList();
		$this->assertEquals(0,$dnl->getLength());

		//single element
		$dnl = new DOMNodeList($ele1);
		$this->assertEquals(1,$dnl->getLength());

		//multiple elements with repeating of a single instance
		$dnl = new DOMNodeList(array($ele1,$ele2,$ele1));
		$this->assertEquals(3,$dnl->getLength());
	}

	/**
	 * Tests DOMNodeList->prependNodeToList()
	 */
	public function testPrependNodeToList() {
		$ele1 = (new DOMNodeMock())->setId(1);
		$ele2 = (new DOMNodeMock())->setId(2);
		$ele3 = (new DOMNodeMock())->setId(3);

		$dnl = new DOMNodeList(array($ele2,$ele3));
		$this->assertNotSame($ele1,$dnl->getNode(0));

		$dnl->prependNodeToList($ele1);
		$this->assertSame($ele1,$dnl->getNode(0));
	}

	/**
	 * Tests DOMNodeList->appendNodeToList()
	 */
	public function testAppendNodeToList() {
		$ele1 = (new DOMNodeMock())->setId(1);
		$ele2 = (new DOMNodeMock())->setId(2);
		$ele3 = (new DOMNodeMock())->setId(3);

		$dnl = new DOMNodeList(array($ele1,$ele2));
		$this->assertNotSame($ele3,$dnl->getNode($dnl->getLength()-1));

		$dnl->appendNodeToList($ele3);
		$this->assertSame($ele3,$dnl->getNode($dnl->getLength()-1));
	}

	/**
	 * Tests DOMNodeList->insertNodeInList()
	 */
	public function testInsertNodeInList() {
		$ele1 = (new DOMNodeMock())->setId(1);
		$ele2 = (new DOMNodeMock())->setId(2);
		$ele3 = (new DOMNodeMock())->setId(3);

		$dnl = new DOMNodeList();
		$this->assertEquals(0,$dnl->getLength(),"length 0");

		$dnl->insertNodeInList(0,$ele1);
		$this->assertEquals(1,$dnl->getLength(),"length 1");
		$this->assertSame($ele1,$dnl->getNode(0),"match ele1:");

		$dnl->insertNodeInList(1,$ele2);
		$this->assertEquals(2,$dnl->getLength(),"length 2");
		$this->assertSame($ele2,$dnl->getNode(1),"match ele2:");

		$dnl->insertNodeInList(1,$ele3);
		$this->assertEquals(3,$dnl->getLength(),"length 3");
		$this->assertSame($ele1,$dnl->getNode(0));
		$this->assertSame($ele2,$dnl->getNode(2));
		$this->assertSame($ele3,$dnl->getNode(1));

		$dnl->insertNodeInList(3,$ele1);
		$this->assertEquals(4,$dnl->getLength(),"length 4");
		$this->assertSame($ele1,$dnl->getNode(3));
	}

	public function testInsertNodeInListException() {
		$ele1 = new DOMNodeMock();
		$dnl = new DOMNodeList($ele1);

		try {
			$dnl->insertNodeInList(2,$ele1);
			$this->fail("Expected OutOfBoundsException");
		} catch(\OutOfBoundsException $e) {}

		try {
			$dnl->insertNodeInList(-1,$ele1);
			$this->fail("Expected OutOfBoundsException");
		} catch(\OutOfBoundsException $e) {}
	}

	/**
	 * Tests DOMNodeList->removeNodeFromList()
	 */
	public function testRemoveNodeFromList() {
		// TODO Auto-generated DOMNodeListTest->testRemoveNodeFromList()
		$this->markTestIncomplete("removeNodeFromList test not implemented");

		$this->DOMNodeList->removeNodeFromList(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->getNode()
	 */
	public function testGetNode() {
		// TODO Auto-generated DOMNodeListTest->testGetNode()
		$this->markTestIncomplete("getNode test not implemented");

		$this->DOMNodeList->getNode(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->sortList()
	 */
	public function testSortList() {
		// TODO Auto-generated DOMNodeListTest->testSortList()
		$this->markTestIncomplete("sortList test not implemented");

		$this->DOMNodeList->sortList(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->current()
	 */
	public function testCurrent() {
		// TODO Auto-generated DOMNodeListTest->testCurrent()
		$this->markTestIncomplete("current test not implemented");

		$this->DOMNodeList->current(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->key()
	 */
	public function testKey() {
		// TODO Auto-generated DOMNodeListTest->testKey()
		$this->markTestIncomplete("key test not implemented");

		$this->DOMNodeList->key(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->next()
	 */
	public function testNext() {
		// TODO Auto-generated DOMNodeListTest->testNext()
		$this->markTestIncomplete("next test not implemented");

		$this->DOMNodeList->next(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->rewind()
	 */
	public function testRewind() {
		// TODO Auto-generated DOMNodeListTest->testRewind()
		$this->markTestIncomplete("rewind test not implemented");

		$this->DOMNodeList->rewind(/* parameters */);
	}

	/**
	 * Tests DOMNodeList->valid()
	 */
	public function testValid() {
		// TODO Auto-generated DOMNodeListTest->testValid()
		$this->markTestIncomplete("valid test not implemented");

		$this->DOMNodeList->valid(/* parameters */);
	}
}

