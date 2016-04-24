
<div class="container" style="padding:1%;">
	<div class="row" style="margin-top:5px;">
<div class="twelve columns head" style="padding:20px;margin-top:10%;margin-bottom:-4%;background-color:#fff;border-radius:20px;">
<div class="nine columns">
<?php

	$encrypted = rawurlencode($_GET['path']);

	$photos = getImage($_SESSION['user']['user_id'],base64_encode($_GET['path']));
	$photo = mysqli_fetch_object($photos);
	
	$tags = getTags($photo->photo_id);
	$albums = getSingleAlbum($_SESSION['user']['user_id'],$photo->photo_id);
	$album = mysqli_fetch_object($albums);
	
	foreach($tags as $key=>$value){
	$taglist[$key] = $value['tag_name'];
	}
	
	?>

<div class="out_of_whole">
<img class="whole_img" src="image.php?path=<?=$encrypted?>">
</div>

<span><a href=""><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
Previous</a></span>
<span style="float:right">
<a href="">Next<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></span>


<hr style="margin-top:-3px;margin-bottom:-3px;">
<p ><?=$image['photo_name']?></p>
<ul class="tags">
<?php
$tagses = getTags($image["photo_id"]);
foreach($tagses as $tag){
echo "<li><a class=\"tag\" href=\"\">".$tag["tag_name"]."</a></li>\n";
}
?>
</ul>
</div>
<div class="three columns">
Name: <?=$photo->photo_name?><br>
Album: <?=$album->album_name?><br>
Tags: <br><br><ul class="tags">
<?
foreach($taglist as $tag){
echo "<li>$tag</li>\n";
}
?>
</ul>
<a href="image.php?path=<?=$encrypted?>" class="button">Download</a>
<a href="image.php?path=<?=$encrypted?>" class="button button-primary">Delete</a>
</div>
</div>
</div>
</div>