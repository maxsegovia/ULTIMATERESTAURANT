$(document).ready(function(){
    
    var jsonToSend = {
            "action" : "tablesTaken"
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
                    tableList += "<h3>Mesa: " + jsonReceived[i].No_Mesa + "</h3>";
                    tableList += "<p>Nombre: <strong>" + jsonReceived[i].Nombre + "</strong></p>";
                    tableList += "<p>No. Gente: "+ jsonReceived[i].Cantidad_Gente + "</p>";
                    tableList += "<p>Empleado ID: " + jsonReceived[i].id_empleado + "</p>";
                    tableList += "<input class='orderButton button' type='submit' value='" + jsonReceived[i].No_Mesa + "'>";
                tableList += "</div>";
            }

            $("#tablesTaken").append(tableList);    
        },
        error: function(errorMessage){
            var tableList = "";
            
            tableList += "<h3>No hay mesas.</h3>";
            
            $("#tablesTaken").append(tableList); 
        }
    });
});