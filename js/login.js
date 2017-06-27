$(document).ready(function(){
    
    //On Click Login button
    $("#loginButton").on("click", function(){
        var jsonToSend = {
            "username" : $("#username").val(),
            "password" : $("#password").val(),
            "remember" : $("#remember").is(":checked"),
            "action" : "login"
        };
        
        $.ajax({
            url : "data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonReceived){
                alert("Bienvenido, " + jsonReceived.Nombre + "!");
                if(jsonReceived.Valor_Acceso == 1)
                    $(location).attr("href", "map/restaurant/home.html");
                else if (jsonReceived.Valor_Acceso == 2)
                    $(location).attr("href", "map/warehouse/home.html");
                else if(jsonReceived.Valor_Acceso == 3)
                    $(location).attr("href", "map/kitchen/home.html");
                    
            },
            error: function(errorMessage){
                alert(errorMessage.responseText);
            }
        });
    });
});