<?php
class CGClassInternals extends CGClass {
    
    public function genClassCommentBlock( $name, $class ) {
        return parent::genClassCommentBlock( $name, $class );
    }
        
    public function genMethodCommentBlock( $name, $method, $comment='' ) { 
        return parent::genMethodCommentBlock( $name, $method, $comment );
    }
    
    public function genProperty( $name, $prop ) {
        return parent::genProperty( $name, $prop );
    }
    
    public function  genMethod( $name, $method ) {
        return parent::genMethod( $name, $method );
    }
        
    public function genMethodParams( $params ) {
        return parent::genMethodParams( $params );
    }

}