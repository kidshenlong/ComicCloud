<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23/03/2014
 * Time: 12:08
 */

ini_set('max_execution_time', 300);

/*class Unpack {

    public $destination = "../uploads/";
    public $allowedMimes;
    puclic $allowedExtension
    public $file;

    public allowedType(){

        $accepted_types = array ('application/zip','application/rar','application/x-zip-compressed', 'multipart/x-zip','application/x-compressed','application/octet-stream','application/x-rar-compressed','compressed/rar','application/x-rar');

    }



}*/

/*class Upload {

    public $destination;
    public $maxFileSize;
    public $file;



}*/

$destination = '../../comics/extracts';
$userid = 1;

include_once '../logger.php';

$log = new logger('../../logs/upload_log_'.date("Y-m-d").'.txt');

function extractComic($file){
    global $db,$userid, $destination, $log;

    //$extract_path = "rawcomics";  // change this to the correct site path
    //$rawarchive_path = "rawarchives";  // change this to the correct site path


    $progressLog = array();

    $pages = array();

    if(file_exists($file)){

        $fileTypeFromFile = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $fileName = pathinfo($file,PATHINFO_BASENAME);

        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type aka mimetype extension
        $fileTypeMime = finfo_file($finfo, $file) ;

        $accepted_types = array ('application/zip','application/rar','application/x-zip-compressed', 'multipart/x-zip','application/x-compressed','application/octet-stream','application/x-rar-compressed','compressed/rar','application/x-rar');

        if(in_array($fileTypeMime,$accepted_types)){

            if($fileTypeFromFile == 'zip' || $fileTypeFromFile == 'rar' || $fileTypeFromFile == 'cbz' || $fileTypeFromFile == 'cbr'){

                $randPath = genString();

                $comicextractpath = $destination."/".$randPath;


                if(!is_dir($comicextractpath)){
                    mkdir($comicextractpath);
                }else{
                    //return $progressLog['Fail'] = "Directory already exists";
                    while(is_dir($comicextractpath)){
                        $randPath = genString();
                        $comicextractpath = $destination."/".$randPath;
                        //$comicextractpath = $destination."/".genString();
                    }
                }

                if($fileTypeFromFile == 'zip' || $fileTypeFromFile == 'cbz' ){
                    $zip = new ZipArchive();
                    $x = $zip->open($file);
                    if($x == true) {
                        try{

                            /*$file = $zip->getNameIndex($i);
                            $trueFile = basename($file);
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            if($ext== 'jpg' || $ext =='jpeg'){
                               // $zip->extract(false,$comicextractpath.'/'.$trueFile);
                                $zip->extractTo($comicextractpath.'/', $trueFile);
                                $pages[] = $randPath.'/'.$trueFile;
                            }*/
                            for ( $i=0; $i < $zip->numFiles; $i++ )
                            {
                                $entry = $zip->getNameIndex($i);
                                if ( substr( $entry, -1 ) == '/' ) continue; // skip directories

                                $fp = $zip->getStream( $entry );
                                $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
                                if($ext== 'jpg' || $ext =='jpeg'){
                                    $ofp = fopen( $comicextractpath.'/'.basename($entry), 'w' );
                                    $pages[] = $randPath.'/'.basename($entry);
                                }
                                if ( ! $fp )
                                    throw new Exception('Unable to extract the file.');

                                while ( ! feof( $fp ) )
                                    fwrite( $ofp, fread($fp, 8192) );

                                fclose($fp);
                                fclose($ofp);
                            }
                            $zip->close();

                            exec("php -f ../comicResizer.php path=$randPath > /dev/null 2>/dev/null &", $output, $return);

                        }catch(Exception $e){
                            $progressLog['Fail'] = "Zip Extraction Failed";
                        }

                    }else {
                        $progressLog['Fail'] = "Zip Archive Error";
                    }
                }else if( $fileTypeFromFile == 'rar' || $fileTypeFromFile == 'cbr' ){
                    $x = rar_open($file);

                    if($x == true){
                        try{
                            $entries = rar_list($x);



                            foreach ($entries as $key=>$entry) {

                                $file = $entry->getName();
                                $trueFile = basename($file);
                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                if($ext== 'jpg' || $ext =='jpeg'){
                                    $entry->extract(false,$comicextractpath.'/'.$trueFile);
                                    $pages[] = $randPath.'/'.$trueFile;
                                }
                            }

                            rar_close($x);

                            exec("php -f ../comicResizer.php path=$randPath > /dev/null 2>/dev/null &", $output, $return);
                            if ($return) {
                                //$log->write('Comic '.$_FILES["file"]["name"].' uploaded.');
                            }


                        }catch(Exception $e){
                            $progressLog['Fail'] = "Rar Extraction Failed";
                        }
                    }else{
                        $progressLog['Fail'] = "Rar Archive Error";
                    }

                }

            }else{
                $progressLog['Fail'] = "File extension not recognised";
            }
        }else{
            $progressLog['Fail'] = "File type not recognised";
        }

    }else{
        $progressLog['Fail'] = "File does not exist";
    }


    //if(!empty($progressLog)){
    if(array_key_exists("Fail",$progressLog)){
        return $progressLog['Fail'] = "Errors found. Cannot Continue.";
    }else{
        try {
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare('INSERT INTO comics VALUES(null,:user,:loc,FALSE)');
            $stmt->execute(array(
                ':user' => $userid,
                ':loc' => $randPath
            ));

            $ID = $db->lastInsertId();

            $titlePreg = ' Vol.[0-9]+| #[0-9]+|\(.*?\)|\.[a-z0-9A-Z]+$';
            $comicTitle = preg_replace('/'.$titlePreg.'/', "", $fileName);
            $comicTitle = trim($comicTitle);

            preg_match("/#[0-9]+/", $fileName, $output_array);
            $issueNo = str_replace('#', '',$output_array[0]);
            $issueNo = ltrim($issueNo, '0');

            $stmt = $db->prepare('INSERT INTO comicsInfo VALUES(:id,:title,:issue,NULL,:cover_image,:pages)');
            $stmt->execute(array(
                ':id' => $ID,
                ':title' => $comicTitle,
                ':issue' => $issueNo,
                ':cover_image' => $pages[0],
                ':pages' => json_encode($pages)
            ));

        } catch(PDOException $e) {
            return $progressLog['Fail'] = "Database Write Failed";
            $log->write("Database write fail... ".print_r($e));
            //echo 'progress: ' . $e->getMessage();
        }
    }
    //print_r($progressLog);
}

function unpackArchive ($file){

}
function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];

    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}
/*$_FILES['field_name']['name']
$_FILES['field_name']['size']
$_FILES['field_name']['type']
$_FILES['field_name']['tmp_name']*/