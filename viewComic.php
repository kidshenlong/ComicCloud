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
	var imageArray='.$filesArray.'
	$( document ).ready(function() {
		loadImage(8);
		$("#ajaxLoader").show();
		$(".comicPage").first().show();
		$("body").css("overflow","hidden");
	});
	$(window).load(function() {
    	$("#ajaxLoader").hide();
    	$("body").css("overflow","inherit");
	});
	function loadImage(imgNo){
		/*for (var i = 0; i < imgNo; i++) {
			$(".comicPage")[i].attr("src",$(".comicPage")[i].data("src"));
		}*/
		$(".comicPage").each(function(index, item){
			//$(item).css("z-index", $(".comicPage").length - index);
			if(index < imgNo){
				$(item).attr("src", $(item).data("src"));
				//$(item).css("display","inherit");
			}else{
				//return false;
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