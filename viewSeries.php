<?php
require ('include.php');

echo createHeader('');

echo createMenu();

$comicArray = json_decode(returnComicSeries(simpleSanitise($_GET['id'])),true);

if($comicArray!='No results'){
	foreach($comicArray as $element) {
		$comicResults .= "<a data-comicid='".$element['id']."' class='comicPreview' href='viewComic.php?id=".$element['id']."'><div class='block card'><img src='".$element['coverimg']."'/><p> #".$element['issue']."</p></div></a>";

	}
}else{
	
	$comicResults .= "<p id='noResults'>No Results Found</p>";
}

echo "<div id='ajaxLoader'></div>";
echo "<div id='content'>";
echo $comicResults;
echo "</div>";