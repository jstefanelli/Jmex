var userlist =new Array();
var myname;

function addUser(user){
    userlist.push(user);
}

function setme(myName){
    myname = myName;
}

function getMessages(){
    var myi = 0;
    $(".messageDiv").clear;
    $.getJSON("demo_post.json", function(result){
        console.log(result);
        $.each(result, function(i, field){
            $.each(field, function(i, obj){
                $(".messageDiv").prepend(obj + "<br>");
            });
            $(".messageDiv").prepend("Message: " + myi + "<br>");
            myi++;
        });
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
                        }).fail(function(data, status){alert("error: " + status+ "\nData: " + data);}
            );
        }
    });
}
