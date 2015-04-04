<?php
    include_once('MainClass.php');
    
    class StoredQueries extends DB{
        public function fetch_databases(){
            $t = $this->query('SELECT * FROM information_schema.tables WHERE table_schema = "'.DB_DATABASE.'"');
            return json_encode($t);
        }
        
        public function fetch_tables(){
            $t = $this->query('SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = "'.DB_DATABASE.'"');
            return $t;
        }
        
        public function fetch_columns(){
            $t = $this->query('SELECT * FROM information_schema.columns WHERE TABLE_SCHEMA = "'.DB_DATEBASE.'"');
            return $t;
        }
    }
?>