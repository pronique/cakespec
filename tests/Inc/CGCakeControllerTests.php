<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS . '../Inc/CGCakeController.php' );
require_once( 'TestCase.php' );
class CGCakeControllerTests extends TestCase {

    protected $tClass;
    protected $teClass;
    
    function SetUp() {
        $this->tClass = new CGCakeController();  
    }
    
    function testGenerate() {
        $cName = 'MyClass';
        $cArr = array(
            'AppUses' => array( 'AppController'=>'Controller' ),
            'visibility'=>'public'
        );
        $expected = "/**\n* MyClass Class\n*\n*\n*/\nApp::uses( 'AppController', 'Controller' );\n\nclass MyClass extends AppController {\n\n}\n";
        $this->assertEquals( $expected, $this->tClass->generate( $cName, $cArr ) );
    }

}
