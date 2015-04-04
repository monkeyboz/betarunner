<?php
    include_once('MainClass.php');
    
    class TableCreator extends MainClass{
        
        //Pagination routine used to create pagination for various opbjects and items in the system
        public function pagination($total_items,$offset=100,$curr=0){
	        $pages = ceil($total_items/$offset);
	        
	        $string = '<div id="pagination">';
	        
	        $ordering = '';
	        if(isset($_GET['order'])){
	            $ordering = '&order='.$_GET['order'];
	        }
	        
	        //makes uses of up to 19 numbers to then calculate appropriate options
	        if($pages < 20){
	            //makes use of the lower page numbering to create a linear numbering display
	            for($i = 1; $i <= $pages; ++$i){
	                if($curr == $i){
	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'" class="curr_page">'.$i.'</a>';
	                } else {
	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'">'.$i.'</a>';
	                }
	            }
	        } else {
	            //if the current page is greater than 10 then we will asume that we are now capable of making a bigger display to traverse 
	            //records and pages more thoroughly.
	            if($curr > 10){
	                //if the current page reaches 8 pages to the end, then we will make sure that the required action is taken to balance
	                //traversal of the pagination and keep the pages from going over the total page number.
	                if($curr >= $pages-8){
	                	$string .= '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$ordering.'">1</a> ...';
	                	for($i = $pages-10; $i <= $pages; ++$i){
	                		if($curr == $i){
	    	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'" class="curr_page">'.$i.'</a>';
	    	                } else {
	    	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'">'.$i.'</a>';
	    	                }
	                	}
	                	//otherwise continue through the traversal in a linear manner with a split between the current page and following/previous 
	                	//pages
	                } else {
	                    //show the first page of the data set and space according to show separation and page spanning
		                $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$ordering.'">1</a> ...';
		                //show the previous 4 pages before the current page in the pagination
		                for($i = $curr-4; $i < $curr; ++$i){
		                    if($curr == $i){
	    	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'" class="curr_page">'.$i.'</a>';
	    	                } else {
	    	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'">'.$i.'</a>';
	    	                }
		                }
		                //show the following 4 pages after the current page
	    	            for($i = $curr; $i < $curr+4; ++$i){
	    	                if($curr == $i){
	    	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'" class="curr_page">'.$i.'</a>';
	    	                } else {
	    	                    $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'">'.$i.'</a>';
	    	                }
	    	            }
	    	            
	    	            //show the page
	    	            $string .= ' ... <a href="'.$_SERVER['PHP_SELF'].'?page='.($curr+10).$ordering.'">'.($curr+10).'</a> ... ';
	    	            $string .= ' <a href="'.$_SERVER['PHP_SELF'].'?page='.($page).$ordering.'">'.($page).'</a>';
	                }
	                //otherwise display up to the 11th page, display the 10th page from the total pages and the final page numbered through
	                //pagination
	            } else {
	                for($i = 1; $i <= 11; ++$i){
	                    if($curr == $i){
	                        $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'" class="curr_page">'.$i.'</a>';
	                    } else {
	                        $string .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.$ordering.'">'.$i.'</a>';
	                    }
	                }
	                $string .= ' ... <a href="'.$_SERVER['PHP_SELF'].'?page='.($pages-10).$ordering.'">'.($pages-10).'</a>';
	                $string .= ' ... <a href="'.$_SERVER['PHP_SELF'].'?page='.$pages.$ordering.'">'.$pages.'</a>';
	            }
	        }
	        return $string.'</div>';
		}
		
		function delete_table($table){
			foreach($_POST as $k=>$p){
				if($k != 'delete'){
					$this->delete_record($table,str_replace('field_','',$k));
				}
			}
		}
		
		function create_table($table,$limit=100,$where='',$columns=array()){
		    
		    if(is_array($where)){
		        $where_holder = '';
		        foreach($where as $k=>$f){
		            $f['value'] = ($f['comparision'] != 'LIKE')?$f['value']:'%'.$f['value'].'%';
		          
		            $where_holder = $k.' '.$f['comparison'].' "'.$f['value'].'" AND';
		        }
		        $where = 'WHERE '.substr($where_holder,0,-3);
		    }
		    
			if(isset($_POST['delete'])){
				$this->delete_table($table);
			}
			
		    $offset = $limit;
		    $order = '';
		    if(isset($_GET['order'])){
		    	$order_holder = explode('_',$_GET['order']);
			    if($order_holder[sizeof($order_holder)-1] == 'DESC'){
			    	$order = ' ORDER BY '.substr($_GET['order'],0,strrpos($_GET['order'],'_')).' DESC';
			    } else {
			    	$order = ' ORDER BY '.$_GET['order'].' ASC';
			    }
		    }
		    
		    if(isset($_GET['page'])){
		        $page = $_GET['page'];
		    } else {
		        $page = 1;
		    }
		    
		    $table_column_search = '';
		    $value_search = array();
		    if(is_array($table)){
		        $table_holder = '';
		        foreach($table as $t){
		            $table_holder .= 'table_name="'.$t.'" OR ';
		            $value_search[] = $t.' as '.substr($t,0,1);
		        }
		        
		        $column = '';
		        $table_alias = '';
		        foreach($value_search as $k=>$v){
		            $table_alias .= $v.' JOIN ';
		            if(!is_array($columns)){
		                $column .= substr($v,strpos($v,' as ')+4,strlen($v)).'.'.$columns.'=';
		            }
		        }
		        
		        $table_column_search = substr($table_holder,0,-3);
		        $table = substr($table_alias,0,-5).' ON '.substr($column,0,-1);
		    } else {
		        $table_column_search = 'table_name="'.$table.'"';
		    }
		    
		    $limit = ($page == 1)?'LIMIT 0,'.$limit:'LIMIT '.(($limit*$page)-$limit).','.$limit;
		   	$result = $this->query('SELECT * FROM '.$table.' '.$where.' '.$order.' '.$limit.' ');
		   	
			$columns = $this->query('SELECT * FROM information_schema.columns WHERE table_schema = "quanticdb" AND ('.$table_column_search.')');

			$header = '<form action="" method="POST"><table style="width: 100%;"><tr>'."\n\r";
			$headers = array();
			$header .= '<th></th>';
			foreach($columns['results'] as $row){
				$header .= '<th><a href="[link]">'.$row['COLUMN_NAME'].'</a> <span><img src="images/arrow.png" [rotate] /></span> </th>';
				$link = '';
				$separator = '?';
				if(isset($_GET['page'])){
				    $link .= '?page='.$_GET['page'];
				    $separator = '&';
				}
				
				if(isset($_GET['order']) && $_GET['order'] == $row['COLUMN_NAME']){
				    $link .= $separator.'order='.$_GET['order'].'_DESC';
				    $header = str_replace('[rotate]','',$header);
				}else{
				    $link .= $separator.'order='.$row['COLUMN_NAME'];
				    $header = str_replace('[rotate]','style="transform: rotate(180deg); -ms-transform: rotate(180deg); /* IE 9 * -webkit-transform: rotate(180deg); /* Chrome, Safari, Opera */"',$header);
				}
				
				$header = str_replace('[link]',$link,$header);
				$headers[] = $row['COLUMN_NAME'];
			}
			$header .= '<th>Actions</th>';
			$header .= '</tr>';
			
			$row_str = '';
		    foreach($result['results'] as $row){
				$row_str .= '<tr>';
				$row_str .= '<td><input type="checkbox" name="field_'.$row[$headers[0]].'"/></td>';
				foreach($headers as $f){
					$row_str .= '<td>'.$row[$f].'</td>';
				}
				$row_str .= '<td class="action"><a href="'.$_SERVER['PHP_SELF'].'/edit/'.$row[$headers[0]].'">Edit</a><a href="'.$_SERVER['PHP_SELF'].'/edit/'.$row[$headers[0]].'">Delete</a></td>';
				$row_str .= '</tr>'."\n\r";
			}
			
			$row_str .= '</table>';
			$row_str .= '<input type="submit" value="Delete" name="delete"/><input type="submit" value="Edit" name="edit"/></form>';
			$total_pages = $this->query('SELECT count(*) FROM '.$table.' '.$where);
			$pagination = $this->pagination($total_pages['results'][0]['count(*)'],$offset,$page);
			return $header.$row_str.$pagination;
		}
    }
?>