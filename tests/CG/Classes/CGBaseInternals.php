<?php
class CGBaseInternals extends CGBase {
    
    
    public function genCode( $codeArr ) {
        return parent::genCode( $codeArr );
    }
    
    public function genArray( $arr, $depth=0 ) {
        return parent::genArray( $arr, $depth=0 );
    }
    public function array_depth($array) {
        return parent::array_depth( $array );
    }
}