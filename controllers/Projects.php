<?php
    class Projects{
        public function main_process(){ ?>
            <div>
                <?php ?>
            </div>
<?php   }
        
        public function step1(){
            $phpVersion = (phpversion() > 4)?true:false;
            $mysqlInstalled = (function_exists('mysql_connect'))?true:false;
            $directoryWritePermissions = (is_writable('./projects'))?true:false;
        ?>
                <h1>Beta Runner Install</h1>
                <h2>Server Health and Optimization Requirements</h2>
                <form action="?step=2" method="POST">
                <table>
                    <tr>
                        <td>PHP 5.3+</td>
                        <td class="<?php if($mysqlInstalled){ echo 'checked'; } else { echo 'failed'; } ?>"></td>
                    </tr>
                    <tr>
                        <td>MySql Installed </td>
                        <td class="<?php if($mysqlInstalled){ echo 'checked'; } else { echo 'failed'; } ?>"></td>
                    </tr>
                    <?php if($mysqlInstalled){ ?>
                    <tr>
                        <td colspan="2" style="background: #545454; color: #fff;">
                            <div style="font-size: 10px; margin-bottom: 10px; padding: 10px; background: #00ff00; color: #000;">Please fill out the following information.</div>
                            <div style="margin-top: 10px;">ServerHost</div>
                            <div><input type="text" name="serverhost"/></div>
                            <div style="margin-top: 10px;">Username</div>
                            <div><input type="text" name="username"/></div>
                            <div style="margin-top: 10px;">Password</div>
                            <div><input type="text" name="password"/></div>
                            <div style="margin-top: 10px;">Port</div>
                            <div><input type="text" name="port"/></div>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Directories Writable</td>
                        <td class="<?php if($directoryWritePermissions){ echo 'checked'; } else { echo 'failed'; } ?>"></td>
                    </tr>
                </table>
                <?php if($phpVersion && $mysqlInstalled && $directoryWritePermissions){ ?>
                    <input type="hidden" name="phpVersion" value="<?php echo phpversion(); ?>"/>
                    <input type="hidden" name="mysqlInstalled" value="passed"/>
                    <input type="hidden" name="directoryWritePermissions" value="passed"/>
                    <input type="submit" name="Continue" value="Continue >"/>
                <?php } ?>
                </form>
<?php
        }
        
        public function step2(){
            $server = (isset($_POST['serverhost']))?$_POST['serverhost']:'';
            $username = (isset($_POST['username']))?$_POST['username']:'';
            $password = (isset($_POST['password']))?$_POST['password']:'';
            $port = (isset($_POST['port']))?$_POST['port']:'';
            if($port == '' || $password == '' || $username == '' || $server == ''){ ?>
            <script>
                window.location.href = 'install.php';
            </script>
        <?php } else {
        ?>
            <div>
        <form action="activate.php" method="POST">
            <div>
                <label>Project Name</label>
                <input type="text" name="project_name"/>
            </div>
            <div style="clear: both; margin-bottom: 20px">
                <div><label>Remote</label><input type="radio" name="remote" value="remote" class="server"/></div>
                <div><label>Local</label><input type="radio" name="remote" value="local" class="server"/></div>
            </div>
            <div id="server_directories">
                <fieldset>
                    <legend>Server Directory</legend>
                    <label>Project Directory</label>
                    <input type="text" name="directory"/>
                </fieldset>
            </div>
            <div id="server_remote">
                <fieldset>
                    <legend>Server Remote</legend>
                    <div class="row">
                        <label>FTP Server</label>
                        <input type="text" name="ftpserver"/>
                    </div>
                    <div class="row">
                        <label>UserName</label>
                        <input type="text" name="username"/>
                    </div>
                    <div class="row">
                        <label>Password</label>
                        <input type="password" name="password"/>
                    </div>
                </fieldset>
            </div>
            <input type="submit" name="back" value="<< Back"/>
            <input type="submit" name="submit" value="Submit Project"/>
        </form>
    </div>
    <script>
        var serverType = document.getElementsByClassName('server');
        for(s in serverType){
            serverType[s].onchange = function(el){
                if(el.target.value == 'remote'){
                    document.getElementById('server_remote').style.display = 'block';
                    document.getElementById('server_directories').style.display = 'none';
                } else {
                    document.getElementById('server_directories').style.display = 'block';
                    document.getElementById('server_remote').style.display = 'none';
                }
            }
        }
    </script>
<?php   
            }
        }
        
        public function step3(){ 
            $scan = scandir('./projects');
            foreach($scan as $f){
                print_r($f);
            }
        }
    }
?>