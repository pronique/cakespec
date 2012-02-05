<?php
/**
    CakeSpecLint class
*/
require_once('CakeSpecBase.php');

class CakeSpecLint extends CakeSpecBase {

    protected $CakeSpec;
    protected $stopOnError;
    protected $errorCount = 0;
    protected $errors = array();

    public function __construct( $specfile, $stopOnError=true ) {

        $this->stopOnError =  $stopOnError;
	    defined('CAKESPEC_DEBUG') or define( 'CAKESPEC_DEBUG', 0);

        //Check CakeSpec dependencies
        if (!defined('CAKESPEC_NODEP') ) {
            $this->checkDependencies();
        }

        //set ::path
        if ( substr( $specfile, 0 ,1) == '/' ) {
            $this->path = dirname(  $specfile ) . DS;
        } else {
            $this->path = dirname( getcwd() . DS . $specfile ) . DS;
        }
        
        if ( !file_exists( $specfile ) ) {
            $this->addError( "File not found: " . $specfile );
            if ( $this->stopOnError ) { return false; }
        }
        
	    if ( !$spec = json_decode( file_get_contents( $specfile ), true ) ) {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                   break;
                case JSON_ERROR_DEPTH:
                    $this->addError( "JSON Error: Maximum stack depth exceeded" );
		           break;
	            case JSON_ERROR_STATE_MISMATCH:
                   $this->addError( "JSON Error: Underflow or the modes mismatch" );
                   break;
                case JSON_ERROR_CTRL_CHAR:
                    $this->addError( "JSON Error: Unexpected control character found" );
                    break;
                case JSON_ERROR_SYNTAX:
		            $this->addError( "JSON Error: Syntax error, malformed JSON" );
                    break;
                case JSON_ERROR_UTF8:
                    $this->addError( "JSON Error: Malformed UTF-8 characters, possibly incorrectly encoded" );
                    break;
                default:
                    $this->addError( "JSON Error: Unknown error" );
                    break;
            }
            
            if ( $this->errorCount > 0 ) {
                if ( $this->stopOnError ) { return false; }
            }
	    }
        
        if ( !array_key_exists('CakeSpec', $spec  ) ) {
            $this->addError( "CakeSpec object missing, { \"CakeSpec\": { /* spec */ } }" );
            if ( $this->stopOnError ) { return false; }
        } 
        
	    $this->CakeSpec = $spec['CakeSpec'];
        $this->lintApp();
	    $this->lintCake();
	    $this->lintAppConfig();
	    $this->lintAppController();
	    $this->lintAppLib();
	    $this->lintAppModel();
	    $this->lintAppPlugin();
	    $this->lintAppTest();
	    $this->lintAppTmp();
	    $this->lintAppView();
	    $this->lintAppWebroot();

	    return true;

    }

    /**
    * getter for Error Count
    * 
    */
    public function getErrorCount() {
        return $this->errorCount;    
    }
    
    /**
    * getter for last error
    * 
    */
    public function getLastError() {
        $errtmp = $this->errors;
        return array_pop( $errtmp );    
    }
    
    /**
    * getter for error text
    * 
    * @param mixed $id
    */ 
    public function getError( $id=null ) {
        if ( is_null( $id ) ) {
            return $this->getErrors();
        } 
        if ( array_key_exists( $id, $this->errors )  ) {
            return $this->errors[$id];
        }
        return false;
    } 

    /**
    * getter for error text
    * 
    * @param mixed $id
    */ 
    public function getErrors( ) {
        if ( $this->errorCount > 0 ) { 
            return $this->errors;
        } 
        return false;
    } 
        
    /**
    * Pushes error onto errors array and increments errorCount
    * 
    * @param mixed $errStr
    */
    protected function addError( $errStr ) {
        if (!empty( $errStr ) ) {
            $this->errors[] = $errStr;
            $this->errorCount++;
        }
    }
    
    protected function lintApp() {
        //cakespec_debug( $this->CakeSpec['App']['name'] );

        if ( !$this->isValidFilename( $this->CakeSpec['App']['name'] ) ) {
            $this->addError( "CakeSpec.App.name contains illegal characters" );
            if ( $this->stopOnError ) { return false; }
        }
    }
    protected function lintCake() {
        cakespec_debug( 'Checking CakeSpec.Cake' );

        if ( !array_key_exists( 'Cake', $this->CakeSpec ) ) {
            $this->addError( "CakeSpec.Cake object missing" );
            if ( $this->stopOnError ) { return false; }
        }
        
	    if ( !array_key_exists( 'git', $this->CakeSpec['Cake'] ) ) {
            $this->addError( "CakeSpec.Cake.git object missing" );
            if ( $this->stopOnError ) { return false; }
        }

        if ( !array_key_exists( 'repo', $this->CakeSpec['Cake']['git'] ) ) {
            $this->addError( "CakeSpec.Cake.git.repo member missing" );
            if ( $this->stopOnError ) { return false; }
        }

    }
    protected function lintAppConfig() {

    }
    
    protected function lintAppController() {

    }

    protected function lintAppLib() {

    }

    protected function lintAppModel() {

    }

    protected function lintAppPlugin() {

    }

    protected function lintAppTest() {

    }

    protected function lintAppTmp() {

    }

    protected function lintAppView() {

    }

    protected function lintAppWebroot() {

    }
    
    protected function isValidFilename( $str ) {
        if ( preg_match( '/^\./', $str ) ) {
            return false;
        }
        return !preg_match( '/[\t\\\?{}\:\;\/\*]+/', $str );
    }
}
