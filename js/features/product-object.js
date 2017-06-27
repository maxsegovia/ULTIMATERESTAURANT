$(document).ready(function () {
    
    $(".container-2").on("mouseenter",".product-object",function(){
    $(this).animate({
            width: "+=10px",
            height: "+=10px",
            marginLeft: "-=5px",
            padding: "+=5px",
            position: "absolute"
        }, 100);
    });
    
    
    $(".container-2").on("mouseleave",".product-object",function(){
        $(this).animate({
            width: "-=10px",
            height: "-=10px",
            marginLeft: "+=5px",
            padding: "-=5px",
            position: "none"
        }, 100, function(){
            $(this).css('width', '200px');
        });
    });
});
