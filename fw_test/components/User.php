<?php
class User extends Purgatory\Components\Component {
	public function data(DOMDocument $tpl) {
		$xpath = new DOMXPath($tpl);

		$nl = $xpath->query("//*[@id='name'][1]");
		$nl->item(0)->nodeValue = "Aurel";

		$ele = $tpl->createElement('div');
		$ele->setAttribute('abyss','User.test');
		$tpl->documentElement->appendChild($ele);
	}

	public function test($tpl) {
		$tpl->documentElement->nodeValue = "test";
	}

}