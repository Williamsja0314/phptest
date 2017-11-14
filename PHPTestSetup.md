### What is this repository for? ###

* For running PHP unit tests from the command line

### How do I get set up? ###

* Check that the command line version of PHP is available on your system with: *php -v*
* Edit the *config.php* file to set the correct file paths and other settings
* Look at the example Class and test Spec file to understand how to set up unit tests
* The batch file *run-tests* will run tests and display results for each Class to be tested
* A utility (*make-bat*) is provided to generate the batch file
* Run the tests on one particular class with: *php tester.php ClassName*
* *Mocks* are simulations of Classes that are called upon by the Classes that are under test, so you need to implement these mock Classes with simulated behaviour. It's not acceptable to test a Class that is calling a Class that itself is subject to testing. Key point to get!

[Documentation](https://backendcoder.com/easy-testing-of-php)