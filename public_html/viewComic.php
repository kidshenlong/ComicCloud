<?php
    require('include.php');

    $viewComic = new ComicViewer();
    $comicReturn = $viewComic->getComic($_GET['id']);

    $script = $title = '';

    if(is_array($comicReturn)){
        //$script = "<meta name='viewport' content='minimal-ui'>";
        $script = "<script type='text/javascript'> var imageArray=".json_encode($comicReturn).";</script>";
        $script .= "<script type='text/javascript' src='js/reader.js'></script>";
        $content = "<div id='comicMenu'></div><div id='comicFrame'><span id='spaceHelper'></span></div>";
        $comicArray = $viewComic->getComic($_GET['id'],true);
        $title = $comicArray['seriesName']." (".$comicArray['seriesStartYear'].") - #".$comicArray['issue'];
    }else{
        $content = $comicReturn;
        $title = 'No Comic Found';
    }

    echo $viewComic->documentHead($title,$script);
    //echo $viewComic->pageHead();
    echo "<div id='content'>$content</div>";