<?php
// Include useful debugging tool Kint if available or define d() and ddd() functions

if (defined('KINT_PATH'))
{
	$kint = KINT_PATH . 'Kint.class.php';

	if (file_exists($kint))
	{
		include $kint;
	}
}

if ( ! function_exists('d'))
{
	function d($object)
	{
		echo "Debug output:" . PHP_EOL;
		print_r($object);
	}
}

if ( ! function_exists('ddd'))
{
	function ddd($object)
	{
		d($object);
		exit;
	}
}

// Cater for the loading of Mock Classes
function class_autoloader($class)
{
	// This code transforms a ClassName to class-name for the file name
	$file_name = preg_replace('/([A-Z]+[a-z0-9]*)+?/', '$1-', $class);
	$file_name = strtolower(rtrim($file_name, '-'));
	$file_name = MOCK_PATH . $file_name . '.php';

	if (file_exists($file_name))
		include $file_name;
	else
		die( MISSING_MOCK_FILE . ': ' . $file_name );
}

spl_autoload_register('class_autoloader');

// Take control of the error reporting to the console window
ini_set('log_errors', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);