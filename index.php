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
        <script src="ui-custom/jquery-ui.js"></script>
          <link rel="stylesheet" href="ui-custom/jquery-ui.css">
        <link href="styles/main.css" rel="stylesheet" type="text/css">
    </head>

<?php
if(!isset($_SESSION['name'])){
    include 'login.php';
    include 'register.php';
}else{
    include 'board.php';
}
?>
</div>
</body>
</html>
