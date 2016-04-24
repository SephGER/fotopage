<!-- 
@author: Philip Seitz

Bild zur Darstellung in einer Liste (Seiten: Album,Tags,Suche)
Genutzte Variablen: $image

-->
<div class="three columns ph_border" style="margin:1.5%" align="center"> 
<?php
	//Erstellt den Foto-Pfad für die _GET Übertragung
	$encrypted = rawurlencode(base64_decode($image['photo_path']));   
	?>

<div class="out_of_thumb">
	<!-- Hier wird der Verschlüsselte Pfad genutzt um das Bild (image.php) einzubinden. -->
<a href="index.php?page=photo&path=<?=$encrypted?>"><img class="thumb_img" src="image.php?path=<?=$encrypted?>"></a>
</div>

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