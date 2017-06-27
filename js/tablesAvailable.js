$(document).ready(function(){
    
    var jsonToSend = {
            "action" : "tablesAvailable"
    };
    
    $.ajax({
        url : "../../data/applicationLayer.php",
        type : "POST",
        dataType : "json",
        data : jsonToSend,
        contentType: "application/x-www-form-urlencoded",
        success : function(jsonReceived){
            var tableList = "";

            for(var i = 0; i < jsonReceived.length; i++)
            {
                tableList += "<div class='product-object'>";
                    tableList += "<h3>Mesa: " + jsonReceived[i].No_Mesa + "</h3>";
                tableList += "</div>";
                
            }

            $("#tablesAvailable").append(tableList);
        },
        error: function(errorMessage){
            var tableList = "";
            
            tableList += "<h3>No hay mesas.</h3>";
            
            $("#tablesAvailable").append(tableList); 
        }
    });
});