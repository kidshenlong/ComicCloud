<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23/03/2014
 * Time: 01:13
 */

require('include.php');

$upload = new Page();
$script = "<script src='js/dropzone.js'></script>
<script src='js/upload.js'></script>
<link href='css/dropzone.css' rel='stylesheet' type='text/css' />";

echo $upload->documentHead('Upload Comic',$script);
echo $upload->pageHead();

echo "<div id='content'>";

echo "
    <form action='../resources/templates/comicUploader.php' class='dropzone' id='dropzone'>
        <div class='fallback'>
            <input name='file' type='file' multiple />
        </div>
    </form>";

echo "</div>";
