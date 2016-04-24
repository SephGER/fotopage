<?php
	/**
	@author: Philip Seitz
	
	Funktions-Sammlung und Globale Variablen-Initiation.
	
	
	Todo: Variablen auslagern. Aufräumen.
	
	**/
	
$image_path = "/home/philip/photo/";
$avt_path = "$image_path/users/";
$default_image = $avt_path."default.png";

//Sehr geheim.
$pwd = "passwort";

function makeTypeArray($type){
switch($type){
 case 'fotos':
  $active = array("secondary","primary","secondary","secondary");
  break;
 case 'tags' :
  $active = array("secondary","secondary","primary","secondary");
  break;
 case 'search' :
  $active = array("secondary","secondary","secondary","primary");
  break;
 default :
  $active = array("primary","secondary","secondary","secondary");
  }
 return $active;
 }


//----- Page Switcher ----
//Sagt der index.php welche Seite angezeigt werden soll.
//Dadurch kann das Grund-Layout in der index.php gemacht werden und der Rest wird nur als include eingefügt.
$page = null;
switch($_GET['page']){
case 'photo':
$page="photo";
break;
case 'upload':
$page="upload";
break;
case 'register':
$page="register";
break;
case 'view':
$page="view";
break;
case 'konto':
$page="konto";
break;
default:
$page="home";
}
//---------------------




function checkLogin(){
	// Wirft auf die home-Seite wenn der User nicht eingeloggt ist.
	if (!$_SESSION['login']){
		$page = "home";
	}
}


function rearrange( $arr ){
	//Ordnet einen Array neu an. 
	//Wird für den $_FILE Array nach dem Hochladen der Bilder genutzt.
	foreach( $arr as $key => $all ){
        foreach( $all as $i => $val ){
            $new[$i][$key] = $val;   
        }   
    }
    return $new;
}


function copyAvatar($file,$user){
	//Kopiert den neuen Avatar ins globale Avatar Verzeichnis und geht danach auf die Konto-Seite
	//Todo: Seite dynamisch Übergeben?
	global $avt_path;
	system("cp $file ".$avt_path."$user.png");
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/internal/cosee/index.php?page=konto');
}


function pathEnc($image_path){
	//Verschlüsselt den Pfad
	global $pwd;
return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $pwd, $image_path, MCRYPT_MODE_ECB));
}

function pathDec($image_path){
	//Entschlüsselt den Pfad
	global $pwd;
return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $pwd, $image_path, MCRYPT_MODE_ECB);
}


function formatTags($tags){
	//Erzeugt einen Array mit Tags. Übergeben werden die Tags mit Zeilenumbruch.
	$retar = array();
	preg_match_all("/[a-zA-Z0-9_ äöüß\(\)\.\,]{1,}/",$tags,$retar);
return $retar;
}

function dbInsert($table,$keys,$values){
	//Fügt $values als $keys in die $table der DB ein.
	//Todo: Login-Details global machen.
	$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
		if ($mysqli->connect_error) {
			$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
		} else {
			$query = sprintf("INSERT INTO $table ($keys) VALUES ($values);");
			$result = $mysqli->query($query);
			if($result){
				$message['success'] = $mysqli->insert_id;
				}else $message['error'] = $mysqli->error;
		}
	$mysqli->close();
return $message; 
}


function getImages($user_id,$searched,$type){
	//Holt die Bilder aus der DB
	$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
		if ($mysqli->connect_error) {
			$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
		} else {
			switch($type){
				case "fotos":
					//Fotos im übergebenen Album.
					$query = "SELECT * from tbl_photo LEFT JOIN tbl_album ON tbl_photo.photo_id=tbl_album.album_photo where photo_owner = $user_id and album_name LIKE \"$searched\";";
				break;
				case "tags":
					//Fotos welche die übergebenen Tags haben
					$query = "SELECT * from tbl_photo LEFT JOIN tbl_tags ON tbl_photo.photo_id=tbl_tags.tag_photo where photo_owner = $user_id and tag_name LIKE \"$searched\";";
				break;
				case "search":
					//Fotos welche entweder die Tags oder den Namen haben.
					$query = "SELECT distinct(photo_id),photo_name,photo_path from tbl_photo LEFT JOIN tbl_tags ON tbl_photo.photo_id=tbl_tags.tag_photo where (photo_owner = $user_id) and (tag_name LIKE \"%".$searched."%\" or photo_name LIKE \"".$searched."%\");";
				break;	
				default:
					//Alle Fotos (sollte nicht eintreten)
					$query = "SELECT * from tbl_photo where photo_owner = $user_id";
			}
			$result = $mysqli->query($query);
			if ($result->num_rows>0) {
				$mysqli->close();
				return $result;
				} else {
				$mysqli->close();
				return array();
			}
		}
}


function getImage($user_id,$path){
	//Holt das Bild mit dem Pfad aus der DB. (Da bei der Einzelbildanzeige nur der Pfad vorliegt.)
	$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
		if ($mysqli->connect_error) {
			$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
		} else {
			$query = "SELECT * from tbl_photo where photo_owner = $user_id and photo_path LIKE \"$path\";";
			$result = $mysqli->query($query);
			if ($result->num_rows>0) {
				$mysqli->close();
				return $result;
			}else {
				$mysqli->close();
				return array();
			}
		}
}

function getAlbum($userid){
	//Eine Liste der Alben des Users
	$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
		if ($mysqli->connect_error) {
			$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
		} else {
			$query = "SELECT distinct(album_name) from tbl_album LEFT JOIN tbl_photo ON tbl_photo.photo_id=tbl_album.album_photo where photo_owner = $userid;";
			$result = $mysqli->query($query);
			if ($result->num_rows>0) {
				$mysqli->close();
				return $result;
			}else {
				$mysqli->close();
				return array();
			}
		}
}

function getSingleAlbum($user,$image_id){
	//Album des Bildes
	$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
		if ($mysqli->connect_error) {
			$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
		} else {
			$query = "SELECT * from tbl_album LEFT JOIN tbl_photo ON tbl_photo.photo_id=tbl_album.album_photo where photo_owner = $user and photo_id = $image_id;";
			$result = $mysqli->query($query);
			if ($result->num_rows>0) {
				$mysqli->close();
				return $result;
			}else {
				$mysqli->close();
				return array();
			}
		}
}



function getTags($photo_id){
	//Tags des Bildes
$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
			if ($mysqli->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
			} else {
				$query = "SELECT * from tbl_tags where tag_photo = $photo_id;";
				$result = $mysqli->query($query);
				if ($result->num_rows>0) {
				return $result;
				}else
				return array();
			}
}

function getTagList($user_id){
	//Alle Tags des Users
$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
			if ($mysqli->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
			} else {

				$query = "SELECT distinct(tag_name) from tbl_photo LEFT JOIN tbl_tags ON tbl_photo.photo_id=tbl_tags.tag_photo where photo_owner = $user_id";

				$result = $mysqli->query($query);
				if ($result->num_rows>0) {
				return $result;
				}else
				return array();
			}
}


function deleteImage($image_id){
	//Foto löschen (dank Cascade nur das Foto, Tag- und Albenverknüpfung wird automatisch entfernt)
$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
			if ($mysqli->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
			} else {

				$query = "DELETE from tbl_photo where photo_id = $image_id";

				$result = $mysqli->query($query);
				if ($result->num_rows>0) {
				return $result;
				}else
				return array();
			}
}

function processImages($user,$album,$tags,$image_data){
	//Großes böses Bild-Voodoo.

	global $image_path;

	//--- Wenn der Pfad (/User/Album/) noch nicht existiert wird er hier angelegt
	//!!! Todo: Pfad mit Leerzeichen erlauben !!!
	if(!file_exists($image_path."$user/")){
		system("mkdir ".$image_path."$user/");
	}
	$album_path = $image_path."$user/$album/";
	if(!file_exists($album_path)){
		system("mkdir \"".$album_path."\"");
	}
	//---------------

	//Formatiert die Zeilenumbruch- in Array-Tags
	$tags = formatTags($tags)[0];

	//Bearbeitet jedes einzelne Bild
	foreach($image_data as $image){
		$image_path = $album_path.$image["name"];
		if(!file_exists($image_path)){
			//Kopiert die Bilder wenn sie noch nicht existieren.
			//TODO
			system("cp ".$image["tmp_name"]." \"".$image_path."\"");
			$enc_path = pathEnc($image_path);
			
			//Die ID des Bildes zum Weiterverarbeiten in den Tags und Alben
			$imgid = dbInsert("tbl_photo","photo_name,photo_path,photo_owner,photo_deleted","\"".$image["name"]."\",\"$enc_path\",\"$user\",\"false\"");
			if(isset($imgid["success"])){
				$imgid = $imgid["success"];
				foreach($tags as $tag){
					//Tags zum Bild hinzufügen
					$tagid = dbInsert("tbl_tags","tag_photo,tag_name","$imgid,\"".htmlspecialchars($tag)."\"");
				}
				//Bild zum Album hinzufügen
				$albid = dbInsert("tbl_album","album_photo,album_name","$imgid,\"".htmlspecialchars($album)."\"");
			}
			//Zurück zum Album
			header('Location: http://' . $_SERVER['HTTP_HOST'] . '/internal/cosee/index.php?page=view&type=fotos&album='.$album);
		} else {
			//Todo: Ordentliches Error-Handling.
			echo "Bild schon vorhanden";
		}
	}
}


?>