<?php
/**
* CakeSpecConfig Class
* 
* Responsible for generating Config specific portions of a CakeSpec build
* 
*/
require_once('CakeSpecBase.php');

class CakeSpecAppConfig extends CakeSpecBase {
    
    protected $TmplCompiler;
    
    protected $rules = array(
        'core.php'=> array(
            'debug'=> array(
                'validate'=>'/^[012]$/',
                'match'=>"/(Configure::write\s*\(\s*'(debug)'\s*,\s*)([0-2]*)(\s*\);)/"
            ),
            'App.encoding'=> array(
                'validate'=>false,
                'match'=>"/(Configure::write\s*\(\s*'(App\.encoding)'\s*,\s*)'(UTF-8)('\s*\);)/"
            ),
            'Routing.prefixes'=>array(
                'validate'=>false,
                'match'=>"/\\/\\/(Configure::write\s*\(\s*'(Routing\.prefixes)'\s*,\s*)(array\('admin'\))(\s*\);)/"
            ),
            'Cache.disable'=>array(
                'validate'=>false,
                'match'=>"/\\/\\/(Configure::write\s*\(\s*'(Cache\.disable)'\s*,\s*)(true)(\s*\);)/"
            ),
            'Cache.check'=>array(
                'validate'=>false,
                'match'=>"/\\/\\/(Configure::write\s*\(\s*'(Cache\.check)'\s*,\s*)(true)(\s*\);)/"
            ),
            'LOG_ERROR'=> array(
                'validate'=>'/^[2]$/',
                'match'=>"/(define\(\s*'(LOG_ERROR)'\s*,\s*)([0-2]*)(\s*\);)/"
            ),
            'Security.level'=> array(
                'validate'=>'/^(low|medium|high)$/',
                'match'=>"/(Configure::write\s*\(\s*'(Security\.level)'\s*,\s*')(medium)('\s*\);)/"
            ),
            'Security.salt'=> array(
                'validate'=>'/^[A-Za-z0-9]+$/',
                'match'=>"/(Configure::write\s*\(\s*'(Security\.salt)'\s*,\s*')([A-Za-z0-9]*)('\s*\);)/"
            ),
            'Security.cipherSeed'=> array(
                'validate'=>'/^[0-9]+$/',
                'match'=>"/(Configure::write\s*\(\s*'(Security\.cipherSeed)'\s*,\s*')([0-9]*)('\s*\);)/"
            ),
            'Asset.timestamp'=>array(
                'validate'=>false,
                'match'=>"/\\/\\/(Configure::write\s*\(\s*'(Asset\.timestamp)'\s*,\s*)(true)(\s*\);)/"
            ),
            'Asset.filter.css'=>array(
                'validate'=>false,
                'match'=>"/\\/\\/(Configure::write\s*\(\s*'(Asset\.filter\.css)'\s*,\s*')(css\.php)('\s*\);)/"
            ),
            'Asset.filter.js'=>array(
                'validate'=>false,
                'match'=>"/\\/\\/(Configure::write\s*\(\s*'(Asset\.filter\.js)'\s*,\s*')(custom_javascript_output_filter\.php)('\s*\);)/"
            ),
            'Acl.classname'=> array(
                'validate'=>false,
                'match'=>"/(Configure::write\s*\(\s*'(Acl\.classname)'\s*,\s*')([A-Za-z]*)('\s*\);)/"
            ),
            'Acl.database'=> array(
                'validate'=>false,
                'match'=>"/(Configure::write\s*\(\s*'(Acl\.database)'\s*,\s*')([a-z]*)('\s*\);)/"
            ),
            'date_default_timezone_set'=> array(
                'validate'=>false,
                'match'=>"/\\/\\/((date_default_timezone_set)\s*\(\s*')(UTC)('\s*\);)/"
            )
        ) //end $rules['core.php']
    );
    
    public function __construct(  ) {
        //$this->TemplateCompiler = new ProTemplateCompiler();
        parent::__construct();                         
    }
    
    protected function replaceWithVariableCallback( $matches ) {
        return $matches[1] . '{$' . $matches[2] . '}' . $matches[4];
    } 
    
    public function prepareTemplate( $filename, $src, $vars, $rules ) {
        $tmpl = $src;
        foreach( $vars as $key=>$val ) {
            if ( array_key_exists($key, $this->rules[$filename] ) ) {
                $tmpl = preg_replace_callback(
                    $this->rules[$filename][$key]['match'],
                    'CakeSpecAppConfig::replaceWithVariableCallback', 
                    $tmpl
                ); 
            }                
        }     
        return $tmpl; 
    } 
    
    public function compileTemplate( $filename, $template, $vars ) {
        $compiled_template = $template;
        foreach( $vars as $key=>$val ) {
            $compiled_template = preg_replace(
                "/{\\$" . preg_quote($key) . "}/",
                $val, 
                $compiled_template
            );             
        }     
        return $compiled_template;
    }   
}