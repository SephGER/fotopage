<div class="container" style="padding:1%;">
	<div class="row" style="margin-top:5px;">
<div class="twelve columns head" style="padding:20px;margin-top:10%;margin-bottom:-4%;background-color:#fff;border-radius:20px;">
<div class="six columns">
<?php
//checkLogin();
$album_name = $_POST['album_name'];
$tags = $_POST['album_tags'];
if (isset($_POST['type'])){
$_FILES['img'] = rearrange($_FILES['img']);

switch($_POST['type']){
case "avatar":
copyAvatar($_FILES['img'][0]['tmp_name'],$_SESSION['user']['user_name']);
break;
case "images":
processImages($_SESSION['user']['user_id'],$album_name,$tags,$_FILES['img']);
break;
default:
var_dump($_POST);
var_dump($_FILES['img']);
}
}else{
if($_GET['type'] == 'avatar')
{
?>
<h1>Change Avatar</h1>
<form action="index.php?page=upload" method="post" multipart="" enctype="multipart/form-data" accept-charset="utf-8">
<input type="hidden" name="type" value="avatar">
<label for="images[]">Bild</label>
<input type="file" name="img[]" />
<?php
}else{
?>
<h1>Upload</h1>
<form action="index.php?page=upload" method="post" multipart="" enctype="multipart/form-data" accept-charset="utf-8">
<input type="hidden" name="type" value="images">
<label for="album_name">Album Name</label>
<input type="text" placeholder="Name des Albums (zB Urlaub Italien, Geburtstag 2016, etc...)" style="min-width:500px" name="album_name" value="<?=$album_name?>">
<label for="album_tags">Tags</label>
<textarea type="text" placeholder="Tags die alle Bilder des Albums haben sollen. Mit Zeilenumbruch mehrere Tags trennen. Die Tags können später pro Bild noch bearbeitet werden." style="min-width:500px;;min-height:80px" name="album_tags"></textarea>
<label for="images[]">Bilder</label>
<input type="file" multiple name="img[]" />
<?php
}
?>
<input type="submit" value="Hochladen">
</div>
<?php
if($_GET['type'] == 'avatar')
{
?>
<div class="six columns" align="right" style="padding-right:10%;padding-top:5%">
<h5>Momentaner Avatar:</h5>
<img src="image.php?path=<?=$_SESSION['user']['avatar']?>" style="max-width:150px;">
</div>
<?php
}
}
?>
</form>
</div>
</div>
</div>