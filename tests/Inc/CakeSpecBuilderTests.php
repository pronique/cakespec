<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS .'../Inc/CakeSpecBuilder.php' );
require_once( 'TestCase.php' );
class CakeSpecBuilderTests extends TestCase {

    protected $tClass;
    
    function SetUp() {
        $this->datadir = CAKESPEC_TEST_DATA . DS . 'CakeSpecBuilder';
    }
    function testBuildSimple() {
        $csb = new CakeSpecBuilder( $this->datadir . DS . 'simple.cakespec' );
        //$csb->build();
    }
}
