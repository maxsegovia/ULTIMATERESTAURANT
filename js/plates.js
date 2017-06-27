$(document).ready(function ()
{
    var jsonToSend = 
    {
        "action" : "plates"
    };
    
    $.ajax(
    {
        url : "../../data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        contentType : "application/x-www-form-urlencoded",
        data: jsonToSend,
        success : function(jsonReceived)
        {
            var foodArray = new Array();
            for(var i = 0; i < jsonReceived.length; i++)
            {
                foodArray.push(jsonReceived[i].Nombre);
            }
            
            $(".search-field").autocomplete({
                source: foodArray
            });
            
        },
        error : function(errorMessage)
        {
            alert(errorMessage.responseText);
        }
    });
});
