<?php
if(is_ajax()){
    if(isset($_POST["action"])){
        $action = $_POST["action"];
        if($action == "adduser"){
            $jaction = $_POST['text'];
            if($jaction != 'order66'){
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
        {"action":"adduser","text":"primo post","user":"Server"}
    ]
}';
                fwrite($handle, $string);
                fclose($handle);
            }
        }
    }
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
