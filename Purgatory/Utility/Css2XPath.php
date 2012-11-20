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

namespace Purgatory\Utility;

/**
 * The class provides a simple CSS3 Selectors to XPath 1.0 translation
 *
 * <p>
 * The main reason for building this parser was to get a faster alternative to Symfony's CssSelector [2],
 * which performed relatively poorly on even slightly more complicated selectors. While the mentioned component
 * is a proper OO parser, that checks the syntax, etc., it is also considerably more complex and slower, due to
 * lots of objects instantinated while parsing the selector. On the other hand, other publicly available solutions like Zend's Css2Xpath [3]
 * and various others, were lacking support for many selectors.
 * </p>
 *
 * <p>
 * The main use of the parser is to translate hard-coded selectors in DOM manipulation part of the Purgatory framework. These
 * selectors will be written by developers as an (although slower) easier alternative to relatively complicated XPath 1.0
 * syntax. Therefore, the parser does not need to handle or check for invalid syntax in a fancy way. It simply translates
 * the selector or throws an exception, in the case of an unsupported selector. No other checks, like allowed character codes,
 * number of pseudo-classes, etc. are performed.
 * </p>
 *
 * <p>
 * References:
 * [1] http://blog.stevenlevithan.com/archives/match-quoted-string#comment-41068 - regexp match for string in quotes
 * [2] https://github.com/symfony/CssSelector - Symfony CssSelector component
 * [3] https://github.com/zendframework/zf2/blob/master/library/Zend/Dom/Css2Xpath.php - ZendFramework Css2Xpath
 * </p>
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Purgatory\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license ALv2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
class Css2XPath {
	/**
	 * TODO maybe do something about case
	 *
	 * @param string $query
	 * @param string $leadAxis
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	public static function process($query, $leadAxis = 'descendant-or-self') {
		/*
		 * This is a long method, but I don't want to split it for performance reasons, bear with me
		 */

		$attrStack = array();
		$result = $leadAxis . '::';
		$element = null;
		$hasPosition = false;
		$nl = ord(PHP_EOL);

		$split = preg_split("/(?:\s*)([\+\>\~])(?:\s*)	(?# combinators, other than 'descendant' )
						|(\s)(?:\s*)					(?# any whitespace characters can separate selectors - we catch only the first, dump the rest -> we need to have atleast one to recognize descendant combinator )
			 			|(?:\s*)(?U:([\"\'])((?:.*[^\\\\]+)*(?:(?:\\\\{2})*)+)\g{-2})	(?# all values enclosed in quotes, accouting for escaped quotes in value, modified from \cite{1})
						|(?:\s*)([\+\>\~])(?:\s*)					(?# combinators, other than 'descendant' )
						|(?:\s*)(						(?# -- start of simple matches -- )
						\[								(?# attribute start )
						|\]								(?# attribute end )
				 		|\#								(?# shorthand for ID attribute)
						|\.								(?# shorthand for class selector )
						|[\~\^\*\$\|]?=					(?# attribute value operator )
						|:								(?# pseudo class )
						|::								(?# pseudo element )
						|\((\d*)n\s*[+-]\s*(\d*)\)		(?# pseudo class expression )
						)/xu",$query,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

//		var_dump($split);

		for($i=0,$len=count($split);$i<$len;$i++) {
			$tok = $split[$i];

			if($tok === '.') { //class selector
				$attrStack[] = "(contains(concat(' ', normalize-space(@class), ' '), ' {$split[++$i]} '))";
				continue;
			}

			if($tok === '#') { //ID selector
				$attrStack[] = "(@id='{$split[++$i]}')";
				continue;
			}

			if($tok === '[') { //attribute selector
				$attr = $split[++$i];
				$op = $split[++$i];
				$quot = $split[++$i];

				if($quot === '"' || $quot === '\'') {
					$val = $split[++$i];
				} else {
					$val = $quot;
				}

				if($split[++$i] !== ']') {
					if($quot === $val) $quot = '';
					throw new \InvalidArgumentException("Invalid attribute syntax '{$attr}{$op}{$quot}{$val}{$quot}{$split[$i]}'");
				}

				//TODO we need to fix unescaped single quotes

				if($op === '=') {
					$attrStack[] = "(@$attr='$val')";
				} elseif($op === '~=') {
					$attrStack[] = "(contains(concat(' ', normalize-space(@$attr), ' '), ' {$val} '))";
				} elseif($op === '^=') {
					$attrStack[] = "(starts-with(@$attr,'$val'))";
				} elseif($op === '*=') {
					$attrStack[] = "(contains(@$attr,'$val'))";
				} elseif($op === '$=') {
					$attrStack[] = "(substring(@$attr, string-length(@$attr)-" . (mb_strlen($val) - 1) . ") = '$val')";
				} else { // |=
					$attrStack[] = "((@$attr='$val') or starts-with(@$attr,'{$val}-'))";
				}

				continue;
			}

			if($tok === ':') { //pseudo class TODO
				//root only-child first-of-type last-of-type  only-of-type empty
				//nth-child nth-last-child nth-of-type nth-last-of-type
				//lang enabled disabled checked not

				$pclass = $split[++$i];
				if($pclass === 'first-child') {
					$attrStack[] = '(position() = 1)';
					$hasPosition = true;
				} elseif($pclass === 'last-child') {
					$attrStack[] = '(position() = last())';
					$hasPosition = true;
				} else {
					throw new \InvalidArgumentException("Unsupported selector - pseudo-class '$pclass'");
				}
				continue;
			}

			if($tok === '::') { //pseudo element
				throw new \InvalidArgumentException("Unsupported selector - pseudo-element '::{$split[++$i]}'");
			}

			/*
			 * combinators and new elements
			 */
			if($tok === ' ' || $tok === '>' || $tok === '+' || $tok === '~' || ord($tok) === $nl) {
				/* The ord($tok) === $nl, where $nl = ord(PHP_EOL) matches a newline
				 * Since in our preg_split, we take only the first whitespace character, this can be either \r (in the case of \r\n)
				 * or \n (in the case of \n), depending on the OS the script is running on. Therefore, we need to check against the
				 * first char in PHP_EOL, to find a newline (or what is left of it after preg_split)
				 */

				// new combinator means the end of attributes/pseudo-classes, we will flush the attribute stack into result
				// however, before we flush attributes, we need to check, if we got an simple element selector, if not, let's use a wildcard
				if($element === null) $result .= '*';
				else  {
					if($hasPosition === true) {
						$hasPosition = false;
						$attrStack[] = "(name() = '$element')";
						$result .= '*';
					} else $result .= $element;

					$element = null;
				}

				if(!empty($attrStack)) {
					$result .= '[' . implode(' and ',$attrStack) . ']';
					$attrStack = array();
				}

				if($tok === '+') { //adjacent sibling combinator
					$result .= '/following-sibling::';
					$attrStack[] = '(position() = 1)';
					$hasPosition = true;
					continue;
				}

				if($tok === '>') { //child combinator
					$result .= '/';
					continue;
				}

				if($tok === '~') { //general sibling combinator
					$result .= '/following-sibling::';
					continue;
				}

				if($tok === ' ' || ord($tok) === $nl) { //descendant combinator
					$result .= '/descendant::';
					continue;
				}
			}

			//nothing matched, means that we got a simple element selector
			//save it and use later, when we now if we are matching some position (if we use position, we need to use element name via name() function)
			$element = $tok;
		}

		//flush nonterminated stuff (copy/paste from loop)
		if($element === null) $result .= '*';
		else  {
			if($hasPosition === true) {
				$hasPosition = false;
				$attrStack[] = "(name() = '$element')";
				$result .= '*';
			} else $result .= $element;

			$element = null;
		}

		if(!empty($attrStack)) {
			$result .= '[' . implode(' and ',$attrStack) . ']';
			$attrStack = array();
		}

		return $result;
	}
}