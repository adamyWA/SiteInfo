<?php
namespace WordPressChecker;
use \mikehaertl\wkhtmlto\Image;
class IsItWordPress extends Connect{

	
	const HOMEFLAG = '<meta name="generator" content="WordPress '; //finds WordPress on Home page
	const ADMINFLAG = '/wp-includes/css/buttons.min.css?ver=';	//finds WordPress on wp-admin
	const READMEFLAG = '/> Version ';	//finds WordPress at /readme.html
	

	
	private function connectWhere($domain) {
		$setDomain = $this->setDomain($domain);
		$connect = $this->connectTo();
		return $connect;
	}
	
	protected function getWpByHome($domain) {
		$connect = $this->connectWhere($domain);
		if($connect !== false) {
			if(strripos($connect, self::HOMEFLAG) !== false) {
				return $connect;
			}
			return false;
		}
		return false;
	}
	private function getWpByAdmin($domain) {
		$connect = $this->connectWhere($domain . '/wp-admin/');
		if($connect !== false) {
			if(strripos($connect, self::ADMINFLAG) !== false) {
				return $connect;
			}
			return false;
		}
		return false;
	}
	private function getWpByReadme($domain) {
		$connect = $this->connectWhere($domain . '/readme.html');
		if($connect !== false) {
			if(strripos($connect, self::READMEFLAG) !== false) {
				return $connect;
			}
		return false;
		}
	return false;
	}
	
	protected function setVersion($domain) {
		$getWpByReadme = $this->getWpByReadme($domain);
		$getWpByAdmin = $this->getWpByAdmin($domain);
		$getWpByHome = $this->getWpByHome($domain);

		
		if($getWpByReadme !== false) {
			$findReadmeFlag = (strripos($getWpByReadme, self::READMEFLAG));
			if($findReadmeFlag !== false) {
				$version = substr($getWpByReadme, $findReadmeFlag+11, 5);
				if(strripos($version, '.', 3) === false) {
					$version = substr($getWpByReadme, $findReadmeFlag+11, 3);
					}
					return $version;
				} 
			} elseif($getWpByAdmin !== false) {
				$findAdminFlag = (strripos($getWpByAdmin, self::ADMINFLAG));
				$version = substr($getWpByAdmin, $findAdminFlag+37, 5);
				if(strripos($version, '.', 3) === false) {
					$version = substr($getWpByAdmin, $findAdminFlag+37, 3);
				}
				return $version;
			} elseif($getWpByHome !== false) {
				$findHomeFlag = (strripos($getWpByHome, self::HOMEFLAG));
				$version = substr(trim($getWpByHome),$findHomeFlag+41, 6);
				if(strripos($version, '.', 4) === false) {
					$version = substr($getWpByHome, $findHomeFlag+41, 4);
				}
				return $version;
			}
			return false;	
			}
			
	protected function setTheme($domain) {
		$body = $this->connectWhere($domain);
		$results = false;
		$findTheme = strpos($body,'wp-content/themes/');
			
			$stringStart = $findTheme;
			
			$findIt = substr($body, $stringStart, 3000);
			$explosions = explode('/', $findIt);
			try {
				$css = file_get_contents('http://' . $domain . '/wp-content/themes/' . $explosions[2] . '/style.css');
			}
			catch(\ErrorException $e) {
				$stringStart = stristr($body, 'wp-content/themes/', true);
				$url = strrchr($stringStart, ':');
				$new = strstr($url, '//');
				$noFrontSlashes = str_ireplace('//', '', $new);
		
				$moreExplosions = explode('/', $noFrontSlashes); 
		
				$subDirectory = @$moreExplosions[1];
				try {
					$css = file_get_contents('http://' . $domain . '/' . $subDirectory . '/wp-content/themes/' . $explosions[2] . '/style.css'); 
				}
				catch(\ErrorException $e) {
				return false;
				}				
			}
			$css = str_replace( PHP_EOL, "|delimiter", $css );
			$css = explode('|delimiter', $css);
		
			foreach($css as $c) {
				$str = explode(': ', $c);
				if(array_key_exists(0, $str) && array_key_exists(1, $str))  {
					$str[0] = trim(preg_replace("/[^A-Za-z0-9 ]/", '', strtoupper($str[0])));
					$results[$str[0]] = $str[1];
				}
			} 
		return $results;

	}
	protected function setScreenshot($domain) {
		$options = ["type"=>"jpg", "ignoreWarnings"=>true];
		$image = new Image($this->domain);	
		$image->setOptions($options);
		$imageURL = 'images/' . $domain . '.jpg';
		$image->saveAs($imageURL);
		if(is_readable($imageURL)) {
			return $imageURL;
		}
		return false;
	}	
		
}

