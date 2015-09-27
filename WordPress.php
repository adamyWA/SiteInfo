<?php 
namespace WordPressChecker;

class WordPress extends IsItWordPress implements WordPressInterface {

public function __construct($domain) {
	$this->domain = $domain;
}
	public function getTheme() {
		$theme = $this->setTheme($this->domain);
		return $theme;
	}

	public function getVersion() {
		$version = $this->setVersion($this->domain);
		return $version;
	}
	public function isIt() {
		try {
			$getWpByHome = file_get_contents('http://' . $this->domain);
		} catch(\Exception $e) {
			return false;
		}
		$findHomeFlag = (strpos($getWpByHome, 'wp-content/'));
		if($findHomeFlag !== false) {
			return true;
		}
		return false;
	}
	public function getScreenshot() {
		$screenshot = $this->setScreenshot($this->domain);
		return $screenshot;
	}
}