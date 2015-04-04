<?php
    include_once('DB.php');
    
	class MainClass extends DB{
		var $conn;
		var $render;
		var $error;
		
		//-------------------------------------------------------------------
		/* logging system used to keep logs of various calls which include numerous error catching and error reporting and it also requires 
		   details of the call and user id.  If these are not provided then it will take in the IP address and other required information
		   needed to report correctly */
		//-------------------------------------------------------------------
    	public function logging($details,$user){
			$success = true;
			if(!isset($user)){
			    $details .= ' - '.$_SERVER['REMOTE_ADDR'];
			}
			$success = $this->query('INSERT INTO logs (description,user_id) VALUES("'.$details.'","'.$user.'")') or $success['error'] = mysql_error();
			return $success;
		}
		
		public function login_check(){
		    if(isset($_SESSION['user_id']) && $_SESSION['user']){
		        
		    }
		}
		
		//-------------------------------------------------------------------
		/* Delete records from the server.  This is required with the login system.  Without the ability to login, there will be limited ability
		   to delete records */
		//-------------------------------------------------------------------
		public function delete_record($table,$id){
            $columns = $this->query('SELECT * FROM information_schema.columns WHERE table_schema = "quanticdb" AND (TABLE_NAME="'.$table.'")');
            $json = $this->query('SELECT * FROM '.$table.' WHERE '.$columns['results'][0]['COLUMN_NAME'].'='.$id);
            if(defined(AUTO_BACKUP)){
                $json = json_decode($this->query('SELECT * FROM '.$table.' WHERE '.$columns['results'][0]['COLUMN_NAME'].'='.$id));
            }
            $this->query('DELETE FROM '.$table.' WHERE '.$columns['results'][0]['COLUMN_NAME'].'='.$id);
            $user_id = (isset($_SESSION['user_id']))?$_SESSION['user_id']:0;
			$this->logging('DELETE FROM '.$table.' WHERE '.$columns['results'][0]['COLUMN_NAME'].'='.$id.' '.$json,$user_id);
		}
	}
?>