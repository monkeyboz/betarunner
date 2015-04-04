<?php
    include_once('./controllers/MainClass.php');
	class Ajax extends MainClass{
	    var $args;
	    var $class_name;
	    var $errors;
	    
	    //--------------------------------------------------------------------------------
	    //constructor used to create multiple calls for ajax requests.  This constructor is used to create simple class function calls
	    //required to connect to the databases and several other options used by this class
	    //--------------------------------------------------------------------------------
		function __construct($request){
			$this->args = $request;
			
			//remove original ajax class call for .htaccess routing
			array_shift($this->args);
			//remove the class name being called for the ajax call
			$this->class_name = array_shift($this->args);
			
			//call the controller using the class_name pulled from the request array being passed throught the class constructor
			$this->call_controller($this->class_name);
		}
		
		//--------------------------------------------------------------------------------
		//destruct used to catch and show errors as well as disconnect from mysql database, and cache system data.
		//--------------------------------------------------------------------------------
		function __destruct(){	}
		
		//--------------------------------------------------------------------------------
	    //function used to call controller from the ajax url.  This is used in conjunction with the constructor for the ajax class
	    //--------------------------------------------------------------------------------
		public function call_controller($controller){
			include_once('./controllers/'.$controller.'.php');
			$controller = new $controller();
		    $routine = array_shift($this->args);
		    //if(function_exists($controller->{$routine})){
			    $controller->{$routine}($this->args);
		    /*} else {
		        echo $routine;
		    }*/
		}
	}
	
	$request = explode('/',$_GET['id']);
	$ajax = new Ajax($request);
?>