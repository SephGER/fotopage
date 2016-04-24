<nav class="navbar">
 <div class="container">
 <ul class="navbar-list">
 <?php
if($_SESSION['login']){
	//Wenn eingeloggt Zeige den Avatar im Menü an
?>
<li class="navbar-item image">
<img class="image" src="image.php?path=<?=$_SESSION['user']['avatar']?>" style="max-width:50px;max-height:50px;margin-top:5px;margin-right:15px;border-width:1px;border-style:solid;border-radius:10px;padding:2px;float:left">
</li>
<?php
}
?>
<li class="navbar-item">
<a class="navbar-link" href="index.php">Home</a>
</li>
<?php
if($_SESSION['login']){
	//Menü nur anzeigen wenn eingeloggt.
?>
<li class="navbar-item">
<div class="dropdown">
<a class="navbar-upper-link dropbtn" >Sammlung <i class="fa fa-chevron-down"></i></a>
  <div class="dropdown-content">
    <a href="index.php?page=view&type=fotos">Fotos</a>
    <a href="index.php?page=view&type=tags">Tags</a>
	<a href="index.php?page=view&type=search">Suche</a>
  </div>
</div>
</li>
<li class="navbar-item">
<div class="dropdown">
<a class="navbar-upper-link dropbtn" ><?=htmlspecialchars($_SESSION['user']['user_name'])?>s Konto  <i class="fa fa-chevron-down"></i></a>
<div class="dropdown-content">
    <a href="index.php?page=konto">Einstellungen</a>
    <a href="logout.php">Logout</a>
  </div>
</div>
</li>
<li class="navbar-item upload" style="margin-top:15px;">
<a class="button button-primary" href="index.php?page=upload">Upload</a>
</li>
<li class="navbar-item search" style="margin-top:15px;float:right;" >
        <form action="index.php">

          <input type="hidden" name="page" value="view" /> 
          <input type="hidden" name="type" value="search" /> 
          <input placeholder="Name oder Tags" id="img_search" type="text" name="searched" /> 
          <input type="submit" value="Suchen" />
        </form>
</li>
<?php
}
?>

</ul>
</div>
 </nav>