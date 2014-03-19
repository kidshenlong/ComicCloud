<?php
    require('include.php');

    $home = new Page();

    echo $home->documentHead('Home');
    echo $home->pageHead();

    echo "<div id='content'></div>";
