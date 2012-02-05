<?php

class CakeSpecLintInternals extends CakeSpecLint {


    public function addError( $errStr ) {
        return parent::addError( $errStr );
    }
    
    public function isValidFilename( $str ) {
        return parent::isValidFilename( $str);   
    }
}