<?php
class Css {
	const STATE_EMPTY = 1;
	const STATE_WHITESPACE = 2;
	const STATE_CLASS = 3;

	public static function process($query) {
		$matches = array();

		var_dump(
			 preg_split("/\s(?#						any whitespace characters can separate selectors
			 		)|(?U:([\"\'])((?:.*[^\\\\]+)*(?:(?:\\\\{2})*)+)\g{-2})(?#
					)|((?#							matched elements
					)\[(?#							attribute start
					)|\](?#							attribute end
					)|\.(?#							shorthand class selector
					)|[\~\^\*\$\|]?=(?#				attribute value operator
					)|:(?#							pseudo class
					)|\((\d*)n\s*[+-]\s*(\d*)\)(?#	pseudo class expression
					)(?#							values in quotes
					))/xu",$query,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)
		);

		return $query;
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