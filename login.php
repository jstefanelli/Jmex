<?php
    if(!isset($_POST['login'])){
?>
    <body >
        <div class="header">
            <div class="title">
                <h3>JMex </h3><h4> BETA</h4>
            </div>
        </div>
        <div class="loginDiv">
            <h6>Accedi</h6>
            <form method="post" action="#" id="loginForm">
                <p>
                    <label for="loginusername"><h7>Username: </h7></label>
                    <input type="text" id="loginusername" name="username">
                </p>
                <p>
                    <label for="loginpassword"><h7>Password: </h7></label>
                    <input type="password" id="loginpassword" name="password">
                </p>
                <input type="submit" name="login" id="login" value="Login">
            </form>
        </div>



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
