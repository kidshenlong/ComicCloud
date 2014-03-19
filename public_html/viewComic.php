<?php

require('include.php');

$rawFilesArray = array();

$comicArray = json_decode(returnComic(simpleSanitise($_GET['id'])),true);
if($comicArray){
    $comicDirectory = "../comics/extracts/".$comicArray['uploadlocation'];
    if(is_dir($comicDirectory)){
        $content = "<div id='comicFrame' style='height:1000px;'>";

        foreach (scandir($comicDirectory) as $file){
            $file = $comicDirectory."/".$file;
            if(is_file($file) && $file!= $comicDirectory."/ComicInfo.xml"){
                $rawFilesArray[] = $file;
            }
        }

        /*foreach($rawFilesArray as $img){
            $content .=  "<img class='comicPage' style='display:none; margin:auto; position:absolute; top:0; bottom:0; right:0; left:0;' data-src='$img'/>";
        }*/
        $content .= "</div>";

    }else{
        $content = "<p id='noResults'>No Comic Found</p>";
    }
}else{

   $content = "<p id='noResults'>No Comic Found</p>";
}






$filesArray = json_encode($rawFilesArray);
$script = "<script type='text/javascript'> var imageArray=".$filesArray."; console.log(imageArray);</script>";
$script .= "<script type='text/javascript' src='js/reader.js'></script>";

echo createHeader('Comic', $script);

echo createMenu();

echo "<div id='content'>";
echo $content;
echo "</div>";