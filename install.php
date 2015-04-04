<?php 
    session_start();
    if(isset($_POST) && $_POST['phpVersion'] > 4 && $_POST['mysqlInstalled'] == 'passed' && $_POST['directoryWritePermissions'] == 'passed'){
        $_SESSION['step2'] = 'true';
    }
    if(!isset($_GET['step'])){
        $step_str = 'step1';
    } else {
        $step_str = 'step'.$_GET['step'];
    }
    include_once('./controllers/Projects.php');
    $step = new Projects();
?>
<html>
    <head>
        <title>Beta Runner Install</title>
        <style>
            body{
                font-family: arial;
                font-size: 11px;
            }
            .checked{
                background: #00ff00;
                padding: 10px;
            }
            .failed{
                background: #ff0000;
                padding: 10px;
            }
            tr{
                background: #efefef;
            }
            tr td{
                padding: 10px;
            }
            form > div{
                clear: both;
                padding: 10px;
                line-height: 30px;
            }
            form > div > div{
                float: left;
            }
            form > div > div > label{
                float: left;
                width: auto;
            }
            form input{
                background: #000;
                color: #fff;
                border-radius: 0px;
                border: none;
                padding: 10px;
                font-size: 14px;
                margin-top: 10px;
                font-weight: bold;
            }
            label{
                float: left;
                width: 150px;
            }
            #server_directories{
                display: none;
            }
            #server_remote{
                display: none;
            }
            .row{
                clear: both;
            }
            .row label{
                width: 100px;
            }
        </style>
    </head>
    <body>
<?php $step->{$step_str}(); ?>
    </body>
</html>