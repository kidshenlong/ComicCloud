<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23/03/2014
 * Time: 12:08
 */

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

function extractComic($file){
    global $db,$userid, $destination;

    //$extract_path = "rawcomics";  // change this to the correct site path
    //$rawarchive_path = "rawarchives";  // change this to the correct site path


    $progressLog = array();

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
                        $comicextractpath = $destination."/".genString();
                    }
                }

                if($fileTypeFromFile == 'zip' || $fileTypeFromFile == 'cbz' ){
                    $zip = new ZipArchive();
                    $x = $zip->open($file);
                    if($x == true) {
                        try{
                            $zip->extractTo($comicextractpath); // change this to the correct site path
                            $zip->close();
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


                            foreach ($entries as $entry) {

                                $entry->extract($comicextractpath);
                                $fullPath = $comicextractpath."/".$entry->getName();
                                //$outFile = "test-cropped.jpg";
                                $image = new Imagick($fullPath);
                                $image->cropImage(400,400, 30,10);
                                $image->writeImage($fullPath);


                            }

                            rar_close($x);

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

            $stmt = $db->prepare('INSERT INTO uploads VALUES(null,:user,:filename,:loc,FALSE)');
            $stmt->execute(array(
                ':user' => '1',
                ':filename' => $fileName,
                ':loc' => $randPath//$comicextractpath
            ));

            $ID = $db->lastInsertId();
            //rename("$file", "$rawarchive_path/".$ID.".".$fileTypeFromFile);

            $titlePreg = ' Vol.[0-9]+| #[0-9]+|\(.*?\)|\.[a-z0-9A-Z]+$';
            $comicTitle = preg_replace('/'.$titlePreg.'/', "", $fileName);
            $comicTitle = trim($comicTitle);

            preg_match("/#[0-9]+/", $fileName, $output_array);
            $issueNo = str_replace('#', '',$output_array[0]);
            $issueNo = ltrim($issueNo, '0');

            return json_encode(array('id'=>$ID,'title'=>$comicTitle,'issueNo'=>$issueNo));

            //return $ID;

            # Affected Rows?
            //echo $stmt->rowCount(); // 1
            //echo "Success<br/>";
        } catch(PDOException $e) {
            return $progressLog['Fail'] = "Database Write Failed";
            //echo 'progress: ' . $e->getMessage();
        }
    }
    //print_r($progressLog);
}

function unpackArchive ($file){

}
/*$_FILES['field_name']['name']
$_FILES['field_name']['size']
$_FILES['field_name']['type']
$_FILES['field_name']['tmp_name']*/