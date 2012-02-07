<?php


function cakespec_debug( $data ) {
    if ( !defined( 'CAKESPEC_DEBUG' ) ) {
        return;
    }
    
    if ( CAKESPEC_DEBUG > 0 ) {
        cakespec_out( ">>>DEBUG: " . $data );
    }
}

function cakespec_out( $data='', $newline=true ) {
    if ( !defined( 'CAKESPEC_QUIET' ) ) {
        return;
    }
        
    if ( CAKESPEC_QUIET < 1 ) {
        echo $data;
        if ( $newline === true ) {
            echo "\n";    
        }
    }
}

function cakespec_getargs( $argv ) {
    foreach( $argv as $key=>$arg ) {
	if ( substr( $arg,  0, 1) != '-' ) {
           $args[] = $arg;
        }
    }
    return $args;

}

function cakespec_checkDependencies() {
    //TODO Check basic dependencies of CakeSpecBuilder
    $pass = true;
    $depErrors = array();
    if ( !function_exists('json_decode') ) {
        $pass = false;
        $depErrors[] = 'json_decode function not present, install PHP json extension';
    }

    if ( !exec('which git') ) {
        $pass = false;
        $depErrors[] = "git not installed: \n        try sudo apt-get install git\n        or sudo yum install git";
    }

    if ( !exec('which svn') ) {
        $pass = false;
        $depErrors[] = "svn not installed: \n        try sudo apt-get install subversion\n        or sudo yum install subversion";
    }

    if ( $pass === false ) {
        echo "CakeSpec dependencies not found\n";
        foreach( $depErrors as $error ) {
            echo "    " . $error . "\n";
        }
        exit(1);
    }
    return $pass;   
}


if ( !function_exists('__') ) {
    function __( $message ) {
        return $message;
    }
}

