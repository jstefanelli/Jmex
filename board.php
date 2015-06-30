<?php
    if(!isset($_POST['logout'])){
?>
<script>
function addusers(){
<?php
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
    <div id="dialog" title="Create or Join Conversation...">
        <form>
            <input type="text" id="convName" name="convName" class="text ui-widget.content" style="width: 500px;">
        </form>
    </div>
    <div class="content">
        <div class="roomSelector">

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
    <div class="users">

    </div>
<?php

    }else{
        unset($_SESSION['name']);
        unset($_SESSION['hash']);
        header("location: .");
    }

?>
