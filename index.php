<?php
ob_start();

require_once("Abyss".DIRECTORY_SEPARATOR."Utility".DIRECTORY_SEPARATOR."Timer.php");
require_once("Abyss".DIRECTORY_SEPARATOR."Abyss.php");

$abyss = Abyss\Abyss::create();
$abyss->init();


$query = 'div
		+
		div
		*
		 .test a[attr|=\'sk\'][attr=val]
		i b.nice[attr*=val]:last-child > span[attr="val > \' \" val2"][attr="val \" val2"]';
//$query = "ul > li span.name";

/* echo "<br />query: ",$query,"<br /><br />";

spl_autoload_register(function ($class) {
	if (0 === strpos(ltrim($class, '/'), 'Symfony\Component\CssSelector')) {
		if (file_exists($file = __DIR__.'/'.substr(str_replace('\\', '/', $class), 0).'.php')) {
			require_once $file;
		}
	}
});
use Symfony\Component\CssSelector\CssSelector;
CssSelector::toXPath($query);

Abyss\Utility\Timer::start('css');
print CssSelector::toXPath($query);
Abyss\Utility\Timer::printTime('css','Symfony');

Abyss\Utility\Timer::start('css');
print CssSelector::toXPath($query);
Abyss\Utility\Timer::printTime('css','Symfony'); */


Abyss\Utility\Css2XPath::process($query);

Abyss\Utility\Timer::start('css');
print Abyss\Utility\Css2XPath::process($query);
Abyss\Utility\Timer::printTime('css','Abyss');

Abyss\Utility\Timer::start('css');
print Abyss\Utility\Css2XPath::process($query);
Abyss\Utility\Timer::printTime('css','Abyss');


?>