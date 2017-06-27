$(document).ready(function ()
{
    var jsonToSend = 
    {
        "action" : "products"
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
            var productsArray = new Array();
            for(var i = 0; i < jsonReceived.length; i++)
            {
                productsArray.push(jsonReceived[i].Nombre);
            }
            
            $(".search-field").autocomplete({
                source: productsArray
            });
            
        },
        error : function(errorMessage)
        {
            alert(errorMessage.responseText);
        }
    });
});