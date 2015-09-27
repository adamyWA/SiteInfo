<?php 
namespace WordPressChecker;
class Validator {
	
	public static function validateDomain($domain) {

		 if(@preg_match( '/^[a-z0-9 .\-]+$/i', $domain) == 1) {
			return true;
		 }
		return false;

	}
}