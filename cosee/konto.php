<?php

/*
	@author: Philip Seitz
	
	Die Konto Seite.
	Todo: Änderung der Email erlauben. //Email wird jedoch noch nicht genutzt.
		
*/

//Ein bisschen mit Objekten herumprobiert. 
//Todo: In die Session direkt einbauen. (Eventuell $session->user->name oder so ?)
$user->Username=$_SESSION['user']['user_name'];
$user->Email=$_SESSION['user']['email'];
$user->Kontotyp="Free"; //Eventuell später mal
$wanted = array("Username","Email","Kontotyp");
$changable=array("Email");
?>
<div class="container" style="padding:1%;">
	<div class="row" style="margin-top:5px;">
		<div class="twelve columns head" style="padding:20px;margin-top:10%;margin-bottom:-4%;background-color:#fff;border-radius:20px;">
			<h1>Konto von <?=$user->Username?></h1>
		</div>
	</div>
	<div class="row" style="padding:3%;background-color:#fff;border-radius:20px;">
		<div class="six columns">
			<table>
			<?
				foreach($user as $key=>$value){
				 if(in_array($key,$wanted)){
			?>
			<tr>
				<td style="vartical-align: center">
				<label for="<?=$key?>Input"><?=$key?></label>
				</td>
				<td>
				<?php
					if(in_array($key,$changable)){
				?>
				<input class="u-full-width" placeholder="" id="<?=$key?>Input" type="email" value="<?=$value?>">
				<?php }else{ ?>
				<label id="<?=$key?>Input"><?=$value?></label>
				<?php } ?>
				</td>
			</tr>
			<?php }} ?>
			</table>
		<a class="button" title="Not Yet Implemented">Speichern</a>
		</div>
		<div class="six columns" align="right" style="padding-right:10%;padding-top:2%">
			<img src="image.php?path=<?=$_SESSION['user']['avatar']?>" style="max-width:150px;">
			<br \>
			<form action="index.php?page=upload&type=avatar" method="post">
				<input type="hidden" name="album_name" value="Avatar">
				<input type="submit" value="&Auml;ndern">
			</form>
		</div>
	</div>
</div>