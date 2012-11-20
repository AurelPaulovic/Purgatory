<?php
ob_start();

require_once("Purgatory".DIRECTORY_SEPARATOR."Utility".DIRECTORY_SEPARATOR."Timer.php");
require_once("Purgatory".DIRECTORY_SEPARATOR."Purgatory.php");

$abyss = Purgatory\Purgatory::create();
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

Purgatory\Utility\Timer::start('css');
print CssSelector::toXPath($query);
Purgatory\Utility\Timer::printTime('css','Symfony');

Purgatory\Utility\Timer::start('css');
print CssSelector::toXPath($query);
Purgatory\Utility\Timer::printTime('css','Symfony'); */


Purgatory\Utility\Css2XPath::process($query);

Purgatory\Utility\Timer::start('css');
print Purgatory\Utility\Css2XPath::process($query);
Purgatory\Utility\Timer::printTime('css','Purgatory');

Purgatory\Utility\Timer::start('css');
print Purgatory\Utility\Css2XPath::process($query);
Purgatory\Utility\Timer::printTime('css','Purgatory');


?>