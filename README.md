## Requirements:
PHP version  >= 5.5
wkhtmltopdf >= 0.12.2.1 for screenshot generation.
_Get it at http://wkhtmltopdf.org_ 

http://www.github.com/mikehaertl's PHP wrapper for wkhtmltopdf.org

Installation via Composer:

composer require mikehaertl/phpwkhtmltopdf

## Example usage:

```php
use WordPressChecker\WordPress;

$site = new WordPress('example.com');

$isItWordPress = $site->isIt(); //Returns boolean true if site is running WordPress

if( $isItWordPress ) {
	$version = $site->getVersion(); //Returns false if version can't be detected, returns version as string if successful
	$theme = $site->getTheme(); //Returns false if theme isn't detected, returns an array with theme info if successful
	$screenshot = $site->getScreenshot(); //Returns relative path to generated screenshot of site

echo 'The site is running Wordpress version ' . $version ' and is running the theme ' .  $theme['THEME NAME'];
}
```

## Notes:

The documentation sucks I know, but the source is relatively self explanatory (but also poorly commented).

One thing to keep in mind about theme info: the array's keys will always be uppercase (since WP standards are pretty loose when it comes to a Theme's style.css).

If a theme is detected, at bare minimum you will find keys to match what WP requires, but depending on the theme you may have more keys/values. See here for explanation: https://codex.wordpress.org/File_Header


