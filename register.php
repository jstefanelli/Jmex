<?php
if(!isset($_POST['register'])){?>
    <div class="registerDiv">
        <h6>Registrati</h6>
    <form method="post" action="#">
        <p>
            <label for="regusername"><h7>Username:</h7> </label>
            <input type="text" name="regusername" id="registerusername"><br />
        </p>
        <p>
            <label for="regpassword"><h7>Password:</h7> </label>
            <input type="password" name="regpassword" id="registerpassword"><br />
        </p>
        <p>
            <label for="repassword"><h7>Ripeti password: </h7></label>
            <input type="password" name="repassword" id="registerpassword"> <br />
        </p>
        <input type="submit" name="register" id="register" value="Register">
    </form>
    </div>
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
