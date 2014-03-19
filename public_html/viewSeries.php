<?php
require('include.php');


    $viewSeries = new Page();
    $seriesArray = $viewSeries->getComicSeries($_GET['id'],0,true);
    $title = $seriesArray['seriesName']." (".$seriesArray['seriesStartYear'].")";
    echo $viewSeries->documentHead($title);
    echo $viewSeries->pageHead();


    echo "<div id='content'>";

    echo $viewSeries->getComicSeries($_GET['id']);

    echo "</div>";