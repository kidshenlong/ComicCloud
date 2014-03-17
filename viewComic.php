<?php
require ('include.php');



$comicArray = json_decode(returnComic(simpleSanitise($_GET['id'])),true);

$comicDirectory = "../comics/".$comicArray['uploadlocation'];
//$rawFilesArray = array_diff(scandir($comicDirectory), array('..', '.','ComicInfo.xml'));

$rawFilesArray = array();

foreach (scandir($comicDirectory) as $file){
	$file = $comicDirectory."/".$file;
	if(is_file($file) && $file!= $comicDirectory."/ComicInfo.xml"){
		$rawFilesArray[] = $file;
	}
}

$filesArray = json_encode($rawFilesArray);
$script = '
<script type="text/javascript">
	var currentPage = 0;
	var currentlyLoaded = 0;
	var totalPages = $("#comicFrame").children().length;
	var imageArray='.$filesArray.'
	$( document ).ready(function() {
		loadImage(8);
		$("#ajaxLoader").show();
		$(".comicPage").first().show();
		$("body").css("overflow","hidden");
		$("#comicFrame").click(function(){

            $("#comicFrame").children().eq(currentPage).hide();
            currentPage++;
            if(currentPage + 1 > currentlyLoaded-4){
                loadImage(8);
            }
            $("#comicFrame").children().eq(currentPage).show();

		});
	});
	$(window).load(function() {
    	$("#ajaxLoader").hide();
    	$("body").css("overflow","inherit");
	});
	function loadImage(imgNo){
	    currentlyLoaded = currentlyLoaded + imgNo;

		$(".comicPage").each(function(index, item){
			if(index < currentlyLoaded ){
				$(item).attr("src", $(item).data("src"));
				//$(item).css("display","inherit");
			}
		});
	}

</script>
';

echo createHeader('Comic', $script);

echo createMenu();

echo "<div id='ajaxLoader'></div>";
echo "<div id='ajaxLoader2'></div>";
echo "<div id='content'>";
echo "<div id='comicFrame' style='height:1000px;'>";
foreach($rawFilesArray as $img){
	echo "<img class='comicPage' style='display:none; margin:auto; position:absolute; top:0; bottom:0; right:0; left:0;' data-src='$img'/>";
}
echo "</div>";
//echo "<img class='comicPage' src='../comichome/".$dir."/".$files1[2]."'/>";
echo "</div>";