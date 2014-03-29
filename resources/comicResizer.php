<?php
include_once '/home/kidshenlong/Private/login.php';
//include_once 'logger.php';

//$log = new logger('../logs/resize_log_'.date("Y-m-d").'.txt');


if (isset($argv)) {
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
}

//$log->write('Comic Resize Script has been initialised for '.$_GET["path"]);

$db = db_con('pdo','comiccloud');

ini_set('max_execution_time', 300);

$dir= "~/atomichael.com/comichome/comics/extracts/".$_GET["path"];

$cmd = "mogrify -resize 1000x $dir/*.jpg";
//exec($cmd . " > /dev/null &");

exec ($cmd, $output, $return);

if (!$return) {
    //$log->write('Comic Resize Script has successfully resized '.$_GET["path"]);
    $stmt = $db->prepare("UPDATE comics SET finishedProcess=TRUE WHERE location=:param");

    $stmt->bindValue(':param', $_GET["path"]);
    if($stmt->execute()){
        $log->write('Database update for '.$_GET["path"].' complete.');
    }else{
        $log->write('Database update for '.$_GET["path"].' failed.');
    }


} else {
    //$log->write('Comic Resize Script has failed to resize '.$_GET["path"]);
    /*echo "Fail not created";
    print_r($return);
    print_r($output);*/
}
?>