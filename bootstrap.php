<?php 
/**
* bootstrap.php
* 
*/
defined('DS') or define( 'DS', DIRECTORY_SEPARATOR);
define('CAKESPEC_VERSION', '0.9');
define('CAKESPEC_DIR', dirname( __FILE__ ) );
define('CAKESPEC_INDENT', '    ' );
define('CAKESPEC_TAGLINE', 'This file was generated using CakeSpec (http://www.cakespec.com)' );

require_once( CAKESPEC_DIR . DS . 'libraries/functions.php');

defined( 'CAKESPEC_GIT_EXEC' ) or define('CAKESPEC_GIT_EXEC', exec('which git') );
defined( 'CAKESPEC_SVN_EXEC' ) or define('CAKESPEC_SVN_EXEC', exec('which svn') );

require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecBuilder.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecLint.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecFilesystem.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CGClass.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CGCakeClass.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CGCakeController.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CGCakeModel.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecAppConfig.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecAppPlugin.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecAppView.php');
require_once( CAKESPEC_DIR . DS . 'libraries/CakeSpecAppWebroot.php');

