<!DOCTYPE html>
<?php
include 'header.php';
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>JMex beta</title>
        <script type="text/javascript" src="scripts.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
        <link href="styles/main.css" rel="stylesheet" type="text/css">
    </head>

        <?php
if(!isset($_SESSION['name'])){
    if(!isset($_POST['login'])){?>
     <body >
        <div>
            <form method="post" action="#" id="loginForm">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username"><br />
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br />
                <input type="submit" name="login" id="login" value="Login">
            </form>
        <?php
    }else{
        $username = $_POST['username'];
        $string = $_POST['password'];
        mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');
        $password = base64_encode(md5($string, true));
        $xget = mysqli_query($conn, "SELECT * FROM users WHERE name = '$username'");
        $countquery = mysqli_num_rows($xget);
        if($countquery == 1){
            $rows = mysqli_fetch_array($xget);
            $dbpsw = $rows["psw"];
            if($dbpsw == $password){
                $UUID = hash("sha256", microtime(true).$_SERVER['REMOTE_ADDR'].rand());
                $_SESSION['name'] = $username;
                $_SESSION['hash'] = $UUID;
                $myNow = new DateTime("Now");
                $query2 = mysqli_query($conn, "UPDATE users SET logged = '$UUID', lastActivity = now() WHERE name = '$username'");
                if($query2){
                    echo "Succesfully logged.";
                    header("location: .");
                }
            }else{
                die("Wrong password");
            }
        }
    }
}else{

    if(!isset($_POST['logout'])){
        ?><script>
        function addusers(){
        <?php
        $usersquery = mysqli_query($conn, "SELECT * FROM USERS WHERE logged != '0'");
        $usersrows = mysqli_num_rows($usersquery);
        for(;$usersrows > 0; $usersrows--){
            $array = mysqli_fetch_array($usersquery);
            $name = "'".$array['name']."'";
            print "addUser($name);";
        }
        $myHash = $_SESSION['hash'];
        $myquery = mysqli_query($conn, "SELECT * FROM users WHERE logged = '$myHash'");
        $myRows = mysqli_num_rows($myquery);
        if($myRows != 1){
            unset($_SESSION['name']);
            unset($_SESSION['hash']);
            header("location: .");
        }else{
            $myarray = mysqli_fetch_array($myquery);
            $myname = $myarray['name'];
            print "setme('$myname');";
        }
        ?>
            load();
        }
        </script>
    <body onload="addusers()">
        <div>
            <div class="header">
                <div class="messageDiv">

                </div>
                <div class="formContainer">
                    <input type="text" id="messageText">
                        <button onclick="sendMessage()" id="sendButton">Send</button>
                    <form method="post" action="#" id="logoutForm">
                        <input type="submit" name="logout" value="Logout" id="lgogut">
                    </form>
                </div>
            </div>
    <?php

    }else{
        unset($_SESSION['name']);
        unset($_SESSION['hash']);
        header("location: .");
    }
}
        ?>
        </div>
    </body>
</html>
