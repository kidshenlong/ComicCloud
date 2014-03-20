<?php
    require('include.php');

    $viewComic = new ComicViewer();
    $comicReturn = $viewComic->getComic($_GET['id']);
    $script = '';

    if(is_array($comicReturn)){
        $script = "<script type='text/javascript'> var imageArray=".json_encode($comicReturn)."; console.log(imageArray);</script>";
        $script .= "<script type='text/javascript' src='js/reader.js'></script>";
        $content = "<div id='comicFrame' style='height:1000px;'></div>";
    }else{
        $content = $comicReturn;
    }

    echo $viewComic->documentHead('',$script);
    echo $viewComic->pageHead();
    echo "<div id='content'>$content</div>";