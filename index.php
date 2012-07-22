<?php
use Abyss\Templates\XHTMLTemplate;

ob_start();

/* require_once("Abyss".DIRECTORY_SEPARATOR."Utilities".DIRECTORY_SEPARATOR."Timer.php");
Abyss\Utility\Timer::start('index'); */

require_once("Abyss".DIRECTORY_SEPARATOR."Abyss.php");
/* Abyss\Utility\Timer::printTime('index',"before init"); */

$abyss = Abyss\Abyss::create();
$abyss->init();


include "fw_test/simple_tpl.php";

/* Abyss\Utility\Timer::printTime('index','end'); */
ob_flush();
?>