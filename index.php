<?php
use Zend\Dom\Css2Xpath;

use Abyss\Templates\XHTMLTemplate;

ob_start();

require_once("Abyss".DIRECTORY_SEPARATOR."Utility".DIRECTORY_SEPARATOR."Timer.php");
/* Abyss\Utility\Timer::start('index'); */

//require_once("Abyss".DIRECTORY_SEPARATOR."Abyss.php");
/* Abyss\Utility\Timer::printTime('index',"before init"); */

/* $abyss = Abyss\Abyss::create();
$abyss->init(); */


//include "fw_test/simple_tpl.php";

/* Abyss\Utility\Timer::printTime('index','end'); */


spl_autoload_register(function ($class) {
	if (0 === strpos(ltrim($class, '/'), 'Symfony\Component\CssSelector')) {
		if (file_exists($file = __DIR__.'/'.substr(str_replace('\\', '/', $class), 0).'.php')) {
			require_once $file;
		}
	}
});

$query = 'div + div *    .test a[attr|=\'sk\'][attr=val] i b.nice[attr*=val]:last-child > span[attr="val > \' val2"][attr="val \" val2"]';
echo "<br />query: ",$query,"<br /><br />";

/* use Symfony\Component\CssSelector\CssSelector;
CssSelector::toXPath($query);

Abyss\Utility\Timer::start('css');
print CssSelector::toXPath($query);
Abyss\Utility\Timer::printTime('css','end');

Abyss\Utility\Timer::start('css');
print CssSelector::toXPath($query);
Abyss\Utility\Timer::printTime('css','end'); */

require "MyCSS/Css.php";
Css::process($query);

Abyss\Utility\Timer::start('css');
print Css::process($query);
Abyss\Utility\Timer::printTime('css','end');

Abyss\Utility\Timer::start('css');
print Css::process($query);
Abyss\Utility\Timer::printTime('css','end');


?>