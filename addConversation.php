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
if ($action == "addconv"){
    $user_name = $_POST['user'];
    $conv_name = $_POST['convname'];
    $conv_file_name = $conv_name.'.json';
    if(file_exists($conv_file_name)){
        $conv_file = fopen($conv_file_name, 'c+');
        $conv_file_size = filesize($conv_file_name);
        $file_text = fread($conv_file, $conv_file_size);
        $conv = json_decode($file_text);
        $conv['users'] = $user_name;
        fseek($conv_file, 0);
        ftruncate($conv_file, 0);
        $conv_text = json_encode($conv);
        fwrite($conv_file, $conv_text);
        fclose($conv_file);
    }else{
        $conv_file = fopen($conv_file_name, 'c+');
        $conv = array(
            'users' => array(
                $user_name
            ),
            'messages' => array(
                array(
                    'text' => 'Conversazione creata.',
                    'user' => $user_name
                )
            )
        );
        $conv_json = json_encode($conv);
        fwrite($conv_file, $cov_json);
        fclose($conv_file);
        $query = mysqli_query($conn, "INSERT INTO conversations (name, filename) VALUES ( '$conv_name', '$conv_file_name')");
        exit($query);
    }
}
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


?>
