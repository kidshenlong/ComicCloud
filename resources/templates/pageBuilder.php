<?php
    include_once '/home/kidshenlong/Private/login.php';

    $db = db_con('pdo','comiccloud');

    class Page{
            /*public $title;
            public $script;*/

            public function __construct(){
                /*$this->title = $title;
                $this->script = $script;*/
            }
            public function documentHead($title = 'Default', $script=''){
                $header = "
                <!DOCTYPE html>
                    <head>
                        <title>Comic Cloud - ".$title."</title>
                        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css' />
                        <link href='css/styles.css' rel='stylesheet' type='text/css' />
                        <script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
                        <link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css' />
                        <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'></script>
                        <script src='http://browserstate.github.io/history.js/scripts/bundled/html4+html5/jquery.history.js'></script>
                        <script src='js/imagesloaded.pkgd.min.js'></script>
                        <script src='js/main.js'></script>
                        <script src='js/functions.js'></script>".
                        $script.
                        "<meta name='viewport' content='initial-scale=1, maximum-scale=1, minimal-ui'>
                    </head>
                    <body>
                        <div id='ajaxLoader'></div>
                        <div id='ajaxLoader2'></div>";

                return $header;

            }
            public function pageHead(){
                $menu = "
                <div id='header'>
                    <div id='nameplate'><a href='./'>Comic Cloud</a></div>
                    <div id='menu'>
                        <ul>
                            <li><form id='searchForm' action='search.php'><input name='searchQuery' id='searchField' placeholder='Search Comic Title' type='search'></form></li>
                        </ul>
                    </div>
                </div>";

                return $menu;
            }
            public function getSearchResults($search,$offset = 0){
                global $db;
                $search = simpleSanitise($search);
                try {
                    //$stmt = $db->prepare("SELECT * FROM comicSeries WHERE seriesName LIKE :value LIMIT 16 OFFSET :offsetValue");
                    $stmt = $db->prepare("SELECT comic_series, comic_start_year, comic_cover_image FROM comicsInfo WHERE comic_series LIKE :value GROUP BY comic_series, comic_start_year ORDER BY comic_issue LIMIT 16 OFFSET :offsetValue");

                    $stmt->bindValue(':value', "%".$search."%");
                    $stmt->bindValue(':offsetValue',intval($offset),PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($result) ) {
                        $comicResults = '';
                        foreach($result as $element) {
                            $comicResults .= "<a data-series='".urlencode($element['comic_series'])."' class='seriesPreview' href='viewSeries.php?series=".urlencode($element['comic_series'])."'><div class='block card'><img src='../comics/extracts/".$element['comic_cover_image']."'/><p>".htmlspecialchars($element['comic_series'])." (".htmlspecialchars($element['comic_start_year']).")</p></div></a>";
                        }
                        return $comicResults;
                    } else {
                        return $comicResults = "<p id='noResults'>No Results Found</p>";
                    }
                } catch(PDOException $e) {
                    return 'ERROR: ' . $e->getMessage();
                }
            }
            public function getComicSeries($seriesID, $offset = 0, $asArray = false){
                global $db;
                $seriesID = simpleSanitise($seriesID);
                try {
                    //$stmt = $db->prepare("SELECT * FROM comics INNER JOIN comicSeries ON  WHERE seriesID = :value ORDER BY issue DESC LIMIT 16 OFFSET :offsetValue");
                    $stmt = $db->prepare("SELECT a.*, b.* FROM comics AS a INNER JOIN comicSeries AS b ON a.seriesID=b.id");
                    $stmt->bindValue(':value', intval($seriesID),PDO::PARAM_INT);
                    $stmt->bindValue(':offsetValue',intval($offset),PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($result)){
                        $comicResults = '';
                        if($asArray == true){
                            return $result[0];
                        }
                        foreach($result as $element) {
                            $comicResults .= "<a data-comicid='".$element['id']."' class='comicPreview' href='viewComic.php?id=".$element['id']."'><div class='block card'><img src='".$element['coverimg']."'/><p> #".$element['issue']."</p></div></a>";
                        }
                        return $comicResults;
                    }else{
                        return $comicResults = "<p id='noResults'>No Results Found</p>";
                    }
                } catch(PDOException $e) {
                    return 'ERROR: ' . $e->getMessage();
                }
            }
        }

        class ComicViewer extends Page{

            public function getComic($comicID,$asArray = false){

                global $db;
                $comicID = simpleSanitise($comicID);
                try {

                    //$stmt = $db->prepare("SELECT * FROM uploads WHERE id = :value");
                    $stmt = $db->prepare("SELECT a.*,b.issue,c.seriesName,c.seriesStartYear FROM uploads AS a INNER JOIN comics AS b ON a.id=b.locationid INNER JOIN comicSeries AS c ON b.seriesID=c.id WHERE a.id = :value");
                    $stmt->execute(array(':value' => $comicID));

                    //$result = $stmt->fetchAll();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!empty($result)){
                        if($asArray == true){
                            return $result;
                        }
                        $comicDirectory = "../comics/extracts/".$result['uploadlocation'];
                        if(is_dir($comicDirectory)){
                            $rawFilesArray = array();
                            foreach (scandir($comicDirectory) as $file){
                                $file = $comicDirectory."/".$file;
                                if(is_file($file) && $file!= $comicDirectory."/ComicInfo.xml"){
                                    $rawFilesArray[] = $file;
                                }
                            }
                            return $rawFilesArray;
                        }else{
                            return $comicResults = "<p id='noResults'>No Comic Found</p>";
                        }
                    } else {
                        return $comicResults = "<p id='noResults'>No Comic Found</p>";
                    }

                } catch(PDOException $e) {
                    return 'ERROR: ' . $e->getMessage();
                }
            }
        }


