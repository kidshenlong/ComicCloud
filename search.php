<?php
require ('include.php');

echo createHeader('');

echo createMenu();



$comicArray = json_decode(searchDB(simpleSanitise($_GET['searchQuery']),$offset = 0),true);

if($comicArray!='No results'){
	foreach($comicArray as $element) {
		$comicResults .= "<a data-seriesid='".$element['id']."' class='seriesPreview' href='viewSeries.php?id=".$element['id']."'><div class='block card'><img src='".$element['seriesCover']."'/><p>".$element['seriesName']." (".$element['seriesStartYear'].")</p></div></a>";
	}
}else{
	
	$comicResults .= "<p id='noResults'>No Results Found</p>";
}

echo "<div id='ajaxLoader'></div>";
echo "<div id='content'>";
echo $comicResults;
echo "</div>";		