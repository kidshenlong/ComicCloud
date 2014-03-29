<?php
require('include.php');


    $viewSeries = new Page();
    $seriesArray = $viewSeries->getComicSeries(urldecode($_GET['series']),0,true);
    $title = $seriesArray['comic_series']." (".$seriesArray['comic_start_year'].")";
    echo $viewSeries->documentHead($title);
    echo $viewSeries->pageHead();


    echo "<div id='content'>";

    echo $viewSeries->getComicSeries(urldecode($_GET['series']));

    echo "</div>";