<?php

class CakeSpecBaseInternals extends CakeSpecBase {

    public function exec( $cmd ) {   
        return parent::exec( $cmd );
    }
    
    public function checkDependencies() {
        return parent::checkDependencies();    
    }
}