$(document).ready(function ()
{
    var jsonToSend = 
    {
        "action" : "productssAvailable"
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
            var tableList = "";
            
            for(var i = 0; i < jsonReceived.length; i++)
            {
                tableList += "<div class='product-object'>";
                    tableList += "<h3>Producto: " + jsonReceived[i].Nombre + "</h3>";
                    tableList += "<p>Cantidad: " + jsonReceived[i].Cantidad +"</p>";
                tableList += "</div>";
            }
            
            $("#productsAvailable").append(tableList);
        },
        error : function(errorMessage)
        {
            alert(errorMessage.responseText);
        }
    });
});