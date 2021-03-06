$(document).ready(function(){
    
    //On Click Login button
    $("#pendingOrders").on("click", "#orderButton", function(){
        var jsonToSend = {
            "idOrden" : $(this).attr("name"),
            "action" : "deleteOrder"
        };
        
        $.ajax({
            url : "../../data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonReceived){
                var tableList = "";
                
                tableList += "<div class='alert alert-success alert-dismissible'>";
                    tableList += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    tableList += "<p>Orden completada.</p>";
                tableList += "</div>"; 
                
                $("#message").append(tableList);
                
            },
            error: function(errorMessage){
                var tableList = "";
                
                tableList += "<div class='alert alert-danger alert-dismissible'>";
                    tableList += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    tableList += "<p>" + errorMessage.responseText + "</p>";
                tableList += "</div>";

                $("#message").append(tableList);
            }
        });
        
        $(this).parent().remove();
    });
});