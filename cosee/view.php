<!-- 
@author: Philip Seitz

Ruft die Bilder ab und zeigt eine Liste davon an.

Genutzte Variablen: $_GET['type']

Includes:			get_images.php
					album.php

-->

<?php

include('get_images.php');

?>
<div class="container" style="padding:1%;">
	<div class="row" style="margin-top:5px;">
        <div class="one-full column head" style="padding:20px;margin-top:10%;margin-bottom:-4%;background-color:#fff;border-radius:20px;">

		<?php
		/*Hier kommt die Überschrift.   
		Das ganze ist mit span-Tags und css gelöst. Der richtige Tag wird durch die Aufgerufene Seite erstellt (type = fotos,tags,search)
		(functions.php -> makeTypeArray)
		
		ToDo: Eventuell Funktion welche die Überschrift komplett dynamisch erzeugt?
		*/
		$active = makeTypeArray($_GET['type']);
		?>
        <h1 style="">
        <span class="<?=$active[1]?>">
          <a class="head" href="index.php?page=view&amp;type=fotos">Fotos</a>
        </span> | 
        <span class="<?=$active[2]?>">
          <a class="head" href="index.php?page=view&amp;type=tags">Tags</a>
        </span> | 
        <span class="<?=$active[3]?>">
          <a class="head" href="index.php?page=view&amp;type=search">Suche</a>
        </span></h1><?php
		/*
		Überschrift zu Ende.
		*/
		
         if($active[2] == "primary"){
        ?>
        <span style="font-size:22px;">
          <?=$searched_for?>
          </span> 
        <span style="margin-left:5px">Tag auswählen:</span>
        <form action="index.php">
          <span style="margin-left:5px">
          <input type="hidden" name="page" value="view" /> 
          <input type="hidden" name="type" value="tags" /> 
          <select class="u-half-width" id="exampleRecipientInput" style="min-width:200px;max-width:200px;" name="tag">
            <?php
                      foreach($tagses as $tag){
                      $selected = ($tag[1] == "true" ? "selected" : "" );
                    echo '<option '.$selected.' value="'.$tag[0].'">'.$tag[0].'</option>';
                            }
                  ?>
          </select> 
          <input type="submit" value="Anzeigen" class="button" /></span>
        </form><?php
        }else if($active[3] == "primary"){
        ?> 
        <span style="font-size:22px;">
          <?=$searched_for?>
          </span> 
        <span style="margin-left:5px">Suchen nach:</span>
        <form action="index.php">
          <span style="margin-left:5px">
          <input type="hidden" name="page" value="view" /> 
          <input type="hidden" name="type" value="search" /> 
          <input placeholder="Name oder Tags" id="img_search" type="text" name="searched" /> 
          <input type="submit" value="Suchen" /></span>
        </form><?php
        }
        else{
        ?> 
        <span style="font-size:22px;">
          <?=$searched_for?>
          </span> 
        <span style="margin-left:5px">Album anzeigen:</span>
        <form action="index.php">
          <span style="margin-left:5px">
          <input type="hidden" name="page" value="view" /> 
          <input type="hidden" name="type" value="fotos" /> 
          <select class="u-half-width" id="exampleRecipientInput" style="min-width:200px;max-width:200px;" name="album_name">
            <?php
                            foreach($albenliste as $album){
                            $selected = ($album[1] == "true" ? "selected" : "" );
                            echo "<option $selected value=\"".$album[0]."\">".$album[0]."</option>";
                            }
                            ?>
          </select> 
          <input type="submit" value="Anzeigen" class="button" /></span>
        </form><?php
        }
        ?>
		 <div class="row" style=" background: rgba(0, 0, 0, 0.4); padding:20px;border-radius:20px;margin-bottom:25px;margin-left:1px;margin-right:1px;">
      <?php

         foreach($user_images as $image){
                      $imgclass = "thumb";
                      include('album.php');
              }

      ?>
    </div>
		</div>
      </div>
    </div>
   
