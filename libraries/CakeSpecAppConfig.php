<?php
/**
* CakeSpecConfig Class
* 
* Responsible for generating Config specific portions of a CakeSpec build
* 
*/
require_once('CakeSpecBase.php');
class CakeSpecAppConfig extends CakeSpecBase {
    
    
    protected $coreRules = array(
        'debug'=> array(
            'validate'=>'/^[012]$/',
            'match'=>"/('debug', )([0-9])\)/"
        ),
        'App.encoding'=> array(
            'match'=>"/('App\.encoding', ')(UTF-8)(')/"
        ),
        'ERROR_LOG'=> array(
            'validate'=>'/^[2]$/',
            'match'=>"/(define\('LOG_ERROR', )([2])(\))/"
        ),
        'Security.level'=> array(
            'validate'=>'/^(low|medium|high)$/',
            'match'=>"/('Security\.level', ')(medium)(')/"
        ),
        'Security.salt'=> array(
            'validate'=>'/^[A-Za-z0-9]+$/',
            'match'=>"DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi"
        ),
        'Security.cipherSeed'=> array(
            'validate'=>'/^[0-9]+$/',
            'match'=>"76859309657453542496749683645"
        ),
        'Acl.classname'=> array(
            'match'=>"/('Acl\.classname', ')(.*)(')/"
        ),
        'Acl.database'=> array(
            'match'=>"/('Acl\.database', ')(.*)(')/"
        )
    );
    
    public function __construct(  ) {


        parent::__construct();   
    }

    public function core( $orig, $coreSpec ) {
        $new = $orig;
        foreach( $coreSpec as $key=>$val ) {
            if ( array_key_exists($key, $this->coreRules ) ) {
                echo "\$val = $val\n" ;
                /*
                if ( array_key_exists('validate', $this->coreRules[$key] )
                    && substr( $this->coreRules[$key]['validate'], 0, 1) == '/'
                ) { 
                    if ( preg_match( $this->coreRules[$key]['validate'],  $val ) ) {
                        $new = preg_replace(
                            $this->coreRules[$key]['match'],
                            "$1$val$3", 
                            $new
                        ); 
                    }                   
                } elseif( ) {
                        $new = preg_replace(
                            $this->coreRules[$key]['match'],
                            "$1$val$3", 
                            $new
                        );                    
                }
                */
                
            }                
        }
                
        return $new;        
    }  

    public function bootstrap( $coreSpec ) {
    
    } 
          
    public function database( $dbSpec ) {
        
    }

    public function email( $emailSpec ) {
        
    }
        
}