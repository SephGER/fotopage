<?php
	$message = array();
	if (!empty($_POST)) {
		if (
			empty($_POST['f']['username']) ||
			empty($_POST['f']['password']) ||
			empty($_POST['f']['password_again'])
		) {
			$message['error'] = 'Es wurden nicht alle Felder ausgef&uuml;llt.';
		} else if ($_POST['f']['password'] != $_POST['f']['password_again']) {
			$message['error'] = 'Die eingegebenen Passw&ouml;rter stimmen nicht &uuml;berein.';
		} else {
			unset($_POST['f']['password_again']);
			$salt = ''; 
			for ($i = 0; $i < 22; $i++) { 
				$salt .= substr('./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', mt_rand(0, 63), 1); 
			}
			$_POST['f']['password'] = password_hash(
				$_POST['f']['password'],
				PASSWORD_DEFAULT
			);
 
			$mysqli = @new mysqli('localhost', 'cosee', 'cosee', 'cosee_photo');
			if ($mysqli->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
			}
			$query = sprintf(
				"INSERT INTO tbl_user (user_name, user_pwd)
				SELECT * FROM (SELECT '%s', '%s') as new_user
				WHERE NOT EXISTS (
					SELECT user_name FROM tbl_user WHERE user_name = '%s'
				) LIMIT 1;",
				$mysqli->real_escape_string($_POST['f']['username']),
				$mysqli->real_escape_string($_POST['f']['password']),
				$mysqli->real_escape_string($_POST['f']['username'])
			);
			$mysqli->query($query);
			if ($mysqli->affected_rows == 1) {
				$message['success'] = 'Neuer Benutzer (' . htmlspecialchars($_POST['f']['username']) . ') wurde angelegt, <a href="index.php">weiter zur Anmeldung</a>.';
				header('Location: http://' . $_SERVER['HTTP_HOST'] . '/internal/cosee/index.php');
			} else {
				$message['error'] = 'Der Benutzername ist bereits vergeben.';
			}
			$mysqli->close();
		}
	} else {
		$message['notice'] = "&Uuml;bermitteln Sie das ausgef&uuml;llte Formular um ein neues Benutzerkonto zu erstellen.";
	}
	$style="background:lightgray;border-radius:20px;padding:10px;";
?>

<div class="container" style="padding:1%;" align="center">
	<div class="row" style="margin-top:5px;">
<div class="one-full column" style="margin-top:10%;background:white;border-radius:20px;padding:20px">
			<h1>Registrierung</h1>
		<form action="./index.php?page=register" method="post">
<?php if (isset($message['error'])): ?>
			<fieldset class="error" style="<?=$style?>"><legend style="<?=$style?>">Fehler</legend><?php echo $message['error'] ?></fieldset>
<?php endif;
	if (isset($message['success'])): ?>
			<fieldset class="success" style="<?=$style?>"><legend style="<?=$style?>">Erfolg</legend><?php echo $message['success'] ?></fieldset>
<?php endif;
	if (isset($message['notice'])): ?>
			<fieldset class="notice" style="<?=$style?>"><legend style="<?=$style?>">Hinweis</legend><?php echo $message['notice'] ?></fieldset>
<?php endif; ?>
			<fieldset style="<?=$style?>">
				<legend style="<?=$style?>">Benutzerdaten</legend>
				<div><label for="username">Benutzername</label> <input type="text" name="f[username]" id="username"<?php echo isset($_POST['f']['username']) ? ' value="' . htmlspecialchars($_POST['f']['username']) . '"' : '' ?> /></div>
				<div><label for="password">Kennwort</label> <input type="password" name="f[password]" id="password" /></div>
				<div><label for="password_again">Kennwort wiederholen</label> <input type="password" name="f[password_again]" id="password_again" /></div>
				<div><input type="submit" name="submit" value="Registrieren" style="background:#CE0F0F;color:white" /></div>
			</fieldset>
		</form>
		</div>
		</div>
		</div>