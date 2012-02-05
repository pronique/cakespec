<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS .'../libraries/CakeSpecBuilder.php' );
require_once( 'CakeSpecTestCase.php' );
class CakeSpecBuilderTests extends CakeSpecTestCase {

    protected $tClass;
    
    function SetUp() {
        $this->datadir = CAKESPEC_TEST_DATA . DS . 'CakeSpecBuilder';
    }
    function testBuildSimple() {
        $csb = new CakeSpecBuilder( $this->datadir . DS . 'simple.cakespec' );
        //$csb->build();
    }
}
