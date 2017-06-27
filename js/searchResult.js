$(document).ready(function ()
{
    $("#search").on("click", function() {
    
        var jsonToSend = 
        {
            "searchValue" : $("#searchValue").val(),
            "action" : "searchResults"
        };

        $.ajax({
            url : "../../data/applicationLayer.php",
            type: "POST",
            dataType : "json",
            contentType: "application/x-www-form-urlencoded",
            data: jsonToSend,
            success: function(jsonReceived){
                var tableList = "";
                
                tableList += "<h2>Resultado de Búsqueda: </h2>";
                for(var i = 0; i < jsonReceived.length; i++)
                {
                    tableList += "<div class='product-object'>";
                        tableList += "<h3>Producto: <strong>" + jsonReceived[i].Nombre + "</strong></h3>";
                        tableList += "<p>Unidades disponibles: " + jsonReceived[i].Cantidad + "</p>";
                        tableList += "<input class='button' id='addStock' type='button' data-toggle='modal' data-target='.bd-example-modal-lg-new-product' value='Añadir'>";
                    tableList += "</div>";
                }

                $("#searchResults").html(tableList);
                $("#searchResults").removeClass("hidden");
            },
            error: function(errorMessage){
                alert(errorMessage.responseText);
            }
        });
    });
});