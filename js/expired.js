$(document).ready(function(){
    
    var jsonToSend = {
            "action" : "expired"
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
                    tableList += "<p>Fecha de Ingreso: " + jsonReceived[i].fechaIngreso +"</p>";
                    tableList += "<p>Fecha de Expiración: " + jsonReceived[i].fechaExpiracion +"</p>";
                tableList += "</div>";
            }
            $("#expiringSoon").append(tableList);    
        },
        error: function(errorMessage){
            var tableList = "";
            
            tableList += "<h3>Todo está en orden.</h3>"
            
            $("#expiringSoon").append(tableList); 
        }
    });
});