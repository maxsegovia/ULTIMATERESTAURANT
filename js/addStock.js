$(document).ready(function(){
    
    //On Click Login button
    $("#sendRequest").on("click", function(){
        var jsonToSend = {
            "productName" : $("#productName").val(),
            "quantity" : $("#quantity").val(),
            "action" : "addStock"
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
                    tableList += "<p>Stock añadido.</p>";
                tableList += "</div>";
                
                $("#message").html(tableList);
            },
            error: function(errorMessage){
                var tableList = "";
                tableList += "<div class='alert alert-danger alert-dismissible'>";
                    tableList += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    tableList += "<p>"+ errorMessage.responseText + "</p>";
                tableList += "</div>";
                
                $("#message").html(tableList);
            }
        });
    });
});