<!DOCTYPE html>
<?php
include 'header.php';
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>JMex beta</title>
        <script type="text/javascript" src="scripts.js"></script>
    </head>
    <body>
        <div>
        <?php
if(!isset($_SESSION['name'])){
    if(!isset($_POST['login'])){?>
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
                session_start();
                $_SESSION['name'] = $username;
                $query2 = mysqli_query($conn, "UPDATE users SET logged = 1 WHERE name = '$username'");
                if($query2){
                    echo "Succesfully logged.";
                }
            }else{
                die("Wrong password");
            }
        }
    }
}else{

}
        ?>
        </div>
    </body>
</html>
