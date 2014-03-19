/**
 * Created by Michael on 18/03/14.
 */
var currentPage = 0;
var currentlyLoaded = 0;
var totalPages;
var loadingImages = true;

$( document ).ready(function() {
    totalPages = imageArray.length;//$("#comicFrame").children().length;
    loadImage(8);
    $("#ajaxLoader").show();
    $("body").css("overflow","hidden");

    $('#comicFrame').imagesLoaded( function() {
        console.log('imagesLoaded');
        $(".comicPage").first().show();
        $("#ajaxLoader").hide();
        $("body").css("overflow","inherit");
        loadingImages = false;
    });

    $("#comicFrame").click(function(){
        if(loadingImages && currentPage + 10 > currentlyLoaded ){
            $("#ajaxLoader").show();
            console.log('not ready');
        }else{

            changePage("next");
        }
    });
});
$(window).load(function() {
    /*$("#ajaxLoader").hide();
    $("body").css("overflow","inherit");*/
});
function loadImage(imgNo){
    loadingImages = true;

    for( var i = currentlyLoaded; i < currentlyLoaded + imgNo; i++){
        if(i < totalPages){
            $("<img class='comicPage' style='display:none; margin:auto; position:absolute; top:0; bottom:0; right:0; left:0;' src='" + imageArray[i] + "'/>").appendTo('#comicFrame');
        }else{
            return;
        }
    }

    currentlyLoaded = currentlyLoaded + imgNo;
    console.log("Loaded" + currentlyLoaded );


}
function changePage(action){
    switch(action){
        case "next":
            if(currentPage+1 < totalPages){
                $("#comicFrame").children().eq(currentPage).hide();
                currentPage++;
                if(currentPage + 1 == currentlyLoaded-4){
                    loadImage(8);
                    $('#comicFrame').imagesLoaded( function() {
                        console.log('imagesLoaded again');
                        loadingImages = false;
                        $("#ajaxLoader").hide();
                    });
                }
                $("#comicFrame").children().eq(currentPage).show();
            }
            break;
        case "previous":
            if(currentPage-1 >= 0){
                $("#comicFrame").children().eq(currentPage).hide();
                currentPage--;
                $("#comicFrame").children().eq(currentPage).show();
            }
            break;
    }
}