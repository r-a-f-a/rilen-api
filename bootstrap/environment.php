<?php

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/
if (!getenv('APP_ENV')) {
	putenv('APP_ENV=production');
}
/*
 * TESTING SETTINGS
 */

if ( (string) getenv('APP_ENV') === 'production') {
	define('RULE_TEST', false);
}else{
	define('RULE_TEST', true);
}

$env = $app->detectEnvironment(function () {
	$environmentPath = __DIR__ . '/../.' . getenv('APP_ENV') . '.env';
	if (file_exists($environmentPath)) {
// LARAVEL 5.2  - use this below..
		$dotenv = new Dotenv\Dotenv(__DIR__ . '/../', '.' . getenv('APP_ENV') . '.env');
		$dotenv->overload(); //this is important
	}
});