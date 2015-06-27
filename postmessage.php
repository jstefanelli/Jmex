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
                    $text = $_POST;
                    $text['text'] = htmlspecialchars($text['text'], ENT_QUOTES);
                    $textJSON = json_encode($text);
                        $handle = fopen("demo_post.json", 'c');
                    $size = filesize("demo_post.json");
                    fseek($handle, $size -5);
                    fwrite($handle, ",\n\t\t".$textJSON."\n\t]\n}");
                    fclose($handle);
                }else{
                    $handle = fopen("demo_post.json", "r+");
                    ftruncate($handle, 0);
                    fseek($handle, 0);
                    $string = '{
    "messages": [
        {"action":"postmessage","text":"primo post","user":"Server"}
    ]
}';

                    fwrite($handle, $string);
                    fclose($handle);
                }
            }else{
                die("Conversation not found.");
            }
        }
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
