<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS .'../Inc/CGBase.php' );
require_once('Classes/CGBaseInternals.php');
require_once( 'TestCase.php' );
class CGBaseTests extends TestCase {

    protected $tClass;
    protected $tiClass;
    
    function SetUp() {
        $this->tClass = new CGBase();  
        $this->tiClass = new CGBaseInternals();  
        
    }

    function testIndent() {
        $code = "echo 'Hello World';\n";
        $expected = "    echo 'Hello World';\n";
        $this->assertEquals( $expected, $this->tClass->indent( $code ) );

        $code = "echo 'Hello World';\n";
        $code .= "\$a = 1 + 2;";
        $expected = "    echo 'Hello World';\n";
        $expected .= "    \$a = 1 + 2;\n";
        $this->assertEquals( $expected, $this->tClass->indent( $code ) );

        $code = "echo 'Hello World';\n";
        $code .= "\$a = 1 + 2;";
        $expected = "        echo 'Hello World';\n";
        $expected .= "        \$a = 1 + 2;\n";
        $this->assertEquals( $expected, $this->tClass->indent( $code, 2 ) );
                
    }
    
    function testIndentStr() {
        $this->assertEquals( '    hello world', $this->tiClass->indentStr('hello world') );    
        $this->assertEquals( '        hello world', $this->tiClass->indentStr('hello world', 2) );    
        $this->assertEquals( '            hello world', $this->tiClass->indentStr('hello world', 3) );    
    }
    
    function testGenCode() {
        $arr = array(
            'echo "Hello World";'
        );

        $expected = "echo \"Hello World\";\n";
        $this->assertEquals( $expected, $this->tiClass->genCode( $arr ) );

        $arr = array(
            'echo "Hello World";',
            '$a = 1 + 3;',
            'echo $a;',
            '$b = $a - 4;',
            'echo $b;',
        );

        $expected = "echo \"Hello World\";\n\$a = 1 + 3;\necho \$a;\n\$b = \$a - 4;\necho \$b;\n";
        $this->assertEquals( $expected, $this->tiClass->genCode( $arr ) );
         
    }
        
    function testGenArray() {
        
        $arr = array( 'hello', 'world' );
        $this->assertEquals( "array( 'hello', 'world' )", $this->tiClass->genArray( $arr ) );

        $arr = array( 'hello'=>'world', 'world'=>'hello' );
        $this->assertEquals( "array( 'hello' => 'world', 'world' => 'hello' )", $this->tiClass->genArray( $arr ) );

        $arr = array( 'hello'=>'world', 'nested'=>array( 'hello'=>'world') );
        $expected = "array(     'hello' => 'world',     'nested' => array( 'hello' => 'world' ))";
        $this->assertEquals( $expected , str_replace( "\n", "", $this->tiClass->genArray( $arr ) ) );

        $arr = array( '1','2','3' );
        $this->assertEquals( "array( '1', '2', '3' )", $this->tiClass->genArray( $arr ) );                    
                          
        $arr = array( 1=>"string",2=>"two",3=>"three" );
        $this->assertEquals( "array( 'string', 'two', 'three' )", $this->tiClass->genArray( $arr ) );                    
        
        $arr = array( 1,2,3 );
        $this->assertEquals( "array( '1', '2', '3' )", $this->tiClass->genArray( $arr ) );                    
        
        $arr = array( 5=>1,10=>'string',15=>3 );
        $this->assertEquals( "array( '1', 'string', '3' )", $this->tiClass->genArray( $arr ) );  
        
    }
    

    function testArrayDepth() {
        $arr = array( 1, 2, 3, 4);
        $this->assertEquals( 1, $this->tiClass->array_depth( $arr ) );

        $arr = array( array(1,2,3), array(1,2,3), array(1,2,3) );
        $this->assertEquals( 2, $this->tiClass->array_depth( $arr ) );
        
        $arr = array( array( array() ),  );
        $this->assertEquals( 3, $this->tiClass->array_depth( $arr ) );

        $arr = array( array( array( array() ) ),  );
        $this->assertEquals( 4, $this->tiClass->array_depth( $arr ) );

        $arr = array( array( array( array( array() ) ) ),  );
        $this->assertEquals( 5, $this->tiClass->array_depth( $arr ) );        
    }

}
