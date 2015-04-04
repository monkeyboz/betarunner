<?php
    class FTP{
        var $dir;
        
        public function __construct(){
            $this->dir = WORKING_DIR;
        }
        
        public function __destruct(){
            
        }
        
        public function move_directories($args){
            extract($args);
            
            $dir = $args[0];
            $des = $args[1];
            
            if(is_dir($dir)){
                $l = scandir($dir);
            	
            	if(!is_dir($des)){
            		mkdir($des);
            	}
            	
            	foreach($l as $f){
            	    if($f != '.' && $f != '..'){
                		if(is_dir($dir.'/'.$f)){
                			$this->move_directories(array($dir.'/'.$f,$des.'/'.$f));
                		} else {
                			copy($dir.'/'.$f,$des.'/'.$f);
                		}
            	    }
            	}
            	if(substr($_GET['id'],0,strpos('/')) == 'ajax'){
            	    echo 'Directory saved.';
            	} else {
            	    return true;
            	}
            } else {
                if(substr($_GET['id'],0,strpos($_GET['id'],'/')) == 'ajax'){
            	    echo 'Directory does not exist.';
            	} else {
            	    return false;
            	}
            }
        }
        
        public function move_files(){
            
        }
        
        public function update_live(){
            
        }
        
        public function move_curr_project(){
            
        }
        
        public function store_public_project(){
            
        }
    }
?>