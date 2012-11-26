<?php

$dom = new \DOMDocument('1.0','UTF-8');
$dom->loadHTMLFile(__DIR__ ."/tpl/testPage.xhtml");

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

foreach($xpath->query("//p[ancestor-or-self::node()[@xml:lang='sk' or @lang='sk' or starts-with(@xml:lang, concat('sk','-')) or starts-with(@lang, concat('sk','-'))]]") as $ele) {
	/* @var $ele \DOMElement */
	$ele->setAttribute('style','color:red;');
}

echo "-------------<br />";
echo $dom->saveHTML();
