<?php
/**
* ProTemplateCompiler Class
* 
* This class uses regex to prepare and compile text templates
* 
*/
class ProTemplateCompiler {
    protected $template;
    protected $rules = array();
    protected $tag = '{$tag}';
    
    public function __construct( $template='', $rules='', $tag='' ) {
        $this->template = $template;
        if (!empty( $tag ) ) {
            $this->tag = $tag;    
        }
        if( !empty( $rules ) && is_array( $rules ) ) {
            $this->rules = $rules;
            $this->prepare();
        }
    }
  
    protected function prepare( ) {
        $tmpl = $this->template;
        foreach( $this->rules as $key=>$rule ) {
            $tmpl = preg_replace_callback(
                $rule['match'],
                'ProTemplateCompiler::replaceWithVariableCallback', 
                $tmpl
            );               
        }     
        $this->template = $tmpl;
    } 
    
    /**
    * Takes associative array in, $data 
    * replaces template tags with match keys in data
    * and returns the compiled template as text
    * 
    * @param mixed $vars
    * @return string
    */
    public function compile( $dataArr ) {
        $compiled_template = $this->template;
        foreach( $dataArr as $key=>$val ) {
            $compiled_template = preg_replace(
                "/{\\$" . preg_quote($key) . "}/",
                $val, 
                $compiled_template
            );             
        }     
        return $compiled_template;
    }
    
    protected function replaceWithVariableCallback( $matches ) {
        //print_r( $this );
        //TODO Add support for custom Tags
        return $matches[1] . '{$' . $matches[2] . '}' . $matches[4];
    }    
}