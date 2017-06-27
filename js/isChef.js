$(document).ready(function () {
    
    var jsonToSend = {
            "action" : "sessionKitchen"
    };
     //Verificar si la sesion esta iniciada
    $.ajax({
        url: "../../data/applicationLayer.php",
        dataType: "json",
        data: jsonToSend,
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        success: function(jsonReceived){
            
        },
        error: function(errorMessage)
        {
            alert(errorMessage.responseText);
            parent.history.back();
        }
    });
});
