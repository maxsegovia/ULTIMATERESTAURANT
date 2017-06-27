$(document).ready(function ()
{
    
    $("#tablesTaken").on("click", ".orderButton", function() 
    {
        
        var jsonToSend = {
            "tableId" : $(this).attr("value"),
            "action" : "createCookieTableId"
        };
        
        $.ajax({
            url: "../../data/applicationLayer.php",
            dataType: "json",
            type: "POST",
            data: jsonToSend,
            contentType : "application/x-www-form-urlencoded",
            succes : function(){
                
            },
            error: function()
            {
                
            }
        });
        
        $(location).attr("href", "order.html");
    });
});
