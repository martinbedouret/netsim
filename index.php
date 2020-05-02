<?php

require_once 'login.inc.php';

if (LOGGEDIN && !isset($_GET['level'])) {
	include 'listing.inc.php';
	exit();
} else if (LOGGEDIN) {
	$l = (int)$_GET['level'];
	$q = $db->query("SELECT * FROM level WHERE id = ".$l);
	$leveldata = $q->fetchArray();
	if (!$leveldata) {
		include 'header.inc.php';
		?>
		<div style="text-align:center; min-height:100%;">
<h3> ¡Felicitaciones! </h3>
<p> ¡Has vencido el último nivel del juego! </p>
			<p><img src="./includes/fireworks.gif"></p>

			<p> Es posible que desee <a href="./"> revisar los niveles </a> para asegurarse de no perderse ninguno. </p>

			<p>De lo contrario, date una palmadita en la espalda! Eres un verdadero hacker ahora!</p>

			<div style="height:150px;"></div>
		</div>
		<?php
		include 'footer.inc.php';
		exit();
	}
} else {
	$leveldata = array('id' => -1, 'filename' => 'login/login', 'name' => 'CS4G Netsim');
}

?><!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="UTF-8" />
	<title>ITS Villada Simulador</title>
	
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/phaser.min.js"></script>
	<script src="js/ui.js"></script>
	<script src="js/bindings.js"></script>
	<script src="js/devicescripts.js"></script>

	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<style type="text/css">
		* { font-family:Arial, Helvetica, sans-serif; }
		body { margin: 0; overflow:hidden; }
	</style>
</head>
<body>

<script type="text/javascript">
<?php include 'phaser.inc.php'; ?>
</script>

<div id="game" style="float:left"></div>

<div id="pane" style="position:absolute;padding:20px;overflow:auto;">
	<h1><?=$leveldata['name']?></h1>

<?php if (LOGGEDIN) { ?>
	<input type="button" value="Level list" onclick="location.href='./'">
<?php } ?>

	<div id="leveldescrip" style="overflow:auto;">
	<?php include 'levels/'.$leveldata['filename'].'.html'; ?>
	</div>

	<input type="button" id="subpane_close" style="display:none" value="Level info" onclick="onSubpaneClose()">
	<div id="subpane" style="display:none"></div>
</div>

<div id="editor" style="display:none;">
	Enviado desde:
	<select id="pktFrom">
		<option>Alice</option>
		<option>Bob</option>
		<option>Carol</option>
	</select><br>
	<fieldset>
		<legend>Capa de red</legend>
		srcip: <input type="text" id="srcip"></input><br>
		dstip: <input type="text" id="dstip"></input>
	</fieldset>
	<fieldset>
		<legend>Capa de transporte</legend>
		payload: <input type="text" id="payload"></input><br>
		proto: <input type="text" id="other"></input>
	</fieldset>
</div>

<div id="winner" style="display:none;">
	<p>¡Has ganado el nivel! ¡Felicidades!</p>
</div>

<div id="footer" style="position:absolute;bottom:0.5em;right:0.5em;font-size:0.5em">
	created by 
	<a href="https://erinn.io/">erinn atwater</a> and
	<a href="https://cs.uwaterloo.ca/~cbocovic">cecylia bocovich</a> | 
	device images designed by 
	<a href="http://www.flaticon.com/authors/madebyoliver">madebyoliver</a> from Flaticon
</div>

<div id="loading" style="position:absolute;top:0;left:0;right:0;bottom:0;background-color:#DDD;color:#222;text-align:center">
	<h2>Netsim</h3>
	<p>Cargando...<p>
</div>

</body>
</html>
