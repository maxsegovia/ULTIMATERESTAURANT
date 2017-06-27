$(document).ready(function ()
{
    
    $("#getCheck").on("click", ".payButton", function() 
    {
        
        var jsonToSend = {
            "action" : "payCheck"
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