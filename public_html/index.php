<?php
    require('include.php');
    include_once '../resources/logger.php';

    $home = new Page();

    echo $home->documentHead('Home');
    echo $home->pageHead();

    echo "<div id='content'></div>";
