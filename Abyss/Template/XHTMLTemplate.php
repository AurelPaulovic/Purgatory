<?php
/*
	Copyright 2012 Aurel Paulovic

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

		http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
*/

namespace Abyss\Template;

/**
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
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