<?php

/**
 *
 * [1] http://blog.stevenlevithan.com/archives/match-quoted-string#comment-41068 - regexp match for string in quotes
 *
 * @author Aurel Paulovic <aurel.paulovic@gmail.com>
 * @since 0.1
 * @version 0.1
 * @namespace Abyss\Template
 * @copyright Copyright (c) 2012, Aurel Paulovic
 * @license
 */
class Css {
	const STATE_EMPTY = 1;
	const STATE_WHITESPACE = 2;
	const STATE_CLASS = 3;

	/**
	 * TODO maybe do something about case
	 *
	 * @param unknown_type $query
	 * @throws \InvalidArgumentException
	 * @return Ambigous <string, unknown>
	 */
	public static function process($query) {
		$attrStack = array();
		$result = "descendant-or-self::";
		$element = '';
		$hasPosition = false;

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

		//var_dump($split);

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

			if($tok === ' ' || $tok === '>' || $tok === '+' || $tok === '~') {
				//new combinator means the end of attributes/pseudo-classes, we will flush the attribute stack into result
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

				if($tok === ' ') { //descendant combinator
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

	public static function processOld($query) {
		$result = "//";
		$state = self::STATE_EMPTY;

		$qs = strtolower($query) . ' ';

		for($i=0,$len=strlen($qs);$i<$len;$i++) {
			$char = $qs[$i];

			if($char==='.') {
				//class
			}

			if($char==='[') {
				//attribute
				$att = '';
				while(false) ;
			}

			if($char===':') {
				$i++;
				//pseudo class or pseudo element
				if($qs[$i]===':') {
					//pseudo element - not supported
					$pseudoEle = '::';
					while(('a' <= ($char = $qs[++$i]) && $char <= 'z') || ($char>=0 && $char <=9) || ($char==='-')) $pseudoEle.=$char;

					throw new \InvalidArgumentException("Not supported selector - pseudo element '$pseudoEle'");
				}

				//pseudo class
			}


			continue;

			//-- old

			if($char==='.') {
				$tok = '';
				while(($i+1)<$len && 'a' <= $qs[$i+1] && $qs[$i+1] <= 'z') $tok.=$qs[++$i];

				$result.='[contains(concat(\' \', normalize-space(@class), \' \'), \' ' . $tok . ' \')]';
				continue;
			}

			if($char>='a' && $char<='z') {
				$tok = $char;
				while(($i+1)<$len && 'a' <= $qs[$i+1] && $qs[$i+1] <= 'z') $tok.=$qs[++$i];

				$result.=$tok;
				continue;
			}

			if($char===' ') {
				$what = '//';
				while((++$i)<$len) {
					$char = $qs[$i];

					if($char==='>') $what = '/';
					elseif($char===' ');
					else {
						$i--;
						break;
					}
				}

				$result.=$what;
			}
		}

		return $result;
	}
}