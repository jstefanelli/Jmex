var userlist =new Array();
var myname;

function addUser(user){
    userlist.push(user);
}

function setme(myName){
    myname = myName;
}

function sendMessage(){
    $(document).ready(function(){
        var txt1 = "test<br>";
        $(".messageDiv").prepend(txt1);
        var mystring = document.getElementById("messageText").value;
        alert(mystring);
        var mystringJson = JSON.stringify(mystring);
        alert(mystringJson);
        if(mystringJson !== undefined){
            var myStringObject = {text: mystringJson};
            $.post("demo_post.json",
                myStringObject,
                function(data, status){
                    alert("Data: " + data + "\nStatus: " + status);
                    }).fail(function(data, status){alert("error: " + status+ "\nData: " + data);}
            );
        }
    });
}
