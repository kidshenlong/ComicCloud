/**
 * Created by Michael on 18/03/14.
 */
var currentPage = 1;
var currentlyLoaded = 0;
var totalPages;
var loadingImages = true;

$( document ).ready(function() {
    $("#content").addClass('comicMode');
    totalPages = imageArray.length;//$("#comicFrame").children().length;
    $( "body" ).animate({backgroundColor:"#000000"},1000);
    $("#ajaxLoader").show();
    $("body").css("overflow","hidden");
    loadImage(8);

    $('#comicFrame').imagesLoaded( function() {
        //console.log('Initial Image Load');
        $(".comicPage").first().show();
        $("#ajaxLoader").hide();
        $("body").css("overflow","inherit");
        //loadingImages = false;
    });

    $("#comicFrame").click(function(){
        changePage("next");
    });

    $('#comicFrame').on('mousemove', function (event) {
        //if (35 - event.clientY < 0) {
        if(event.clientY > $( window ).height()-200){
            $('#comicMenu').stop(true).fadeIn();
        }else{
            $('#comicMenu').fadeOut();
        }
    });

    $('#comicMenu').on('mouseout', function () {
        $(this).fadeOut();
    });
});
$(window).load(function() {
    /*$("#ajaxLoader").hide();
    $("body").css("overflow","inherit");*/
});
$(document).keydown(function(e) {
    switch(e.which) {
        case 37: // left
            changePage("previous");
            break;

        case 38: // up
            break;

        case 39: // right
            changePage("next");
            break;

        case 40: // down
            break;

        default: return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
});
function loadImage(imgNo){
    loadingImages = true;

    for( var i = currentlyLoaded; i < (currentlyLoaded + imgNo); i++){

        if(i < totalPages){
            $("<img class='comicPage' style='display:none;' src='" + imageArray[i] + "'/>").appendTo('#comicFrame');
        }else{
           // return;
            //break;
        }
    }
    currentlyLoaded = 0;
    $('#comicFrame').imagesLoaded( function() {
        //console.log('Image loading complete.');
        loadingImages = false;
        $("#ajaxLoader").hide();
    }).progress( function( instance, image ) {
        var result = image.isLoaded ? 'loaded' : 'broken';
        /*console.log( 'image is ' + result + ' for ' + image.img.src );
        console.log('Image Loaded');*/
        currentlyLoaded++;
        console.log('Current Loaded: ' + currentlyLoaded);
    });

    //currentlyLoaded = currentlyLoaded + imgNo;
    //console.log("Loaded" + currentlyLoaded );


}

/*if(loadingImages && currentPage + 10 > currentlyLoaded ){
    $("#ajaxLoader").show();
    console.log('not ready');
}else{

}*/
function changePage(action){
    switch(action){
        case "next":
            if(currentPage < totalPages){
                if(loadingImages && (currentPage + 2) > currentlyLoaded){
                    $("#ajaxLoader").show();
                    console.log('not ready');
                }else{

                    $('body').css({'overflow':'hidden'});
                    $("#comicFrame").children('.comicPage').eq(currentPage-1).hide();
                    $('body').css({'overflow':'inherit'});
                    window.scrollTo(0,0);

                    currentPage++;

                    $("#comicFrame").children('.comicPage').eq(currentPage-1).show();


                    if(currentPage == currentlyLoaded-4){
                        loadImage(8);
                    }

                }
            }
            break;
        case "previous":
            if(currentPage-1 >= 1){
                $("#comicFrame").children().eq(currentPage).hide();
                currentPage--;
                $("#comicFrame").children().eq(currentPage).show();
            }
            break;
    }
}
