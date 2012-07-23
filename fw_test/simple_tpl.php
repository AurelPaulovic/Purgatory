<?php
class TestNode implements \Abyss\Template\iDOMNode {
	/* (non-PHPdoc)
	 * @see \Abyss\Template\iDOMNode::detach()
	 */public function detach() {
		// TODO Auto-generated method stub
		}
}

$ele = new TestNode();
$list = new Abyss\Template\DOMNodeList(array($ele));
$list2 = new Abyss\Template\DOMNodeList($list);
$list3 = $list2->sliceList(0,1);

/*$tpl = Abyss\Template\XHTMLTemplate::loadFile("fw_test/tpl/testPage.xhtml");
$tpl->process();
echo $tpl->save(); */