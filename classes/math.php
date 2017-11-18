<?php
class Math
{
	public $property;

	public function __construct()
	{
		$this->property = 0;
	}

	public function sum($a, $b)
	{
		return $a + $b;
	}

	public function multiply($a, $b)
	{
		return $a * $b;
	}

	public static function getPI()
	{
		return 3.1416;
	}

	public static function useHelper()
	{
		return TheHelper::sayHi();
	}

	public function displaySum($a, $b, $c, $d = 1)
	{
		echo ($a + $b + $c + $d);
	}
}
