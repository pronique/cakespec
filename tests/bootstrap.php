<?php
/**
* See README.txt for instructions on running unit tests
*
* This is the unit testing bootstrap
* place any code that needs to be executed
* before running unit tests
* 
*/
define( 'DS', DIRECTORY_SEPARATOR );
define( 'CAKESPEC_EXEC', 'php ' . dirname(__FILE__) . DS . '..' . DS . 'cakespec.php' );
define( 'CAKESPEC_TEST_DIR', dirname(__FILE__) );
define( 'CAKESPEC_TEST_TMP', '/tmp/_testcakespec' );
define( 'CAKESPEC_TEST_DATA', dirname(__FILE__) . DS . 'data' );
define( 'CAKESPEC_QUIET', false );

require_once( CAKESPEC_TEST_DIR . DS . '..' . DS . 'bootstrap.php' );
