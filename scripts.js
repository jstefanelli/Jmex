var userlist =new Array();
var myname;
var lastMessages = new Array();
var conversations = new Array();
var currentConversation = "general";
var currentCoversationId = 1;

function addUser(user){
    userlist.push(user);
}

function setme(myName){
    myname = myName;
}

function load(){
    $(document).ready(function(){
        $('#messageText').keypress(function(e){
            if(e.keyCode==13)
                $('.sendButton').click();
        });
    });
    window.setInterval(getMessages, 100);
    conversations.push({"id" : 1, "name" : "general", "filename" : "demo_post.json"});
    //getConversations();
    getConversations();
}

function getConversations(){
    $(document).ready(function(){
        $(".roomSelector").empty();
        $.post("getConversations.php", {'user' : myname}, function(result){}).success(function(result){
            try{
                var resText = result.responseText;
                console.log(resText);
                var res = JSON.parse(resText);
            }catch(e){
                console.log(e.message + " / " + e.name);
            }
            conversations = new Array();
            conversations.push({"id" : 1, "name" : "general", "filename" : "demo_post.json"});
            for(var i = 0; i < res.length; i++){
                conversations.push(res[i]);
            }
            for(var i = 0; i < conversations.length; i++){
                $(".roomSelector").append('<div class="otherRoom" id="room' + conversations[i]['id'].toString() +'"><h8>#' + conversations[i]['name'] +'</h8></div>');
            }

        });
    });

}

function getUsers(){
    var repo = $.getJSON("getUsers.php", function(result){}).success(function(result){
        console.log(result.response);
        userlist = JSON.parse(result.responseText);
        for(var user in userlist){
            $('#cbx').epmty();
            $('#cbx').append('<option value="user">' + user + "</option>")
        }
    }).error(function(result){
     console.log(result);
    });

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
            for (var i = 1; i < messages.length; i++){
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
            if(lastuser != "")
                $(".messageDiv").prepend("<h1><b>" + lastuser +": </b></h1>");
        //$(".messageDiv").prepend("Updated at: " + d.toLocaleTimeString());
        }
    });

}

function sendMessage(){
    $(document).ready(function(){
        var mystring = document.getElementById("messageText").value;
        //alert(mystring);
        if(mystring != ""){
            var myStringObject = {"action" : "postmessage", "text": mystring , "user": myname, "conv":"general"};
            var mystringjson = JSON.stringify(myStringObject);
            //alert(mystringjson);
            var retval = $.post("postmessage.php",
                    myStringObject,
                    function(data, status){
                        //alert("Data: " + data + "\nStatus: " + status);
                        getMessages();
                        }).fail(function(data, status){alert("error: " + status+ "\nData: " + data);});
        }
    });

}

