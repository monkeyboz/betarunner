<?php
    class DB{
        var $conn;
        
        function __construct(){
			$this->error = array();
			$this->conn = mysql_connect('localhost','monkeyboz','ntisman1');
			mysql_select_db('quanticdb');
		}
		
		function __destruct(){
			mysql_close($conn);
		}
        
        //-------------------------------------------------------------------
		/* Used to create mysql query as well as placing checks on the queries to posted information if there are other information required 
		   that is not provided there will be several informational returns used to keep sanitization requirements met through various outside 
		   calls. */
	    //-------------------------------------------------------------------
		public function query($query,$return_query = false){
			$success = array();
			$results = mysql_query($query) or $success['error'] = mysql_error();
			
			$this->error[] = $success['error'];
			//either return result set or error report
			if(isset($success['error'])){
				echo $succes['error'];
				//$this->logging(json_encode($success['error']).' - '.$query.' - '.$_SERVER['REMOTE_ADDR'],$_SESSION['user_id']);
			} else {
			    $success['results'] = array();
			    while($row = mysql_fetch_assoc($results)){
			        $success['results'][] = $row;
			    }
			}
			//return query to make sure things are golden
			if($return_query == true){
			    $success['query'] = $query;
			}
			return $success;
		}
    }
?>