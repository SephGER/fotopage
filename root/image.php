<?php
	/**
	@author: Philip Seitz
	
	Erstellt aus dem verschlüsselten Pfad das Bild und zeigt es an.
	
	**/
include('functions.php');


$encrypted = rawurldecode($_GET['path']);

$filepath = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $pwd, $encrypted, MCRYPT_MODE_ECB);


$filepath = trim($filepath);

if(file_exists($filepath)){
header("Content-Type: ".image_type_to_mime_type(exif_imagetype($filepath)));
readfile($filepath);
}else
{
header("Content-Type: ".image_type_to_mime_type(exif_imagetype($default_image)));
readfile($default_image);
}


?>