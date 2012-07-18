<?php
use Abyss\Templates\XHTMLTemplate;

ob_start();

/* require_once("Abyss".DIRECTORY_SEPARATOR."Utilities".DIRECTORY_SEPARATOR."Timer.php");
Abyss\Utilities\Timer::start('index'); */

require_once("Abyss".DIRECTORY_SEPARATOR."Abyss.php");
/* Abyss\Utilities\Timer::printTime('index',"before init"); */

$abyss = Abyss\Abyss::create();
$abyss->init();


include "fw_test/simple_tpl.php";

/* Abyss\Utilities\Timer::printTime('index','end'); */
ob_flush();
?>