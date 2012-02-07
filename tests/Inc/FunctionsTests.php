<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS . '../Inc/functions.php' );
require_once( 'TestCase.php' );
class FunctionsTests extends TestCase {

    function testCakeSpecDebug() {
        $this->assertTrue( function_exists( 'cakespec_debug' ) );
        //defined('CAKESPEC_DEBUG') or define( 'CAKESPEC_DEBUG', 1 );
        //if ( CAKESPEC_DEBUG > 0 ) {
        //    ob_start();
        //    cakespec_debug( 'testing 1 2 3' );
        //    $out = ob_get_contents();
        //    $this->assertEquals( ">>>DEBUG: testing 1 2 3\n", $out );
        //}
    }
    
    function testCakeSpecOut() {
        $this->assertTrue( function_exists( 'cakespec_out' ) );
        //ob_start();
        //cakespec_out( 'test' );
        //$out = ob_get_contents();
        //$this->assertEquals( "test\n", $out );
    }
    
    function testCakeSpecGetArgs() {
        $args = array( 'cmd', 'one', 'two' );
        $this->assertEquals( array('cmd', 'one', 'two'), cakespec_getargs( $args ) );
        $args = array( '-h', '--option', 'one', 'two' );
        $this->assertEquals( array( 'one', 'two'), cakespec_getargs( $args ) );
    }
    
    function testCakeSpecCheckDep() {
        $this->assertTrue( cakespec_checkDependencies() );
    }

    function test__() {
        $this->assertEquals( 'hello world', __('hello world')  );
    }    
}