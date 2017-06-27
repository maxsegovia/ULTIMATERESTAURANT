$(document).ready(function(){
    var jsonToSend = {
            "action" : "clearSession"
    };
    
   $("#logoutButton").on("click", function() {
       $.ajax({
            url: "../../data/applicationLayer.php",
            dataType: "json",
            type: "POST",
            data : jsonToSend,
            contentType : "application/x-www-form-urlencoded",
            success: function(sessionMessage){
                alert(sessionMessage.Message);
                $(location).attr("href", "../../index.html");
            },
            error: function(errorMessage){
                $(location).attr("href", "../../index.html"); 
            }
        });
   });
});