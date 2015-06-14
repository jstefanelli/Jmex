<?php
if(is_ajax()){
    if(isset($_POST["action"])){
        $action = $_POST["action"];
        if($action == "adduser"){
            $text = $_POST;
            $textJSON = json_encode($text);
            $handle = fopen("demo_post.json", 'c');
            $size = filesize("demo_post.json");
            fseek($handle, $size -2);
            fwrite($handle, ",\n\"message\": ".$textJSON."\n}");
            fclose($handle);
        }
    }
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
