<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS . '../libraries/CGCakeModel.php' );
require_once( 'CGTestCase.php' );
class CGCakeModelTests extends CGTestCase {

    protected $tClass;
    protected $tiClass;
    
    function SetUp() {
        $this->tClass = new CGCakeModel();  
    }
    
    function testGenerate() {
        $cName = 'MyClass';
        $cArr = array(
            'AppUses' => array( 'AppModel'=>'Model' ),
            'visibility'=>'public'
        );
        $expected = "/**\n* MyClass Class\n*\n*\n*/\nApp::uses( 'AppModel', 'Model' );\n\nclass MyClass extends AppModel {\n\n}\n";
        $this->assertEquals( $expected, $this->tClass->generate( $cName, $cArr ) );
    }
    
}
