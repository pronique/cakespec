<?php
/**
*
*
*/

require_once( 'Classes/CakeSpecBaseInternals.php' );
require_once( 'CakeSpecTestCase.php' );
class CakeSpecBaseTests extends CakeSpecTestCase {
    protected $tClass;
    protected $tiClass;
    
    function SetUp() {
        $this->tClass = new CakeSpecBase();  
        $this->tiClass = new CakeSpecBaseInternals();  
        
    }
    
    function testExec() {
        $this->assertEquals( '/bin/ls', $this->tiClass->exec('which ls') );   
    }

    function testCheckDep() {
        $this->assertTrue( $this->tiClass->checkDependencies() );   
    }
          
}
