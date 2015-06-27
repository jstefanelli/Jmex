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
    if(isset($_POST["action"])){
        $action = $_POST["action"];
        if($action == "postmessage"){
            $conv = $_POST['conv'];
            $query = mysqli_query($conn, "SELECT * FROM conversations WHERE name  = '$conv'");
            $numrows = mysqli_num_rows($query);
            if($numrows == 1){
                $row = mysqli_fetch_array($query);
                $filename = $row['filename'];
                $jaction = $_POST['text'];
                if($jaction != 'elpsycongroo'){
                    $atext = $_POST;
                    $atext['text'] = htmlspecialchars($atext['text'], ENT_QUOTES);
                    $handle = fopen($filename, 'r+');
                    $size = filesize($filename);
                    $text = fread($handle, $size);
                    $textDecoded = json_decode($text, true);
                    $message['text'] = $atext['text'];
                    $message['user'] = $atext['user'];
                    $textDecoded['messages'][] = $message;
                    $textEncoded = json_encode($textDecoded);
                    ftruncate($handle, 0);
                    fseek($handle, 0);
                    fwrite($handle, $textEncoded);
                    fclose($handle);
                    die("No errors");
                }else{
                    $handle = fopen($filename, "r+");
                    $filesize = filesize($filename);
                    $fileText = fread($handle, $filesize);
                    $fileDecode = json_decode($fileText, true);
                    unset($filedecode['messages']);
                    $filedecode['messages'] = array();
                    $fileEncoded = json_encode($filedecode);
                    ftruncate($handle, 0);
                    fseek($handle, 0);
                    fwrite($handle, $fileEncoded);
                    fclose($handle);
                }
            }else{
                die("Conversation not found.");
            }
        }
}
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
