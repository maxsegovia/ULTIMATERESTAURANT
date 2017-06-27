$(document).ready(function(){
    
    var jsonToSend = {
        "action" : "tableOrders"
    };
        
    $.ajax({
        url : "../../data/applicationLayer.php",
        type : "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonReceived){
            var tableList = "";

            for(var i = 0; i < jsonReceived.length; i++)
            {
                tableList += "<div class='product-object'>";
                    tableList += "<h3> Platillo: " + jsonReceived[i].Nombre + "</h3>";
                    tableList += "<p>Orden: " + jsonReceived[i].orderId + "</p>";
                    tableList += "<img class='imgPlate' src='" + jsonReceived[i].imgSrc + "'/>";
                tableList += "</div>";
            }

            $("#tableOrders").append(tableList);

        },
        error: function(errorMessage){
            var tableList = "";
                tableList += "<h3>No hay órdenes.</h3>";

            $("#tableOrders").append(tableList);
        }
    });
});