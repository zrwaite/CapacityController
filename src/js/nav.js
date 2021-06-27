$(document).ready(function(){
    $("#"+page).css("text-decoration", "underline");
    $(".icon").on({
        click: function(){
            var navBar = $("#mainNav").attr("class");
            if (navBar==="nav"){
                $("#mainNav").attr("class", "nav responsive");
                $(".navItem").css("border-bottom", "3px solid white");
            }
            else {
                $("#mainNav").attr("class", "nav");
                $(".navItem").css("border-bottom", "none");
            }
        },
    });
});