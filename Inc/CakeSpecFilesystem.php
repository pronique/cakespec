<?php
/**
* FileSystem operations 
* chown and chmod
*/
class CakeSpecFilesystem {
    protected $basePath = '.';
    
    public function __construct( $path='' ) {
        // IMPORTANT
        // We must be very careful with paths we will accept here
        if ( !empty($path) ) {
            $this->basePath = $path;
        }
    } //enc __construct

    /**
    * Process a chown directive
    * 
    * @param mixed $file
    * @param mixed $args
    */
    public function chown( $args ) {
        if ( !array_key_exists( 'user', $args ) || !array_key_exists( 'group', $args ) ) {
            return false; 
        }
        
        if ( array_key_exists( 'recursive', $args ) && $args['recursive'] == true ) {
            cakespec_debug( 'Filesystem: chown -R  ' . $args['user'] . ":" . $args['group'] .  $this->basePath );
            return $this->chownr( $this->basePath, $args['user'], $args['group'] );
        } else {
            cakespec_debug( 'Filesystem: chown ' . $args['user'] . ":" . $args['group'] . $this->basePath . ' ' );
            $result = false;
            $result = chown( $this->basePath , $args['user'] );
            return $result and chgrp( $this->basePath, $args['group'] );
        }       
    } //end chown
    
    /**
    * Process a chmod directive
    * 
    * @param mixed $file
    * @param mixed $args
    */
    public function chmod( $args ) {
        if ( !array_key_exists( 'mask', $args ) || !preg_match('/^0?[0-7]{3}$/', $args['mask'] )  ) {
            return false; 
        }
        if ( array_key_exists( 'recursive', $args ) && $args['recursive'] == true ) {
            cakespec_debug( 'Filesystem: chmod -R ' . $this->basePath . ' ' . $args['mask'] );
            return $this->chmodr( $this->basePath , $args['mask'] );
        } else {
            cakespec_debug( 'Filesystem: chmod ' . $this->basePath . ' ' . $args['mask'] );
            return chmod( $this->basePath , $args['mask'] );
        }
    } //end chmod
    
    /**
    * Recursive chmod
    * 
    * @param mixed $path
    * @param mixed $filemode
    */
    protected function chmodr($path, $filemode) { 
        if (!is_dir($path)) 
            return chmod($path, $filemode); 

        $dh = opendir($path); 
        while (($file = readdir($dh)) !== false) { 
            if($file != '.' && $file != '..') { 
                $fullpath = $path.'/'.$file; 
                if(is_link($fullpath)) 
                    return FALSE; 
                elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode)) 
                        return FALSE; 
                elseif(!$this->chmodr($fullpath, $filemode)) 
                    return FALSE; 
            } 
        } 

        closedir($dh); 

        if(chmod($path, $filemode)) 
            return TRUE; 
        else 
            return FALSE; 
    } //end chmodr
    
    /**
    * Recursive chown
    * 
    * @param mixed $path2dir
    * @param mixed $uid
    * @param mixed $gid
    */
    protected function chownr($mypath, $uid, $gid) { 
        $d = opendir ($mypath) ; 
        while(($file = readdir($d)) !== false) { 
            if ($file != "." && $file != "..") { 

                $typepath = $mypath . "/" . $file ; 

                //print $typepath. " : " . filetype ($typepath). "<BR>" ; 
                if (filetype ($typepath) == 'dir') { 
                    $this->chownr($typepath, $uid, $gid); 
                } 
                chown($typepath, $uid); 
                chgrp($typepath, $gid); 
                
            } 
        }
        chown($mypath, $uid); 
        chgrp($mypath, $gid);  

     } //end chownr 

}