<?php
/**
*
*
*/
require_once( CAKESPEC_TEST_DIR . DS . '../Lib/ProTemplateCompiler.php' );
//require_once( '../Inc/TestCase.php' );
class ProTemplatecCompilerTests extends TestCase {
   
    protected $fixtures = array(
        'template1'=>"
            Hello World 
            Testing 1 2 3 4 5 6
            print_r( 'Testing' );
            Configure::write( 'Hello', 'World' );
        ",
        'template2'=>"
            An example template file ready to use.
            When compiled this template will contain the date on the next line.
            {\$month}/{\$day}/{\$year}
        ",
        'template3'=>"
            An example template file with an alternative tag format.
            When compiled this template will contain the date on the next line.
            %%month%% %%day%% %%year%%
        ",
        'template4'=>'{$color}{$color}{$color}{$color}{$color}
        {$month}/{$day}-{$day}-{$day}-{$day}-{$day}-{$day}-{$day}/{$year}'
    );
    function SetUp() {
        
    }
    
    function testSimpleCompile() {
        $tc = new ProTemplateCompiler( $this->fixtures['template2'] );

        $data = array(
            'month'=>date('M'),
            'day'=>date('j'),
            'year'=>date('Y')
        );
        
        $this->assertContains( date('M/j/Y' ), $tc->compile( $data ));
    }
     
    function testCompileAltTag() {
        //$tc = new ProTemplateCompiler( $this->fixtures['template2'] );
   
        //$data = array(
        //    'month'=>date('m'),
        //   'day'=>date('j'),
        //    'year'=>date('Y')    
        //);
        
        //echo $tc->compile( $data  );
    }
    
    function testPrepareAndCompile() {
        $rules = array(
            'print_r'=>array(
                'match'=>"/((print_r)\(\s*')(.*)('\s*\);)/"
            ),
            'rule2'=>array(
                'match'=>"/(Configure::write\s*\(\s*'(Hello)'\s*,\s*')(.*)('\s*\);)/"
            )
        );
        
        $tc = new ProTemplateCompiler( $this->fixtures['template1'], $rules );

        $data = array(
            'print_r'=>'ItWorked!',
            'Hello'=>'HelloHelloHelloHelloWorldWorldWorldWorld'
        );
        
        $results = $tc->compile( $data  );
        $this->assertContains( 'ItWorked!', $results );
        $this->assertContains( 'HelloHelloHelloHelloWorldWorldWorldWorld', $results );
    }
    
    function testReplaceMultipleInstances() {

        
        $tc = new ProTemplateCompiler( $this->fixtures['template4'] );

        $data = array(
            'color'=>'red',
            'month'=>date('M'),
            'day'=>date('j'),
            'year'=>date('Y')
        );
        
        $results = $tc->compile( $data  );
        $this->assertContains( 'redredredredred', $results );
        $this->assertContains( date('M/j-j-j-j-j-j-j/Y'), $results );  
    }
}
