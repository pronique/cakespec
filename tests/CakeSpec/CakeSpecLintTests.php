<?php
/**
*
*
*/

require_once('Classes/CakeSpecLintInternals.php');
require_once( 'CakeSpecTestCase.php' );
class CakeSpecLintTests extends CakeSpecTestCase {
    protected $tClass;

    function SetUp() {
        $this->datadir = CAKESPEC_TEST_DATA . DS . 'CakeSpecLint';
    }
   
    function testErrorStack() {
        $cslint = new CakeSpecLintInternals( $this->datadir . DS . 'valid.cakespec' );
        $prevCount = $cslint->getErrorCount();
        $cslint->addError('Testing Error Stack');
        $this->assertEquals( $prevCount + 1,  $cslint->getErrorCount() );

        $this->assertContains("Testing Error Stack", $cslint->getError(0) );
        $this->assertContains("Testing Error Stack", $cslint->getLastError() );
        
        $prevCount = $cslint->getErrorCount();
        $cslint->addError('A 2nd Error to the Stack');
        $this->assertEquals( $prevCount + 1,  $cslint->getErrorCount() );

        $this->assertContains("A 2nd Error to the Stack", $cslint->getError(1) );
        $this->assertContains("A 2nd Error to the Stack", $cslint->getLastError() );

        $this->assertEquals( 
            array( 
                0 => 'Testing Error Stack',
                1 => 'A 2nd Error to the Stack'
            ),  
            $cslint->getErrors()
        );
    }
    
    function testIsValidFilename() {
        $cslint = new CakeSpecLintInternals( $this->datadir . DS . 'valid.cakespec' );
        
        $valid_filenames = array( 
            'appname', 
            'areallylongappname', 
            'app-name', 
            'CamelCaseAppName',  
            'App~Name'  
        );
        
        foreach( $valid_filenames as $filename ) {
            $this->assertTrue( $cslint->isValidFilename( $filename ) );    
        }
        
    }
    
    function testIsNotValidFilename() {
        $cslint = new CakeSpecLintInternals( $this->datadir . DS . 'valid.cakespec' );
        
        $invalid_filenames = array( 
            'App/Name', 'App\Name', 'AppName/', 'AppName\\', '/AppName', '\AppName', 
            'a?pp-name', '?app-name', 'app-name?', 
            'App{Name', 'App}Name', 'AppName}', 'AppName{', '}AppName{', '{AppName', '{AppName}', 
            "AppNameWith\tTabCharacter", "\tAppNameWithTabCharacter", "AppNameWithTabCharacter\t",
            ".", ".."
        );
        
        foreach( $invalid_filenames as $filename ) {
            $this->assertFalse( $cslint->isValidFilename( $filename ) );    
        }   
    }
        
    
    function testValidSpecFile() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'valid.cakespec' );
        $this->assertEquals(0, $cslint->getErrorCount() );
    }

    function testMissingSpecFile() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'nonexistent.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertContains("File not found:", $cslint->getError(0) );
    } 

    function testMissingCakeSpec() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'missingcakespec.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertContains("CakeSpec object missing", $cslint->getError(0) );
    }
    
    function testIllegalAppName() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'illegalappname.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertEquals("CakeSpec.App.name contains illegal characters", $cslint->getError(0) );
    }
        
    function testMissingCake() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'missingcake.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertEquals("CakeSpec.Cake object missing", $cslint->getError(0) );
    }

    function testMissingCakeGit() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'missingcakegit.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertEquals("CakeSpec.Cake.git object missing", $cslint->getError(0) );
    }
    
    function testMissingCakeGitRepo() {
        $cslint = new CakeSpecLint( $this->datadir . DS . 'missingcakegitrepo.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertEquals("CakeSpec.Cake.git.repo member missing", $cslint->getError(0) );
    }
            
    function testMalformedJson() {
        $cslint = new CakeSpecLint($this->datadir . DS . 'malformedjson.cakespec' );
        $this->assertEquals(1, $cslint->getErrorCount() );
        $this->assertEquals("JSON Error: Syntax error, malformed JSON", $cslint->getError(0) );
    }
}