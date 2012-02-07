<?php
/**
*
*
*/
require_once( 'TestCase.php' );

class CakeSpecFilesystemTests extends TestCase {
    
    protected $tClass;
    function testTest() {
        
    }
    /*
    function SetUp() {
        mkdir( CAKESPEC_TEST_TMP );
        mkdir( CAKESPEC_TEST_TMP . DS . 'chmodtest' );
        mkdir( CAKESPEC_TEST_TMP . DS . 'chowntest' );
        touch( CAKESPEC_TEST_TMP . DS . 'chmodtest' . DS . 'file.txt' );
        touch( CAKESPEC_TEST_TMP . DS . 'chowntest' . DS . 'file.txt' );
    }
    
    function TearDown() {
        unlink( CAKESPEC_TEST_TMP . DS . 'chmodtest'  . DS  . 'file.txt' );
        unlink( CAKESPEC_TEST_TMP . DS . 'chowntest'  . DS  . 'file.txt' );
        rmdir( CAKESPEC_TEST_TMP . DS . 'chmodtest'  );
        rmdir( CAKESPEC_TEST_TMP . DS . 'chowntest'  );
        rmdir( CAKESPEC_TEST_TMP  );
    }
    
    function testChmod() {
        touch( CAKESPEC_TEST_TMP . DS . 'chmodtest' . DS . 'file.txt' );
        $csfs = new CakeSpecFilesystem( CAKESPEC_TEST_TMP . DS . 'chmodtest' . DS . 'file.txt' );
        $csfs->chmod( array('mask'=>0777, 'recursive'=>true ) );
    }
    
    function testChown() {
        $csfs = new CakeSpecFilesystem( CAKESPEC_TEST_TMP . DS . 'chowntest' . DS . 'file.txt' );
        $csfs->chown( array( 'username'=>'nobody', 'nogroup'=>'nogroup', 'recursive'=>true ) );
    }
    */
}
