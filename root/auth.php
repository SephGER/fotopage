<?php
	// Session Magic.
	session_start();
	session_regenerate_id();
 
    if ($page == "register"){
	}else
	if (empty($_SESSION['login'])) {
		$page = 'login';
	} else {
		$login_status = '
			<div style="border: 1px solid black;border-radius:5px;padding:2px;">
				Willkommen <strong>' . htmlspecialchars($_SESSION['user']['user_name']) . '</strong>
			</div>
		';
	}
?>