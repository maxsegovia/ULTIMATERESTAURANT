$(document).ready(function(){
    
    var jsonToSend = {
        "action" : "cookies"
    };
    
    $.ajax({
        url : "../../data/applicationLayer.php",
        type : "POST",
        dataType : "json",
        data: jsonToSend,
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonReceived){
            $("#username").val(jsonReceived.username);
        },
        error: function(errorMessage){
        }
    });
});