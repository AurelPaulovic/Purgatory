<?php
namespace Abyss\Template;

class HTMLTemplate extends Template {
	private function __construct($file=null,$string=null) {
		parent::__construct('1.0','UTF-8');

		$options = LIBXML_COMPACT | LIBXML_NOWARNING | LIBXML_NOXMLDECL | LIBXML_PARSEHUGE;

		if($file!=null) $this->dom->loadHTMLFile($file,$options);
		else $this->dom->loadHTML($string,$options);
	}

	public static function loadFile($file) {
		//TODO nejaka kontrola suboru mozno
		return new self(realpath($file));
	}

	public static function loadString($tpl) {
		//TODO nejaka kontrola stringu mozno
		return new self(null,$tpl);
	}

	public function save() {
		return $this->dom->saveHTML();
	}
}