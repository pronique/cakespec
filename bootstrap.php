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

require_once( CAKESPEC_DIR . DS . 'Inc/functions.php');

defined( 'CAKESPEC_GIT_EXEC' ) or define('CAKESPEC_GIT_EXEC', exec('which git') );
defined( 'CAKESPEC_SVN_EXEC' ) or define('CAKESPEC_SVN_EXEC', exec('which svn') );

require_once( CAKESPEC_DIR . DS . 'Lib/ProTemplateCompiler.php');

require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecBuilder.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecLint.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecFilesystem.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CGClass.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CGCakeClass.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CGCakeController.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CGCakeModel.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecAppConfig.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecAppPlugin.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecAppView.php');
require_once( CAKESPEC_DIR . DS . 'Inc/CakeSpecAppWebroot.php');


