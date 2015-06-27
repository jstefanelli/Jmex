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
    try{
        $username = $_POST['user'];
        $conv_list = array();
        $query = mysqli_query($conn, "SELECT * FROM conversations");
        while($arr = mysqli_fetch_array($query)){
            $convname = $arr['name'];
            $convfile = $arr['filename'];
            $file = fopen($convfile, 'r');
            $filesize = filesize($convfile);
            $text = fread($file, $filesize);
            fclose($file);
            $conv = json_decode($text);
            $size = sizeof($conv['users']);
            for($i = 0; $i < $size; $i++){
                if($conv['users'][$i] == $username){
                    $conv_list[] = $arr;
                }
            }
        }
        $conv_list_json = json_encode($conv_list);
        print($conv_list_json);
    }catch(Exception $e){
        print( $e->getMessage());
    }
}else{
    echo 'Not ajax';
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
