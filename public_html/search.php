<?php
    require('include.php');

    $search = new Page();

    echo $search->documentHead("Search results for '".simpleSanitise($_GET['searchQuery'])."'");
    echo $search->pageHead();


    echo "<div id='content'>";

    echo $search->getSearchResults($_GET['searchQuery']);

    echo "</div>";