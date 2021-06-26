$(document).ready(function(){
    $("#"+page).css("text-decoration", "underline");
    $(".icon").on({
        click: function(){
            var navBar = $("#mainNav").attr("class");
            if (navBar==="nav"){$("#mainNav").attr("class", navBar+" responsive");}
            else {$("#mainNav").attr("class", "nav");}
        },
    });
});