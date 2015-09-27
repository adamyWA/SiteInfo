<?php 
namespace WordPressChecker;
class Connect implements ConnectInterface {

public function setDomain($domain) {
	$this->domain = trim($domain);
}

public function connectTo() {
	try {
			$connection = file_get_contents('http://' . $this->domain);
			return $connection;
	} catch(\ErrorException $e) {
		return false;
	}
	return false;
	}
	


}