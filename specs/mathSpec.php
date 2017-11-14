<?php

// A list of methods and their associated test function names and descriptions. Separate name and description with space/tab characters
$spec = "
__construct
get_instance			It should provide an instance of the class
sum
it_should_add_integers	It should add integers
it_should_add_floats	It should add floats
multiply
it_should_multiply		It should multiply numbers
getPI
static_method It should support static methods
useHelper
use_mock_class		It should be able to access dependencies (other classes)
displayNumber
display_a_number	It should display a number
";

// Test function definitions
function get_instance()
{
	// To keep your learning curve short and sweet there is only one testing method: compare(number/bool/array/object/string A , number/bool/array/object/string B)
	Tester::compare(new Math(), '
Math Object
(
    [property] => 0
)
');
}

function it_should_add_integers()
{
	// Always start from a fresh instance of the class that is being tested to avoid previous effects, and use this Template of code to save you work
	$instance = new Tester::$class(); // Here we are using the stored value of the Class name

	Tester::compare($instance->sum(1,2), 3);
}

function it_should_add_floats()
{
	$instance = new Tester::$class();

	Tester::compare($instance->sum(0.5,0.3), 0.8);
}

function it_should_multiply()
{
	$instance = new Tester::$class();

	Tester::compare($instance->multiply(2,6), 12);
}

function static_method()
{
	Tester::compare(Math::getPI(), 3.141); // Have to use the actual Class name for static methods
}

function use_mock_class()
{
	Tester::compare(Math::useHelper(), 'Hello!'); // This useHelper method will cause the Tester's Class Autoloader to load the Mocked Helper class.
}

function display_a_number()
{
	Tester::compare(Tester::get_displayed_content('display_sum', [1, 2, 3]), 7);
}

function display_sum($a, $b, $c)
{
	(new Math())->displaySum($a, $b, $c);
}