<?php
    if(!isset($_POST['login'])){
?>
    <body >
            <div>
                <form method="post" action="#" id="loginForm">
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username"><br />
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password"><br />
                    <input type="submit" name="login" id="login" value="Login">
            </form>
            <br>


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
}else{
    die("Wrong username");
}
}
?>
