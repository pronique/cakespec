<?php
/**
* All Code Generate Classes should descend from CGBase
* 
* A property or method added to CGBase will be inherited by all CG* classes
*/
class CGBase {
    
    /**
    * Indent some code passed as an array
    * 
    * @param mixed $code
    * @param mixed $tabs
    */
    public function indent( $code, $tabs=1 ) {
        $indent = str_repeat( CAKESPEC_INDENT, $tabs );
        $codeArr = explode( "\n", $code );
        if ( $codeArr[count($codeArr)-1] == '') {
            array_pop( $codeArr );
        }
        $newCode = '';
        foreach( $codeArr as $line ) {
            $newCode .= $indent . $line . "\n";
        }
        return $newCode;
    }
    
    /**
    * Indent a string
    * 
    * @param mixed $str
    * @param mixed $tabs
    */
    public function indentStr( $str, $tabs=1 ) {
        $indent = str_repeat( CAKESPEC_INDENT, $tabs );
        return $indent . $str;
    }
    
    /**
    * Parse and return code array
    * 
    * @param array $codeArr
    */
    protected function genCode( $codeArr ) {
        $code = '';
        if ( is_array( $codeArr ) ) {
            foreach( $codeArr as $line) {
                $code .= $line . "\n"; 
            }
        } else {
            $code .= $codeArr . "\n";
        }
        return $code;
    }
    
    /**
    * Array generator with auto indention (recursive method)
    * 
    * @param mixed $arr
    * @param mixed $depth
    */
    protected function genArray( $arr, $depth=0 ) {
        $depth++;
        if ( !is_array( $arr ) ) { return "'$arr'"; }
        
        //The following code trys to figure out when an array is long or deep
        // and insert breaks and indentions to provide readability.
        if ( count( $arr ) > 3 || $this->array_depth( $arr ) > 1 ) {
            $multiline = true;
            $m = "\n" . $this->indentStr('', $depth );
            $mm = "\n"  . $this->indentStr('', $depth - 1 );
        } else {
            $multiline = false;
            $m = '';
            $mm = ' ';
        }

        $code = "array( ";
        $sep = '';
        foreach( $arr as $key=>$val ) {
            //when $key is alpha and value is 1 or empty then $key is a string value
            if ( !is_numeric($key) && ( $val == 1 || empty($val) ) ) {
                $code .= $sep . $m . "'$key'";
            } elseif(  is_numeric($key) ) { //when $key is numeric then we assume its an array of strings
                $code .= $sep . $m . "'$val'";
            } else { // All over cases are arrays or key=>val members of an array
                $code .= $sep . $m   .  "'$key' => " . $this->genArray( $val, $depth++ );      
            }
            $sep = ', ';    
        }
        $code .=  $mm . ')';
        return $code;        
    }
    
    /**
    * Returns the depth of an array (recursive method)
    * 
    * @param mixed $array
    */
    protected function array_depth($array) {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
    
} //end CGBase