<?php
ob_start();

require_once("Abyss".DIRECTORY_SEPARATOR."Utilities".DIRECTORY_SEPARATOR."Timer.php");
Abyss\Utilities\Timer::start('index');

require_once("Abyss".DIRECTORY_SEPARATOR."Abyss.php");
Abyss\Utilities\Timer::printTime('index',"before init");

$abyss = Abyss\Abyss::create();
$abyss->init();

class CounterPage extends Abyss\Pages\StatefulPage {
	private $counter = 0;

 	public function getTemplate() {
		return "you have visited this page ".(++$this->counter)." time(s) <br/>";
	}

	public function getTemplatePath() {
		// TODO Auto-generated method stub
	}
}

class PageFactory {
	public static function getPage($pageName) {
		self::initSession();
		if(array_key_exists($pageName,$_SESSION['pages'])) return unserialize($_SESSION['pages'][$pageName]);

		return new $pageName;
	}

	public static function savePage($page) {
		$_SESSION['pages'][get_class($page)] = serialize($page);
	}

	private static function initSession() {
		static $run = false;
		if($run) return;
		$run=true;

		session_start();
		if(!array_key_exists('pages',$_SESSION)) $_SESSION['pages'] = array();
	}
}

if(array_key_exists('page',$_GET)) {
	Abyss\Utilities\Timer::printTime('index','before getting page');
	if($_GET['page']==='counter') {
		$page = PageFactory::getPage('CounterPage');
		echo $page->getTemplate();
		PageFactory::savePage($page);
	}
}
Abyss\Utilities\Timer::printTime('index','end');

ob_flush();
?>