<?php 
namespace WordPressChecker;
interface ConnectInterface{
	public function setDomain($domain);
	public function connectTo();
}