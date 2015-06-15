<?php
if(!isset($_POST['register'])){?>
    <form method="post" action="#">
        <label for="regusername">Username: </label>
        <input type="text" name="regusername" id="regusername"><br />
        <label for="regpassword">Password: </label>
        <input type="password" name="regpassword" id="regpassword"><br />
        <label for="repassword">Repeat password: </label>
        <input type="password" name="repassword" id="repassword"> <br />
        <input type="submit" name="register" id="register" value="Register">
    </form>
<?php
}else{
$username = $_POST['regusername'];
$psw1 = $_POST['regpassword'];
$psw2 = $_POST['repassword'];
if($psw1 != $psw2){
echo "password non uguali.";
}else{
mb_convert_encoding($psw1, 'UTF-16LE', 'UTF-8');
$password = base64_encode(md5($psw1, true));
$registerquery = mysqli_query($conn, "INSERT INTO users (name, psw) VALUES ( '$username', '$password')");
if($registerquery){
    echo "Succesfully registered".
    header("location: .");
}else{
    die (mysqli_error($conn));
}
}
}
?>
