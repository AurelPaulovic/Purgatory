<?php
use Abyss\DataModel\Object\tClonable;

require_once("Abyss".DIRECTORY_SEPARATOR."Abyss.php");

$abyss = Abyss\Abyss::create();
$abyss->init();

class Test extends Abyss\DataModel\Object\DataObject {
	use tClonable;
}

$o = new Test;
?>