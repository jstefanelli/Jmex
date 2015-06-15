var userlist =new Array();
var myname;
var lastMessages = new Array();

function addUser(user){
    userlist.push(user);
}

function setme(myName){
    myname = myName;
}

function load(){
    window.setInterval(getMessages, 2000);
}


function getMessages(){
    $.ajaxSetup({ cache: false });
    var myi = 0;
    var d = new Date();
    var jqxhr = $.getJSON("demo_post.json", function(result){

    }).complete(function(result){
        //console.log(result.responseText);
        var myi = JSON.parse(result.responseText);
        var messages = myi.messages;
        var lastuser = "";
        if(lastMessages.length != messages.length){
            $(".messageDiv").empty();
            console.log("updating");
            lastMessages = messages;
            var changed = false;
            for (var i = 0; i < messages.length; i++){
                var obj = messages[i];

                //console.log(property + ": " + obj[property]);
                if(lastuser == "" && lastuser != obj['user']){
                   lastuser = obj['user'];
                }
                if(lastuser != "" && lastuser != obj['user']){
                    changed = true;
                    $(".messageDiv").prepend("<h1><b>" + lastuser +": </b></h1>");
                    lastuser = obj['user'];
                    changed = false;
                }
                $(".messageDiv").prepend("<h2>" + obj['text'] + "</h2>");
            }
        $(".messageDiv").prepend("<h1><b>" + lastuser +": </b></h1>");
        $(".messageDiv").prepend("Updated at: " + d.toLocaleTimeString());
        }
    });

}

function sendMessage(){
    $(document).ready(function(){
        var mystring = document.getElementById("messageText").value;
        //alert(mystring);
        if(mystring !== undefined){
            var myStringObject = {"action" : "adduser", "text": mystring , "user": myname};
            var mystringjson = JSON.stringify(myStringObject);
            //alert(mystringjson);
            var retval = $.post("add_message.php",
                    myStringObject,
                    function(data, status){
                        //alert("Data: " + data + "\nStatus: " + status);
                        getMessages();
                        }).fail(function(data, status){alert("error: " + status+ "\nData: " + data);}
            );
        }
    });

}
