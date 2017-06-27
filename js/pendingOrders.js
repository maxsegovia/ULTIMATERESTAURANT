$(document).ready(function(){
    
    var jsonToSend = {
            "action" : "pendingOrders"
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
                tableList += "<div class='product-object' id='" + jsonReceived[i].idOrden + "'>";
                    tableList += "<h3> Platillo: " + jsonReceived[i].Nombre + "</h3>";
                    tableList += "<p> No. Orden: " + jsonReceived[i].idOrden +"</p>";
                    tableList += "<p> No. Mesa: " + jsonReceived[i].No_Mesa +"</p>";
                    tableList += "<img class='imgPlate' src='" + jsonReceived[i].imgSrc + "'/>";
                    tableList += "<input class='button' id='orderButton' type='button' name='" + jsonReceived[i].idOrden + "' value='Lista'>";
                tableList += "</div>";
            }
            $("#pendingOrders").append(tableList);    
        },
        error: function(errorMessage){
            var tableList = "";
            tableList += "<h3>No hay órdenes</h3>"
            
            $("#pendingOrders").append(tableList); 
        }
    });
});