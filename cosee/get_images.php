<?php
	/**
	@author: Philip Seitz
	
	Schaut nach welcher Typ Bilder aus der DB geholt werden soll (Sortiert nach Album/Tags oder eine Suche)
	Danach werden die Bilder in einen Array geladen.
	

	**/


switch($_GET['type']){
	case "search":
		if (!isset($_GET['searched'])){
			$searched_for = "Suche beginnen";
		}
		else{
			$searched_for = $_GET['searched'];
		}
	break;
	case "tags":
		$tags = getTagList($_SESSION['user']['user_id']);
		foreach($tags as $key=>$value){
			$tagses[$key][0] = $value["tag_name"];
			if($_GET['tag'] == $value["tag_name"]){
				$tagses[$key][1] = "true";}else{
				$tagses[$key][1] = "false";}
			}
			if (!isset($_GET['tag'])){
				$searched_for = $tagses[0][0];
			}
			else{
				$searched_for = $_GET['tag'];
			}
	break;
	default:
		$albums = getAlbum($_SESSION['user']['user_id']);
		foreach($albums as $key=>$value){
			$albenliste[$key][0] = $value["album_name"];
			if($_GET['album_name'] == $value["album_name"]){
				$albenliste[$key][1] = "true";}else{
				$albenliste[$key][1] = "false";}
			}
			if (!isset($_GET['album_name'])){
				$searched_for = $albenliste[0][0];
			}
			else{
				$searched_for = $_GET['album_name'];
			}
}

//Holt die Bilder je nach Abfrage in den Array
//(functions.php -> getImages)
$user_images = getImages($_SESSION['user']['user_id'],"$searched_for",$_GET['type']);

?>