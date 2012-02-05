<?php
include_once('CGBase.php');
class CGClass extends CGBase {
    protected $name = 'Class';
    protected $template;
    
    public function __construct() {
        //parent::__construct();     
    }
    
    public function generate( $clsName, $spec ) {
        
        //Generate top of file comments
        $code = $this->genClassCommentBlock( $clsName, $spec );
        
        //Generate class definitions
        if ( array_key_exists( 'extends', $spec ) ) {
                $extendsCls = 'extends ' . $spec['extends'];
        }  else {
                $extendsCls = '';
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
    
    /**
    * generate a class comment block
    * 
    * @param mixed $name
    * @param mixed $class
    */
    protected function genClassCommentBlock( $name, $class ) {
        $code = "/**\n";
        $code .= "* $name Class\n";
        
        //if ( array_key_exists() ) {
        //    $code .="* " . $class;
        //} 
        $code .= "*\n";
 
        //if ( array_key_exists('comments', $this->vars ) ) {
        //    foreach( $this->vars as $key=>$val ) {
        //        $code .= "* @" . $key . $val;    
        //    }
        //}
        
        $code .= "*\n";
        $code .= "*/\n";
        return $code;        
    }
    /**
    * generate a method comment block
    * 
    * @param mixed $name
    * @param mixed $method
    * @param mixed $comment
    */
    protected function genMethodCommentBlock( $name, $method ) {
        $code = "/**\n";
        $code .= "* $name Method\n";
        $code .= "*\n";
        
        if ( array_key_exists( 'comment',  $method ) ) {
            $code .="* " . $method['comment'] . "\n";
            $code .= "*\n";
        }
        
        if ( array_key_exists('params', $method ) ) {
            foreach ( $method['params'] as $paramName=>$param ) {
                $code .= "* @param mixed";
                if ( preg_match( '/[0-9]+/', $paramName ) ) {
                    if ( substr($param, 0, 1) == '$' ) {
                         $code .= " " . $param . "\n"; 
                    } else {
                         $code .= " $" . $param . "\n"; 
                    }
                } else {
                    if ( substr($paramName, 0, 1) == '$' ) {
                         $code .= " " . $paramName . "\n"; 
                    } else {
                         $code .= " $" . $paramName . "\n"; 
                    }
                }   
            }
        }
        $code .= "*/\n";
        return $code;
    }  

     protected function genProperty( $name, $prop ) {
        $code = '';
        if ( array_key_exists( 'visibility', $prop ) ) {
            $code .= $prop['visibility'] . " ";    
        } else {
            $code .= "protected ";     
        }
        $code .="\$" . $name;

        if ( array_key_exists( 'value', $prop ) ) {
            //echo "\$prop['value'] for $name\n";
            //print_r( $prop['value'] );
            if ( is_array( $prop['value'] ) ) {
                $code .= " = " . $this->genArray( $prop['value'] ) . ";\n";
            } else {
                $code .= " = '" . $prop['value'] . "';\n";    
            }
            
        } else {
            $code .=";\n";
        }
        return $code;
    } //end genProperty 
    
    protected function genMethod( $name, $method ) {
        $code = '';
        //if comments key is present then override default method comment block
        if ( array_key_exists( 'comments', $method ) ) {
            $code = "//". $method['comments'] . "\n";
        } else { 
            //generate method comment block
            $code .= $this->genMethodCommentBlock( $name, $method );
        }
        
        if ( array_key_exists( 'visibility', $method ) ) {
            $code .= $method['visibility'] . " ";    
        } else {
            $code .= "protected ";     
        }
        
        $code .= 'function ' . $name . '(';

        if ( array_key_exists( 'params', $method ) ) {
            $code .= $this->genMethodParams( $method['params'] );
            $code .= " ) {\n";
        } else {
            $code .= ") {\n";
        }

        if ( array_key_exists('callParent', $method ) && $method['callParent'] == 'before' ) {
            $code .= $this->indent( "parent::" . $name . "();\n" );
        }

        if ( array_key_exists( 'code', $method ) ) {
            $code .= $this->indent( $this->genCode( $method['code'] ) );
        }        
        $code .= "\n";    
        if ( array_key_exists('callParent', $method ) && $method['callParent'] == 'after' ) {
            $code .= $this->indent( "parent::" . $name . "();\n" );
        }
        if ( array_key_exists('return', $method ) ) {
            $code .= $this->indent( "return " . $method['return'] . ";\n" );
        }
        $code .= "} //end $name\n";    
        return $code;
    }

    protected function genMethodParams( $params ) {
        $code = ''; $sep = '';
        foreach( $params as $paramName=>$param ) {
            if ( preg_match( '/[0-9]+/', $paramName ) ) {
                $code .= $sep;
                if ( substr($param, 0, 1) == '$' ) {
                     $code .= " " . $param; 
                } else {
                     $code .= " $" . $param; 
                }
            } else {
                if ( substr($paramName, 0, 1) == '$' ) {
                     $code .= " " . $paramName; 
                } else {
                     $code .= " $" . $paramName; 
                }
                $code .= $sep . " " . $paramName;
            }
            $sep = ',';
        }
        return $code;
    } 
} //end CGClass