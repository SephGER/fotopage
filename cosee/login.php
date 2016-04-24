<?php
/*
@auhtor: Philip Seitz

Login-Seite.

*/
if (isset($_SESSION['login'])) {
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/internal/cosee/index.php');
} else {
	if (!empty($_POST)) {
		if (
			empty($_POST['f']['username']) ||
			empty($_POST['f']['password'])
		) {
			$message['error'] = 'Es wurden nicht alle Felder ausgefüllt.';
		} else {
			$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
			if ($mysqli->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
			} else {
				$query = sprintf(
					"SELECT user_id,user_name, user_pwd, user_email FROM tbl_user WHERE user_name = '%s'",
					$mysqli->real_escape_string($_POST['f']['username'])
				);
				$result = $mysqli->query($query);
				if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					if (password_verify($_POST['f']['password'], $row['user_pwd'])) {
						session_start();
 
						$_SESSION = array(
							'login' => true,
							'user'  => array(
								'user_name'  => $row['user_name'],
								'user_id' => $row['user_id'],
								'email' => $row['user_email'],
								'avatar' => rawurlencode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, "passwort", "/home/philip/photo/users/".$row['user_name'].".png", MCRYPT_MODE_ECB))
							)
						);
						$message['success'] = 'Anmeldung erfolgreich, <a href="index.php">weiter zum Inhalt.';
						header('Location: http://' . $_SERVER['HTTP_HOST'] . '/internal/cosee/index.php');
					} else {
						$message['error'] = 'Das Kennwort ist nicht korrekt.';
					}
				} else {
					$message['error'] = 'Der Benutzer wurde nicht gefunden.';
				}
				$mysqli->close();
			}
		}
	} else {
		$message['notice'] = 'Geben Sie Ihre Zugangsdaten ein um sich anzumelden.<br />' .
			'Wenn Sie noch kein Konto haben, gehen Sie <a href="./index.php?page=register">zur Registrierung</a>.';
	}
}

$style="background:lightgray;border-radius:20px;padding:10px;";

?>
<div class="container" style="padding:1%;" align="center">
	<div class="row" style="margin-top:5px;">
<div class="one-full column" style="margin-top:10%;background:white;border-radius:20px;padding:20px">
		<h1>Meine Foto-Seite</h1>
		<form action="./index.php" method="post">
<?php if (isset($message['error'])): ?>
			<fieldset class="error" style="<?=$style?>"><legend style="<?=$style?>color:red">Fehler</legend><?php echo $message['error'] ?></fieldset>
<?php endif;
	if (isset($message['success'])): ?>
			<fieldset class="success" style="<?=$style?>"><legend style="<?=$style?>color:green">Erfolg</legend><?php echo $message['success'] ?></fieldset>
<?php endif;
	if (isset($message['notice'])): ?>
			<fieldset class="notice" style="<?=$style?>"><legend style="<?=$style?>color:black">Hinweis</legend><?php echo $message['notice'] ?></fieldset>
<?php endif; ?>
			<fieldset style="<?=$style?>">
				<legend style="<?=$style?>">Benutzerdaten</legend>
				<div><label for="username">Benutzername</label>
					<input type="text" name="f[username]" id="username"<?php 
					echo isset($_POST['f']['username']) ? ' value="' . htmlspecialchars($_POST['f']['username']) . '"' : '' ?> /></div>
				<div><label for="password">Kennnwort</label> <input type="password" name="f[password]" id="password" /></div>
			
				<div><input type="submit" name="submit" value="Anmelden" style="background:#CE0F0F;color:white" /></div>
			</fieldset>
		</form>
		</div>
		</div>
		</div>