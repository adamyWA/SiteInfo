<?php
namespace WordPressChecker;

interface WordPressInterface {
	public function getVersion();
	public function getTheme();
	public function getScreenshot();
	public function isIt();
}