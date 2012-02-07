<?php
/**
* cakespec.php - CakePHP Application Builder - Command line tool
* @version 0.9
* @author Jonathan Cutrer
*
*/

include_once('bootstrap.php');

//Parse command line options
$cliOpts = getopt('qhlvd', array('quiet', 'help', 'lint', 'version', 'debug', 'nodep', 'notagline') );

//Parse command line arguments
$cliArgs = cakespec_getargs( $argv );

// Process -h --help flags and exit
if ( array_key_exists( 'h', $cliOpts ) || array_key_exists( 'help', $cliOpts ) ) {
     cakespec_help();
     exit;
}

// Process -v --version flags and exit
if ( array_key_exists( 'v', $cliOpts ) || array_key_exists( 'version', $cliOpts ) ) {
     echo CAKESPEC_VERSION . "\n";
     exit;
}

// Process -q --quiet flags
if ( array_key_exists( 'q', $cliOpts ) || array_key_exists( 'quite', $cliOpts ) ) {
     define( 'CAKESPEC_QUIET', 1 );
} else {
     defined('CAKESPEC_QUIET') or define('CAKESPEC_QUIET', 0);
}

// Process -d --debug flags
if ( array_key_exists( 'd', $cliOpts ) || array_key_exists( 'debug', $cliOpts ) ) {
     define( 'CAKESPEC_DEBUG', 1 );
     cakespec_debug( '--debug flag set, turning debug on' );
} else {
     defined('CAKESPEC_DEBUG') or define('CAKESPEC_DEBUG', 0);
}

// Process --nodep flag
if ( array_key_exists( 'nodep', $cliOpts ) ) {
     defined('CAKESPEC_NODEP') or define( 'CAKESPEC_NODEP', 1 );
}

//Check CakeSpec dependencies
if (!defined('CAKESPEC_NODEP') ) {
    cakespec_checkDependencies();
}

// Process --notagline flag
if ( array_key_exists( 'notagline', $cliOpts ) ) {
     defined('CAKESPEC_NOTAGLINE') or define( 'CAKESPEC_NOTAGLINE', 1 );
}

//Parse [FILE] command line argument, if not set show syntax and exit
if ( empty( $cliArgs[1] ) ) {
    cakespec_syntax();
    exit;
} else {
    $specfile = $cliArgs[1];
}

// Process -l --lint flag and exit
if ( array_key_exists( 'l', $cliOpts ) || array_key_exists( 'lint', $cliOpts ) ) {
     cakespec_debug( '--lint flag set, running lint' );
     $CsLint = new CakeSpecLint( $specfile );
     exit;
}

// Create instance of CakeSpecBuilder and run ::build()
$Builder = new CakeSpecBuilder( $specfile );
$Builder->build();
exit;
/* end execution */

/* Functions below */
function cakespec_syntax() {
    global $argv;
    echo "Usage: cakespec [OPTION] [FILE]\n";
    echo "Try cakespec --help for more information.\n";
}

function cakespec_help() {
    echo <<<END
Usage: cakespec [OPTION] [FILE]
Example: cakespec myapp.cakespec

Command Line Arguments:
  -h, --help                display this help and exit
  -v, --version             print version information and exit
  -l, --lint                PATTERN is a basic regular expression (BRE)
  -q, --quiet               suppress all normal output
  -d, --debug               output detailed debugging information
  --nodep                   no dependency checks for git, svn, etc
  --notagline               suppress 'generated using CakeSpec' tagline from generated files


END;
}