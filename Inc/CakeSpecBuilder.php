<?php
/**
    CakeSpecBuilder class
*/
include_once('CakeSpecBase.php');

class CakeSpecBuilder extends CakeSpecBase {

    protected $CakeSpec;    //CakeSpec object, set in ::__construct()
    protected $path;        //path to specfile
    
    /**
    * Class Constructor
    *
    */
    public function __construct( $specfile ) {

        //Define Constants if not already defined
        defined('CAKESPEC_DEBUG') or define( 'CAKESPEC_DEBUG', 0);

        //Check CakeSpec dependencies
        if (!defined('CAKESPEC_NODEP') ) {
            $this->checkDependencies();
        }

        //set ::path
        if ( substr( $specfile, 0 ,1) == '/' ) {
            $this->path = dirname(  $specfile ) . DS;
        } else {
            $this->path = dirname( getcwd() . DS . $specfile ) . DS;
        }
        
        //if specfile does not exist on disk, exit(1)
        if ( !file_exists( $specfile ) ) {
           cakespec_out( 'File not found: ' . $specfile );
           exit(1);
        }

        //read in specfile from disk
        cakespec_debug( 'Reading ' . $specfile .", " .  filesize($specfile) . " bytes" );
        $json = file_get_contents( $specfile );
         
        //decode specfile json, if parse error exit(1)
        if ( !$spec = json_decode( $json, true ) ) {
           cakespec_out( 'Invalid spec file' );
           cakespec_out( 'Try running cakespec with the --lint flag' );
           cakespec_out( );
           exit(1);
        }
        //set ::CakeSpec
        $this->CakeSpec = $spec['CakeSpec'];
    }

    /**
    *
    *
    */
    public function build() {
        cakespec_out( 'Building ' . $this->CakeSpec['App']['name'] );
        cakespec_out('Please be patient, this could take a few minutes', false);
        $this->processCake();
        cakespec_out('.', false); //progress
        $this->processAppConfig();
        cakespec_out('.', false); //progress
        $this->processAppConsole();
        cakespec_out('.', false); //progress
        $this->processAppPlugin();
        cakespec_out('.', false); //progress
        $this->processAppVendor();
        cakespec_out('.', false); //progress
        $this->processAppController();
        cakespec_out('.', false); //progress
        $this->processAppModel();
        cakespec_out('.', false); //progress
        $this->processAppView();
        cakespec_out('.', false); //progress
        $this->processAppWebroot();
        cakespec_out('.', false); //progress
        cakespec_out('done'); //done
    }

    /**
    *
    *
    */
    protected function processCake() {
        if ( !array_key_exists( 'Cake', $this->CakeSpec ) ) {
            return false;
        }

        cakespec_debug( 'Building Cake' );
        if ( file_exists( $this->path . $this->CakeSpec['App']['name'] ) ) {
            return;
        }
	    //Clone from github repo
	    if ( array_key_exists( 'git', $this->CakeSpec['Cake'] ) ) {
            cakespec_debug( 'Cloning CakePHP from github' );
            $this->exec( CAKESPEC_GIT_EXEC . ' clone -q ' . $this->CakeSpec['Cake']['git']['repo'] . ' ' . $this->path . $this->CakeSpec['App']['name'] );
            
            //Show a little progress
            cakespec_out('.', false);
            
            //Switch to specified tag
            if ( array_key_exists( 'tag', $this->CakeSpec['Cake']['git'] ) ) {
                chdir( $this->path . $this->CakeSpec['App']['name'] );
                cakespec_debug( CAKESPEC_GIT_EXEC . ' checkout ' . $this->CakeSpec['Cake']['git']['tag'] );
                $this->exec( CAKESPEC_GIT_EXEC . ' checkout -q ' . $this->CakeSpec['Cake']['git']['tag'] );
            }
            //Show a little progress
            cakespec_out('.', false);
            
        }

        //Process any filesystem directives
        if ( array_key_exists( 'filesystem', $this->CakeSpec['Cake'] ) ) {
            $this->processFilesystemDirectives( 
                $this->path . $this->CakeSpec['App']['name'],
                $this->CakeSpec['Cake']['filesystem']
            );
        }
    }

    /**
    *
    *
    */
    protected function processAppConfig() {
        if ( !array_key_exists( 'Config', $this->CakeSpec['App']  ) ) {
            return false;
        }
        cakespec_debug( 'Building App/Config' );

        $CConfig = new CakeSpecAppConfig( );
        $configPath = $this->path . $this->CakeSpec['App']['name'] . DS . 'app' . DS . 'Config';
        
        if ( array_key_exists( 'core.php', $this->CakeSpec['App']['Config'] ) ) {
            cakespec_debug( 'Building App/Config/core.php' );
            $prepared_template = $CConfig->prepareTemplate( 
                'core.php',
                file_get_contents($configPath . DS . 'core.php'), 
                $this->CakeSpec['App']['Config']['core.php'] 
            );

            $code = $CConfig->compileTemplate( 
                'core.php',
                $prepared_template, 
                $this->CakeSpec['App']['Config']['core.php']
            );
            echo $code;                
        }
        /**
        if ( array_key_exists( 'bootstrap.php', $this->CakeSpec['App']['Config'] ) ) {
            cakespec_debug( 'Building App/Config/bootstrap.php' );
            $code = $CConfig->bootstrap( $this->CakeSpec['App']['Config']['bootstrap.php'] );    
            echo $code;
        }

        if ( array_key_exists( 'database.php', $this->CakeSpec['App']['Config'] ) ) {
            cakespec_debug( 'Building App/Config/database.php' );
            $CConfig->database( $this->CakeSpec['App']['Config']['database.php'] );    
        }

        if ( array_key_exists( 'email.php', $this->CakeSpec['App']['Config'] ) ) {
            cakespec_debug( 'Building App/Config/email.php' );
            $CConfig->email( $this->CakeSpec['App']['Config']['email.php'] );    
        }

        if ( array_key_exists( 'routes.php', $this->CakeSpec['App']['Config'] ) ) {
            cakespec_debug( 'Building App/Config/routes.php' );
            $CConfig->routes( $this->CakeSpec['App']['Config']['routes.php'] );    
            
        }
        */

    }

    /**
    *
    *
    */
    protected function processAppConsole() {
        if ( !array_key_exists( 'Console', $this->CakeSpec['App'] ) ) {
            return false;
        }

        cakespec_debug( 'Building App/Console' );
    }

    /**
    *
    *
    */
    protected function processAppController() {
        if ( !array_key_exists( 'Controller', $this->CakeSpec['App'] ) ) {
            return false;
        }

        cakespec_debug( 'Building App/Controller' );
        $Controller = $this->CakeSpec['App']['Controller'];
        unset( $Controller['Component'] );
        
        foreach( $Controller as $clsName=>$obj ) {
            cakespec_debug( 'Building App/Controller/' . $clsName . '.php' );
            $cg = new CGCakeController();
            $code = "<?php\n";
            $code .= $cg->generate( $clsName, $obj );
            $code .= $this->tagline();

            cakespec_debug( 'Writing ' . $clsName . '.php to disk.');
            file_put_contents( 
                $this->path . $this->CakeSpec['App']['name'] . DS  . 'app' . DS . 'Controller' . DS . $clsName . '.php', 
                $code
            );
            $code='';
        } //end foreach

        $this->processAppControllerComponent();

    }

    /**
    *
    *
    */
    protected function processAppControllerComponent() {
        if ( !array_key_exists( 'Component', $this->CakeSpec['App']['Controller'] ) ) {
            return false;
        }

        cakespec_debug( 'Building App/Controller/Component' );
        //print_r( $this->CakeSpec['App']['Controller']['Component'] );
    }

    /**
    *
    *
    */
    protected function processAppModel() {
        if ( !array_key_exists( 'Model', $this->CakeSpec['App'] ) ) {
            return false;
        }

        cakespec_debug( 'Building App/Model' );
        $Model = $this->CakeSpec['App']['Model'];
        unset( $Model['Behavior'] );

        foreach( $Model as $clsName=>$obj ) {
            cakespec_debug( 'Building App/Model/' . $clsName . '.php' );
            $cg = new CGCakeModel();
            $code = "<?php\n";
            $code .= $cg->generate( $clsName, $obj );
            $code .= $this->tagline();
            
            cakespec_debug( 'Writing ' . $clsName . '.php to disk.');
            file_put_contents( 
                $this->path . $this->CakeSpec['App']['name'] . DS  . 'app' . DS . 'Model' . DS . $clsName . '.php', 
                $code
            );
            $code='';
        } //end foreach
        
        $this->processAppModelBehavior();
    }

    /**
    *
    *
    */
    protected function processAppModelBehavior() {
        if ( !array_key_exists( 'Behavior', $this->CakeSpec['App']['Model'] ) ) {
            return false;
        }

        cakespec_debug( 'Building App/Model/Behavior' );

    }

    /**
    *
    *
    */
    protected function processAppPlugin() {
        cakespec_debug( 'Building App/Plugin' );
    }

    /**
    *
    *
    */
    protected function processAppVendor() {
        cakespec_debug( 'Building App/Vendor' );
    }

    /**
    *
    *
    */
    protected function processAppView() {
        cakespec_debug( 'Building App/View' );
    }

    /**
    *
    *
    */
    protected function processAppViewHelper() {
        cakespec_debug( 'Building App/View/Helper' );
    }

    /**
    *
    *
    */
    protected function processAppWebroot() {
        cakespec_debug( 'Building App/webroot' );
    }
    
    protected function tagline() {
        if ( !defined('CAKESPEC_NOTAGLINE') ) {
            return "\n/** " . CAKESPEC_TAGLINE . " */";
        }
    }
    
    protected function processFilesystemDirectives( $path, $directives ) {
        cakespec_debug( 'Processing Filesystem directives on ' . $path );    
        $csfs = new CakeSpecFilesystem( $path );
        foreach ( $directives as $cmd=>$args ) {
            switch( $cmd ) {
                case 'chmod':
                    $csfs->$cmd( $args );
                    break;
                case 'chown':
                    $csfs->$cmd( $args );
                    break;
                default:
                    cakespec_debug( 'Unknown filesystem directive ' . $cmd );
            }    
        }
        
    }

} //end CakeSpecBuilder
