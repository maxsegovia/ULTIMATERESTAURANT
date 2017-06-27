$(document).ready(function ()
{
    var jsonTosend = 
    {
        "action" : "checkTableId"
    };
    
    $.ajax(
    {
        url: "../../data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        data: jsonTosend,
        success : function(jsonReceived)
        {
            $("#tableId").append("Mesa " + jsonReceived.tableId);
        },
        error: function(errorMessage)
        {
            alert("No hay mesa!");
        }
    });
});