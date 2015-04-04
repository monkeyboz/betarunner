<?php
    include_once('MainClass.php');
    
    class CreateForm extends MainClass{
        var $args;
        
        public function __deconstruct(){  }
        
        public function create_fields($args){
            $table = $args[0];
            $columns = $this->query('SELECT * FROM information_schema.columns WHERE table_schema = "quanticdb" AND (TABLE_NAME="'.$table.'")');
            //print '<pre>'.print_r($columns,true).'</pre>';
            echo '<h1>Edit Fields</h1>';
            foreach($columns['results'] as $k=>$f){
                echo $f['COLUMN_KEY'];
                if($f['COLUMN_KEY'] == 'MUL'){
                    print '<pre>'.print_r($this->query('SELECT * FROM information_schema.key_column_usage'),true).'</pre>';
                }
                switch(preg_replace('/\(\d+\)/i','',$f['COLUMN_TYPE'])){
                    case 'varchar':
                        echo '<div><label>'.$f['COLUMN_NAME'].'</label><input type="text" name="'.$f['COLUMN_NAME'].'" /></div>';
                        break;
                    case 'int':
                        echo '<div><label>'.$f['COLUMN_NAME'].'</label><input type="number" name="'.$f['COLUMN_NAME'].'"/></div>';
                    default;
                        break;
                }
            }
        }
    }
?>