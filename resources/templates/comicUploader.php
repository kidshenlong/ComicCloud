<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23/03/2014
 * Time: 18:37
 */

include_once 'comicHandler.php';
include_once '../functions/functions.php';
include_once '/home/kidshenlong/Private/login.php';

$db = db_con('pdo','comiccloud');

$upload_path = "../../uploads";

$userid = "1";


if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
}
else
{
    move_uploaded_file($_FILES["file"]["tmp_name"], "$upload_path/" . $_FILES["file"]["name"]);
    header('Content-Type: application/json');
    echo extractComic("$upload_path/" . $_FILES["file"]["name"]);
}