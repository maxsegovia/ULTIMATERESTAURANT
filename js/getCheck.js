$(document).ready(function(){
    
    //On Click Login button
    $("#modal-button").on("click", function(){
        var jsonToSend = {
            "idTable" : $("#idTable").val(),
            "payment" : $("#payment").val(),
            "action" : "getCheck"
        };
        
        $.ajax({
            url : "../../data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonReceived){
                var tableList = "";
                
                tableList += "<div class='product-object'>";
                    tableList += "<h2>ULTIMATE RESTAURANT</h2>";
                    tableList += "<p>" + jsonReceived[0].fecha + "</p>";
                    tableList += "<p> Total: " + jsonReceived[0].monto + "</p>";
                    tableList += "<p> Métodod de pago: " + jsonReceived[0].formaPago + "</p>";
                    tableList += "<p>Lista de platillos: </p>";
                    for(var j = 0; j < jsonReceived.articles.nombre.length; j++)
                    {
                        tableList += "<p>" + jsonReceived.articles.nombre[j] + " Precio: " + jsonReceived.articles.precio[j] + "</p>"
                    }
                    tableList += "<input class='button payButton' name='" + jsonReceived[0].idCuenta + "' type='submit' value='Pagar'>";
                tableList += "</div>";
                
                
                $("#getCheck").html(tableList);
                    
            },
            error: function(errorMessage){
                var tableList = "";
                
                tableList += "<h3>No hay órdenes.</h3>";
                
                $("#getCheck").html(tableList);
                
                alert(errorMessage.responseText);
            }
        });
    });
});