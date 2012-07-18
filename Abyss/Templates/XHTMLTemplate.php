<?php
namespace Abyss\Templates;

class XHTMLTemplate extends Template {

	protected function __construct($file=null,$string=null) {
		parent::__construct('1.0','UTF-8');

		$options = LIBXML_COMPACT | LIBXML_NOWARNING | LIBXML_NOXMLDECL | LIBXML_PARSEHUGE;

		if($file!=null) $this->dom->load($file,$options);
		else $this->dom->loadXML($string,$options);
	}

	public static function loadFile($file) {
		//TODO nejaka kontrola suboru mozno
		return new self(realpath($file));
	}

	public static function loadString($string) {
		//TODO nejaka kontrola stringu mozno
		return new self(null,$string);
	}

	public function save() {
		return $this->dom->saveXML();
	}
}