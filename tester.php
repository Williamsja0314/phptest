<?php
/*
* PHP Test Runner
*
* Copyright (c) 2016 Andrew Wilkes – https://backendcoder.com
* Released under the MIT License (MIT)
*/

require 'config.php';
require 'setup.php';

Tester::run($argv);

class Tester
{
	public static $class;
	public static $classPath = CLASS_PATH;
	public static $method;
	public static $description;
	public static $fails = 0;
	public static $count = 0;
	public static $output = [];
	public static $result; // Used to capture a result from a Mock

	public static function run($params)
	{
		if (count($params) < 2)
			self::abort(MISSING_CLASS_PARAM);

		// Load the class to be tested
		self::$class = $class = $params[1];
		$fileNameStub = strtolower(rtrim(preg_replace('/([A-Z]+[a-z0-9]*)+?/', '$1-', $class), '-'));
		$classFile =  self::$classPath . $fileNameStub . '.php';

		if (file_exists($classFile))
			include $classFile;
		else
			self::abort("$classFile " . DOES_NOT_EXIST);

		// Load the test spec
		$specFile = SPEC_PATH . $fileNameStub . 'Spec.php';
		if (file_exists($specFile))
			include $specFile;
		else
			self::abort("$specFile " . DOES_NOT_EXIST);

		$spec = self::sanitize_line_endings($spec);

		// Run the tests
		self::$output[] = TESTING . " $class class";

		$tests = explode("\n", trim($spec));

		foreach($tests as $test)
		{
			// Replace first white space area with TAB delimiter
			$test = preg_replace("/\s+/", "\t", $test, 1);

			if (strpos($test, "\t"))
			{
				self::$count++;

				list($func, $description) = explode("\t", $test);
				
				// Fix for earlier versions of PHP which may have the parameters reversed in direction (http://php.net/manual/en/function.list.php)
				if ( ! function_exists($func))
				{
					$test = $func;
					$func = $description;
					$description = $test;
				}
				self::$description = $description;
				$func();
			}
			else
				self::$method = $test;
		}

		if (self::$fails < 1)
			self::$output[] = PASSED . " " . self::$count . " " . TESTS;

		self::done();
	}

	public static function abort($error)
	{
		ddd($error);
	}

	public static function compare($result, $expected_value)
	{
		$result = self::stringify_non_numeric($result);
		$expected_value = self::stringify_non_numeric($expected_value);

		if ($result == $expected_value) return; // Test was passed.

		if (++self::$fails == 1)
			self::$output[] = FAILED . "!";
		else
			self::$output[] = "";

		self::$output[] = "\tMethod:\t\t" . self::$method;
		self::$output[] = "\t" . TEST . ":\t\t" . self::$description;
		self::$output[] = "\t" . RESULT . ":\t\t" . $result;
		self::$output[] = "\t" . EXPECTED . ":\t" . $expected_value;

		if (STOP_ON_FIRST_FAILURE) self::done();
	}

	public static function stringify_non_numeric($ob)
	{
		if (is_numeric($ob))
			return $ob;

		if (is_bool($ob))
			return $ob ? 'true' : 'false';

		if ( ! is_string($ob))
			$ob = print_r($ob, true);
		$txt = trim(self::sanitize_line_endings($ob));
		return str_replace("\n", PHP_EOL, $txt);
	}

	public static function sanitize_line_endings($txt)
	{
		$txt = str_replace("\r", "\n", $txt);
		return preg_replace("/\n+/m", "\n", $txt);
	}

	public static function done()
	{
		self::$output[] = "";
		self::$output[] = "";
		exit(implode(PHP_EOL, self::$output));
	}

	public static function get_displayed_content($func, $params = null)
	{
		ob_start();
		if (is_array($params))
			call_user_func_array($func, $params);
		else
			$func($params);

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}