<?php
namespace Trojanbox\Config;

class Loader {
	
	private function __construct() {}
	
	public static function Factory($name = 'array') {
		if (empty($name)) $name = 'array';
		switch (strtolower($name)) {
			case 'array':
				return $arrayLists = new \Trojanbox\Config\ArrayLists\Center();
				break;
		} 
	}
}