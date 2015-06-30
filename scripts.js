var userlist =new Array();
var myname;
var lastMessages = new Array();
var conversations = new Array();
var currentConversation = "demo_post";
var currentCoversationId = 1;
var lastConversation = "demo_post";
var lastDivId = "room1";
var forceupdate = false;
var dialog, form, convBox;


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
        $("#dialog").hide();
    });
    window.setInterval(getMessages, 200);
    conversations.push({"id" : 1, "name" : "general", "filename" : "demo_post.json"});
    getConversations();

}

function getConversations(){
    $(document).ready(function(){
        /*$(".roomSelector").empty();*/
        $.post("getConversations.php", {'user' : myname}, function(result){}).success(function(result){
            console.log(result);
            if(result != undefined){
                var res = JSON.parse(result);
            }else{
                res = new Array();
            }
            conversations = new Array();
            conversations.push({"id" : 1, "name" : "general", "filename" : "demo_post.json"});
            for(var i = 0; i < res.length; i++){
                conversations.push(res[i]);
            }
           /* $(".otherRoom").each(function(key, value) {
                console.log(key);
            });*/
            $(".otherRoom").remove();
            $(".currentRoom").remove();
            $(".addRoom").remove();

            for(var i = 0; i < conversations.length; i++){
                $(".roomSelector").append('<a href="javascript:none" class="otherRoom" onclick="selectConversation(\'' + conversations[i]['name'] +'\', \'room' + conversations[i]['id'].toString() +'\')"  id="room' + conversations[i]['id'].toString() +'">#' + conversations[i]['name'] +'</a>');

            }
            $(".roomSelector").append('<a href="javascript:none" class="addRoom" onclick="addConversation()"><span>+</span></a>');
            //console.log("Added +");
        });
    });

}

function selectConversation(convName, divid){
    if(convName == "general"){
        currentConversation = "demo_post";
    }else{
        currentConversation = convName;
    }
    if(lastDivId != divid){
        $("#" + divid).attr('class', 'currentRoom');
        $("#" + lastDivId).attr('class', 'otherRoom');
        lastDivId = divid;
    }
    forceupdate = true;
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
    var jqxhr = $.getJSON(currentConversation + ".json", function(result){

    }).complete(function(result){
        //console.log(result.responseText);
        var myi = JSON.parse(result.responseText);
        var messages = myi.messages;
        var lastuser = "";
        if(lastMessages.length != messages.length || currentConversation != lastConversation || forceupdate){
      		forceupdate = false;
            lastConversation = currentConversation;
            $(".messageDiv").empty();
            console.log("updating");
            lastMessages = messages;
            var changed = false;
            var i = 0;
            for (; i < messages.length; i++){
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
        var users = myi.users;
        $(".users").empty();
        $(".users").append("<h6>Users in conversation: </h6>");
        for(var i = 0; i < users.length; i++){
            $(".users").append("<h2>"+ users[i] +"</h2><br>");
        }
    });

}

function sendMessage(){
    $(document).ready(function(){
        var mystring = document.getElementById("messageText").value;
        //alert(mystring);
        if(mystring != ""){
            if(currentConversation == "demo_post"){
                var myConv = "general";
            }else{
                var myConv = currentConversation;
            }
            var myStringObject = {"action" : "postmessage", "text": mystring , "user": myname, "conv": myConv};
            var mystringjson = JSON.stringify(myStringObject);
            //alert(mystringjson);
            var retval = $.post("postmessage.php",
                    myStringObject,
                    function(data){
                        //alert("Data: " + data + "\nStatus: " + status);
                        console.log(data);
                        getMessages();
                        }).fail(function(data, status){alert("error: " + status+ "\nData: " + data);});
        }
    });

}

function getRandomColor() {
	var letters = '0123456789ABCDEF'.split('');
	var color = '#';
    for (var i = 0; i < 6; i++ ) {
    	color += letters[Math.floor(Math.random() * 16)];
    }
return color; }
var ti=setInterval(function(){
	document.getElementsByClassName("header")[0].style.backgroundColor=getRandomColor();
    }, 1000);

function addConversation(){

    dialog = $('#dialog').dialog({
        autoOpen: false,
        width: 550,
        height: 173,
        modal: true,
         buttons: {
        "Create conversation": function(){
            convBox = $("#convName");
            $.post("addConversation.php", {'user' : myname, 'convname' : convBox.val()}, function(result){}).success(function(result){
        console.log(result);
        getConversations();
        dialog.dialog("close");
    });
        },
        Cancel: function() {
            dialog.dialog("close");
        }
      },
      close: function() {
      }
    });
    $('#dialog').dialog("open");

}
