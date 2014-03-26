<?php
include_once '/home/kidshenlong/Private/login.php';

if (isset($argv)) {
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
}

file_put_contents('resizelog.txt', 'made it '.$_GET["path"]);
$db = db_con('pdo','comiccloud');

ini_set('max_execution_time', 300);

$dir= "~/atomichael.com/comichome/comics/extracts/".$_GET["path"];

$cmd = "mogrify -resize 1000x $dir/*.jpg";
//exec($cmd . " > /dev/null &");

exec ($cmd, $output, $return);
//convert example.png -resize 200◊100 example.png
// Return will return non-zero upon an error
if (!$return) {
    //echo "Successfully";
    $stmt = $db->prepare("UPDATE comics SET finishedProcess=TRUE WHERE location=:param");
    //$stmt->bindValue(':value', $_GET["path"]);
    $stmt->bindValue(':param', $_GET["path"]);
    $stmt->execute();
    file_put_contents('resizelog.txt', ' success', FILE_APPEND);

} else {
    file_put_contents('resizelog.txt', ' fail', FILE_APPEND);
    /*echo "Fail not created";
    print_r($return);
    print_r($output);*/
}
?>