<?php
// Create the batch file based on files found in Specs folder

require 'config.php';

$specs = glob(SPEC_PATH . '*Spec.php');

$cmds = ["@ echo " . START_OF_TESTS];

foreach ($specs as $spec)
{
	$cmds[] = "@ php tester.php " . ucfirst(str_replace('Spec.php', '', basename($spec)));
}

file_put_contents(BATCH_FILE_NAME, implode(PHP_EOL, $cmds));

exit(DONE);