<?php
	include_once '/home/kidshenlong/Private/login.php';
	$db = db_con('pdo','comiccloud');

	function searchDB($search,$offset = 0){

		global $db;

		try {
			//$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$stmt = $db->prepare("SELECT * FROM comicSeries WHERE seriesName LIKE :value LIMIT 16 OFFSET :offsetValue");
			//$stmt->execute(array(':value' => "%".$search."%", ':offsetValue' => $offset, PDO::PARAM_INT));
			$stmt->bindValue(':value', "%".$search."%");
			$stmt->bindValue(':offsetValue',intval($offset),PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll();
			//print_r($result);
			if (count($result) ) { 
				return json_encode($result);  
			} else {
				//return "No results returned.";
				//return json_encode('No results');
                return false;
			}
			  
		} catch(PDOException $e) {
			//echo 'ERROR: ' . $e->getMessage();
			return json_encode('ERROR: ' . $e->getMessage());
		}

	}

	function returnComicSeries($seriesID){

		global $db;

		try {

			$stmt = $db->prepare("SELECT * FROM comics WHERE seriesID = :value ORDER BY issue DESC");
			$stmt->execute(array(':value' => $seriesID));

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!empty($result)){
				return json_encode($result);  
			} else {
				//return "No results";
				//return json_encode('No results');
                return false;
			}
			  
		} catch(PDOException $e) {
			//echo 'ERROR: ' . $e->getMessage();
			return json_encode('ERROR: ' . $e->getMessage());
		}


	}
    //Ajax switch??
	if(isset($_POST['action']) && !empty($_POST['action'])){
		switch ($_POST['action']) {
			case "searchResults":
				echo searchDB($_POST['searchWord'],$_POST['offset']);
			break;
			case "returnComicSeries":
				echo returnComicSeries($_POST['seriesID']);
			break;
		}
	}
	function returnComic($comicID){
		
		global $db;

		try {

			$stmt = $db->prepare("SELECT * FROM uploads WHERE id = :value");
			$stmt->execute(array(':value' => $comicID));

			//$result = $stmt->fetchAll();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!empty($result)){
				return json_encode($result);
			} else {
				//return "No results";
				//return json_encode('No results');
                return false;
			}
			  
		} catch(PDOException $e) {
			//echo 'ERROR: ' . $e->getMessage();
			return json_encode('ERROR: ' . $e->getMessage());
		}


	}
?>