<?php
require_once('CGClass.php');
class CGCakeClass extends CGClass {
    protected $name = 'CakeClass';
    protected $vars = array();
    protected $template;
    
    public function __construct(  ) {
        parent::__construct();
    }
    
    public function generate( $clsName, $spec ) {
        
        //Generate top of file comments
        $code = $this->genClassCommentBlock( $clsName, $spec );
        
        //Generate code above the class definition
        if ( array_key_exists( 'AppUses', $spec ) ) {
            foreach( $spec['AppUses'] as $key=>$val ) {
                $code .= "App::uses( '$key', '$val' );\n";
            }
            $code .= "\n";
        }
        
        //Generate class definitions
        if ( array_key_exists( 'extends', $spec ) ) {
                $extendsCls = 'extends ' . $spec['extends'];
        } elseif( $clsName == 'App' . $this->name )  {
                $extendsCls = 'extends ' . $this->name;
        } else {
                $extendsCls = 'extends App' . $this->name;
        }
        $code .= "class $clsName $extendsCls {\n";
        $code .= "\n";
        
        //Generate class properties
        if ( array_key_exists( 'properties', $spec ) ) {
            foreach( $spec['properties'] as $name=>$prop ) {
                $code .= $this->indent( $this->genProperty( $name, $prop ) );
            }    
            $code .= "\n";
        }
        
        //Generate class methods
        if ( array_key_exists( 'methods', $spec ) ) {
            foreach( $spec['methods'] as $name=>$method ) {
                $code .= $this->indent( $this->genMethod( $name, $method ) );
                $code .= "\n";
            }    
        }
        
        //Generate class closing tag
        $code .= "}\n";
        //Return generated code
        return $code;
        
    } //end generate()
    
} //end CGCakeClass