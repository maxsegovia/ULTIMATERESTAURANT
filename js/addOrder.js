$(document).ready(function(){
    
    //On Click Login button
    $("#orderButton").on("click", function(){
        var jsonToSend = {
            "plate" : $("#plate").val(),
            "action" : "addOrder"
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
                    tableList += "<p>Orden añadida</p>";
                tableList += "</div>";
                
                $("#message").append(tableList);
                
                tableList = "";
                tableList += "<div class='product-object'>";
                    tableList += "<h3> Platillo: " + jsonReceived[0].plate + "</h3>";
                    tableList += "<p>Mesa: " + jsonReceived[0].orderTableId + "</p>";
                tableList += "</div>";
                
                $("#tableOrders").append(tableList);
                    
            },
            error: function(errorMessage){
                var tableList = "";
                tableList += "<div class='alert alert-danger alert-dismissible'>";
                    tableList += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    tableList += "<p>"+ errorMessage.responseText + "</p>";
                tableList += "</div>";
                
                $("#message").append(tableList);
            }
        });
    });
});