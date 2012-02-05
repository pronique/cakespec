<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS .'../libraries/CGClass.php' );
require_once( 'CGTestCase.php' );
require_once( 'Classes/CGClassInternals.php' );
class CGClassTests extends CGTestCase {

    protected $tClass;
    protected $tiClass;
    
    function SetUp() {
        $this->tClass = new CGClass();  
        $this->tiClass = new CGClassInternals();      
    }
    
    function testGenerate() {
        $cName = 'MyClass';
        $cArr = array(
            'visibility'=>'public'
        );
        $expected = "/**\n* MyClass Class\n*\n*\n*/\nclass MyClass  {\n\n}\n";
        $this->assertEquals( $expected, $this->tClass->generate( $cName, $cArr ) );
    }
    
    function testGenClassCommentBlock() {
        $cName = 'MyClass';
        $cArr = array(
        
        );
        $expected = "/**\n* MyClass Class\n*\n*\n*/\n";
        $this->assertEquals( $expected, $this->tiClass->genClassCommentBlock( $cName, $cArr ) );
           
    }
    
    function testGenMethodCommentBlock() {
        //Test Method comment block
        $mName = 'myMethod';
        $mArr = array();
        $mComment = '';
        $expected = "/**\n* myMethod Method\n*\n*/\n";
        $this->assertEquals(
            $expected,
            $this->tiClass->genMethodCommentBlock( $mName, $mArr, $mComment )
        );

        //Test Method comment block with custom comment
        $mName = 'myMethod';
        $mArr = array( 'comment'=>'testing 1 2 3');
        $mComment = '';
        $expected = "/**\n* myMethod Method\n*\n* testing 1 2 3\n*\n*/\n";
        $this->assertEquals(
            $expected,
            $this->tiClass->genMethodCommentBlock( $mName, $mArr, $mComment )
        );

        //Test Method comment block with params
        $mName = 'myMethod';
        $mArr = array( 'comment'=>'testing 1 2 3', 'params'=>array('a', 'b') );
        $mComment = '';
        $expected = "/**\n* myMethod Method\n*\n* testing 1 2 3\n*\n* @param mixed \$a\n* @param mixed \$b\n*/\n";
        $this->assertEquals(
            $expected,
            $this->tiClass->genMethodCommentBlock( $mName, $mArr, $mComment )
        );
                
    }
    
    function testGenProperty() {
        $pName = 'foo';
        $pArr = array();
        $this->assertEquals( "protected \$foo;\n", $this->tiClass->genProperty( $pName, $pArr ) );
        

        $pName = 'foo';
        $pArr = array('value'=>'bar');
        $this->assertEquals( "protected \$foo = 'bar';\n", $this->tiClass->genProperty( $pName, $pArr ) );
        
        $pName = 'foo';
        $pArr = array('value'=>array('abc', 'def'));
        $this->assertEquals( "protected \$foo = array( 'abc', 'def' );\n", $this->tiClass->genProperty( $pName, $pArr ) );

        $pName = 'foo';
        $pArr = array( 'value'=>array( 'abc'=>array( '123', '456' ) ) );
        $this->assertEquals( "protected \$foo = array( \n    'abc' => array( '123', '456' )\n);\n", $this->tiClass->genProperty( $pName, $pArr ) );

        $pName = 'foo';
        $pArr = array(
            'visibility'=>'private', 
            'value'=>array( 'abc'=>array( '123', '456' ) ) 
        );
        $this->assertEquals( "private \$foo = array( \n    'abc' => array( '123', '456' )\n);\n", $this->tiClass->genProperty( $pName, $pArr ) );
        
        $pName = 'foo';
        $pArr = array(
            'visibility'=>'public', 
            'value'=>array( 'abc'=>array( '123', '456' ) ) 
        );
        $this->assertEquals( "public \$foo = array( \n    'abc' => array( '123', '456' )\n);\n", $this->tiClass->genProperty( $pName, $pArr ) );
    }
    
    function testGenMethod() {
        //Testing genMethod, defaults to visibility protected 
        $mName = 'myMethod';
        $mArr = array(
            'comments'=>'Testing 1 2 3',
            'params'=>array('a', 'b')
        );
        $expected = "//Testing 1 2 3\nprotected function myMethod( \$a, \$b ) {\n\n} //end myMethod\n";
        $this->assertEquals( $expected, $this->tiClass->genMethod( $mName, $mArr ) );    

        //Testing genMethod, visibility private
        $mName = 'myMethod';
        $mArr = array(
            'comments'=>'Testing 1 2 3',
            'visibility'=>'private',
            'params'=>array('a', 'b')
        );
        $expected = "//Testing 1 2 3\nprivate function myMethod( \$a, \$b ) {\n\n} //end myMethod\n";
        $this->assertEquals( $expected, $this->tiClass->genMethod( $mName, $mArr ) );    
                
        //Testing genMethod, visibility public
        $mName = 'myMethod';
        $mArr = array(
            'comments'=>'Testing 1 2 3',
            'visibility'=>'public',
            'params'=>array('a', 'b')
        );
        $expected = "//Testing 1 2 3\npublic function myMethod( \$a, \$b ) {\n\n} //end myMethod\n";
        $this->assertEquals( $expected, $this->tiClass->genMethod( $mName, $mArr ) );    
        
        //Testing callParent before
        $mName = 'myMethod';
        $mArr = array(
            'comments'=>'Testing 1 2 3',
            'params'=>array('a', 'b'),
            'callParent' => 'before',
            'code' => array(
                '//A Comment',
                'echo "Hello World";'
            ),
            'return' => '$foo'
        );
        $expected = "//Testing 1 2 3\nprotected function myMethod( \$a, \$b ) {\n";
        $expected .= "    parent::myMethod();\n";
        $expected .= "    //A Comment\n";
        $expected .= "    echo \"Hello World\";\n";
        $expected .= "\n    return \$foo;";
        $expected .= "\n} //end myMethod\n";
        
        $this->assertEquals( $expected, $this->tiClass->genMethod( $mName, $mArr ) );  
        
        //Testing callParent after
        $mName = 'myMethod';
        $mArr = array(
            'comments'=>'Testing 1 2 3',
            'params'=>array('a', 'b'),
            'callParent' => 'after',
            'code' => array(
                '//A Comment',
                'echo "Hello World";'
            ),
            'return' => '$foo'
        );
        $expected = "//Testing 1 2 3\nprotected function myMethod( \$a, \$b ) {\n";
        $expected .= "    //A Comment\n";
        $expected .= "    echo \"Hello World\";\n";
        $expected .= "\n    parent::myMethod();\n";
        $expected .= "    return \$foo;";
        $expected .= "\n} //end myMethod\n";
        
        $this->assertEquals( $expected, $this->tiClass->genMethod( $mName, $mArr ) );   
    }
    
    function testGenMethodParams() {
        $pArr = array('a','b','c');
        $expected = ' $a, $b, $c';
        $this->assertEquals( $expected, $this->tiClass->genMethodParams( $pArr ) );    
    
        $pArr = array('$a','$b','$c');
        $expected = ' $a, $b, $c';
        $this->assertEquals( $expected, $this->tiClass->genMethodParams( $pArr ) );    

        $pArr = array('one','two','three=\'\'');
        $expected = ' $one, $two, $three=\'\'';
        $this->assertEquals( $expected, $this->tiClass->genMethodParams( $pArr ) );        
        
        $pArr = array('$one','$two','$three=\'\'');
        $expected = ' $one, $two, $three=\'\'';
        $this->assertEquals( $expected, $this->tiClass->genMethodParams( $pArr ) );        
    }
}