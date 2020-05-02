<?php

require_once 'login.inc.php';

if (isset($_POST['reg_username']) && isset($_POST['reg_password'])) {
	$userq->bindValue(':name', $_POST['reg_username']);
	$res = $userq->execute();

	if ($res === false || $res->fetchArray() === false) {
		$q = $db->prepare("INSERT INTO user (name, password) VALUES (:name, :password)");
		$q->bindValue(':name', $_POST['reg_username']);
		$q->bindValue(':password', password_hash($_POST['reg_password'], PASSWORD_DEFAULT));
		if ($q->execute()) {
			$res->finalize();
			$userq->bindValue(':name', $_POST['reg_username']);
			$res = $userq->execute();
			$row = $res->fetchArray();
			$_SESSION['cs4g_user_id'] = $row['id'];
			header('Location: ./');
			exit('¡Registro exitoso!<a href="./">Seguir</a>');
		}
		else $login_error = "Hrm,algo pasó. ¡Inténtalo de nuevo! (".$db->lastErrorMsg().")";
	} else {
		$login_error = "Alguien ya tiene ese nombre de usuario...";
	}
}

include 'header.inc.php';

?>

<h3>Registrarse</h3>

<p>Las cuentas de usuario solo se utilizan para rastrear su progreso a través de los niveles. Tenga en cuenta que Netsim todavía está en <strong> beta </strong>, por lo que es posible que necesitemos restablecer la base de datos de usuarios de vez en cuando.</p>

<?=(isset($login_error) ? "<p>".$login_error."</p>\n" : "")?>

<form method="post" action="register.php" onsubmit="if (document.getElementById('reg_password').value == document.getElementById('confirm_password').value) return true; else { alert('Passwords don\'t match!'); return false; }">
	<p>Nombre de usuario<br>
	<input type="text" name="reg_username"></p>
	<p>Contraseña:<br>
	<input type="password" name="reg_password" id="reg_password"></p>
	<p>Confirmar contraseña:<br>
	<input type="password" id="confirm_password"></p>
	<p><input type="submit" value="Register"></p>
</form>

<div style="height:150px;"></div>

<script type="text/javascript">$('.reg_username').focus();</script>

<?php include 'footer.inc.php'; ?>
