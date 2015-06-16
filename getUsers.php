<?php
	$servername = "localhost";
	$username = "root";
	$password  = "";

	$conn = mysqli_connect($servername, $username, $password);

	if(!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}
    $db = mysqli_select_db($conn, "my_jmex");
    if(!$db){
        die("database not found");
    }
    mb_internal_encoding('UTF-8');

if(is_ajax()){
    $res = array();
    $myquery = mysqli_query($conn, 'SELECT * FROM users WHERE logged != "0"');
    while($row = mysqli_fetch_array($myquery)){
        $res = $row['name'];
    }
    $string = json_encode($res);
    print $string;
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
?>
