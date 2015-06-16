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
}
</script>
<body onload="addusers()">
<div>
    <div class="header">
        <div class="title">
            <h3>JMex </h3><h4> BETA</h4>
        </div>
        <div class="logout">
            <form method="post" action="#" id="logoutForm">
                <input type="submit" name="logout" value="Logout" class="logoutBtn">
            </form>
        </div>
    </div>
    <div class="content">
        <div class="roomSelector">
            <div class="currentRoom">
                <h5>#global</h5>
            </div>
        </div>
        <div class="messageContainer">
        <div class="messageDiv">

        </div>
        <div class="formContainer">
            <input type="text" id="messageText">
            <button onclick="sendMessage()" class="sendButton">Send</button>
            <br>


        </div>
    </div>
    </div>
<?php

    }else{
        unset($_SESSION['name']);
        unset($_SESSION['hash']);
        header("location: .");
    }

?>
