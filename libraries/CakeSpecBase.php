<?php
/**
    CakeSpecBase class
*/

class CakeSpecBase {
    public function __construct( ) {
        defined('CAKESPEC_DEBUG') or define( 'CAKESPEC_DEBUG', 0);
    }

    protected function exec( $cmd ) {
	    cakespec_debug( 'Executing '  .  $cmd );
	    return exec( $cmd );
    }

    protected function checkDependencies() {
        //TODO Check basic dependencies of CakeSpecBuilder
	    $pass = true;
        $depErrors = array();
	    if ( !function_exists('json_decode') ) {
            $pass = false;
            $depErrors[] = 'json_decode function not present, install PHP json extension';
        }

	    if ( !$this->gitExec = exec('which git') ) {
            $pass = false;
            $depErrors[] = "git not installed: \n        try sudo apt-get install git\n        or sudo yum install git";
        }

        if ( !$this->svnExec = exec('which svn') ) {
            $pass = false;
            $depErrors[] = "svn not installed: \n        try sudo apt-get install subversion\n        or sudo yum install subversion";
        }

        if ( $pass === false ) {
            echo "CakeSpec dependencies not found\n";
            foreach( $depErrors as $error ) {
                echo "    " . $error . "\n";
            }
        } 
        return $pass;  
    }
}