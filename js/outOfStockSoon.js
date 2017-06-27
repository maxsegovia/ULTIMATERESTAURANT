$(document).ready(function(){
    
    var jsonToSend = {
            "action" : "outOfStockSoon"
    };
    
    $.ajax({
        url : "../../data/applicationLayer.php",
        type : "POST",
        dataType : "json",
        data : jsonToSend,
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonReceived){
            var tableList = "";

            for(var i = 0; i < jsonReceived.length; i++)
            {
                tableList += "<div class='product-object'>";
                    tableList += "<h3>" + jsonReceived[i].nombre + "</h3>";
                    tableList += "<p>En Stock: " + jsonReceived[i].cantidad +"</p>";
                    tableList += "<input class='button' id='orderButton' type='button' value='Ordenar más'>";
                tableList += "</div>";
            }
            $("#outOfStockSoon").append(tableList);    
        },
        error: function(errorMessage){
            var tableList = "";
            
            tableList += "<h3>Todo está en orden.</h3>"
            
            $("#outOfStockSoon").append(tableList); 
        }
    });
});