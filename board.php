<?php
    if(!isset($_POST['logout'])){
?>
<script>
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
    setupConversation();
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

?>
