<?php

$dom = new \DOMDocument('1.0','UTF-8');
$dom->loadHTMLFile("fw_test/tpl/testPage.xhtml");

$xpath = new \DOMXPath($dom);

$lastEle = null;
foreach($xpath->query("//span") as $ele) {
	/* @var $ele \DOMElement */
	echo $ele->getAttribute('id'),"<br />";
	$lastEle = $ele;
}

echo "-------------<br />";

$ele = $dom->createElement('span','newly created span');
$ele->setAttribute('id', 'gender');
$lastEle->appendChild($ele);

foreach($xpath->query("//*[@id='gender']") as $ele) {
	/* @var $ele \DOMElement */
	echo $ele->getAttribute('id'),"<br />";
}

echo "-------------<br />";
echo $dom->saveHTML();
