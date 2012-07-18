<?php



$tpl = Abyss\Templates\XHTMLTemplate::loadFile("fw_test/tpl/testPage.xhtml");
$tpl->process();
echo $tpl->save();