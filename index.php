<?php
    include_once('config.php');
    
	if(isset($_GET['id']) && preg_match('/ajax/i',$_GET['id']) == true){
	    include('./controllers/ajax.php');
	} else {
        include_once('./controllers/TableCreator.php');
	    include_once('./controllers/FTP.php');
?>
<html>
    <head>
        <title>Beta Runner</title>
        <link href="css/style.css" rel="stylesheet"></link>
        <script src="js/drag_drop.js"></script>
        <script src="js/update.js"></script>
        <style>
            #drag_drop{
                background: rgba(0,0,0,.1);
                padding: 10px;
                width: 100%;
                height: 300px;
            }
            body{
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .layout{
                position: absolute;
                right: 10px;
                top: 10px;
                width: 300px;
                height: 300px;
                background: #00ff00;
            }
            .parse{
                background: #fff;
                color: #000;
                width: 100px;
                height: 30px;
                position: relative;
                padding: 10px;
            }
            .something{
                background: #000;
                width: 100px;
                height: 20px;
            }
            #drop{
                background: #000;
                width: 500px;
                height: 200px;
                color: #fff;
                padding: 10px;
                float: right;
            }
            #somethingelse{
                margin-top: 90px;
            }
            .item{
                background: #fff;
                padding: 10px;
                color: #000;
                margin-bottom: 2px;
            }
            .info li{
                background: #fff;
                border-bottom: 3px solid #efefef;
                box-shadow: 0px 5px 10px rgba(0,0,0,.3);
                padding: 10px;
                list-style: none;
                margin: 0px;
            }
            #content-query > div{
                background: #545454;
                color: #242424d;
                padding: 10px;
                border-bottom: 1px solid #545454;
            }
            #layout{
                background: #000;
                padding: 10px;
                color: #fff;
            }
            #layout > div{
                height: 40px;
                line-height: 40px;
            }
            #layout span{
                float: right;
                background: #fff;
                color: #000;
                padding: 10px;
                height: 10px;
                line-height: 10px;
            }
        </style>
        <script>
        	window.onload = function(){
        		var testing = new tw_drag({'draggable':'info','droppable':'drop'});
        		clickSetup();
        	}
        </script>
    </head>
    <?php
        include_once('./controllers/StoredQueries.php');
        $table = new StoredQueries();
        $testing = $table->fetch_tables();
        
    ?>
    <body>
        <div id="layout"></div>
        <div id="holder">
        <?php 
        	$ftp = new FTP();
			$main_class = new TableCreator();
			echo $main_class->create_table('info_pull_wp',1000);
		?>
        </div>
        <div id="overlay">
            <div class="holder">
                <div class="form_holder"></div>
            </div>
        </div>
        <script>
        	var link = 'ajax/CreateForm/create_fields/categories';
        </script>
        <script src="js/edit_script.js"></script>
    </body>
</html>
<?php } ?>