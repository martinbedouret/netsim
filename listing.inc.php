<?php include 'header.inc.php'; ?>

<div style="float:right;"><input type="button" value="Cerrar sesión" onclick="location.href='./?logout'"></div>

<p>¡Bienvenido a Netsim! Si es la primera vez que juegas, te recomendamos que comiences desde el primer nivel a continuación y sigas avanzando.<p>

<p>Tenga en cuenta que este proyecto todavía está en <strong>beta</strong>. Si encuentra algún error, puede informarlo al mejor profe del Villada (mmmm...quién <a href="https://www.cboard.io/images/staff/martinbedouret.jpg">será?)</a>.</p>

<?php

$res = $db->query("SELECT * FROM category ORDER BY orderby");

while ($row = $res->fetchArray()) {
	echo "<h3 style=\"clear:both;;\">".$row['name']."</h3>\n";
	$res2 = $db->query("SELECT * FROM level WHERE category_id = ".$row['id']." ORDER BY orderby");
	while ($row2 = $res2->fetchArray()) {
		$complete = levelComplete($row2['id']);
		echo "<div style=\"float:left;position:relative;border-radius:0 0 10px 10px;border:solid 1px #AAA;margin:10px;padding:5px\">";
		echo "<a href=\"./?level=".$row2['id']."\">\n";
		echo "\t<img".($complete ? " style=\"opacity:0.3\"" : "")." src=\"includes/thumbs/".(file_exists("includes/thumbs/".$row2['id'].".png") ? $row2['id'] : 0).".png\">\n";
		if ($complete) echo "\t<img src=\"includes/thumbs/check.png\" style=\"position:absolute;top:80px;left:70px;\">\n";
		echo "</a><br>\n";
		echo "<a href=\"./?levels=".$row2['id']."\" style=\"color:#000;text-decoration:none;\">".$row2['name']."</a>\n";
		echo "</div>\n";
		//echo "[";
		//echo levelComplete($row2['id']) ? "X" : "&nbsp;";
		//echo "] <a href=\"./?level=".$row2['id']."\">".$row2['name']."</a><br>\n";
	}

	echo "<div style=\"clear:both;margin-bottom:30px;\"></div>";
}

function levelComplete($l) {
	global $db;
	$q = $db->query("SELECT * FROM solns WHERE user_id = ".$_SESSION['cs4g_user_id']." AND level_id = $l");
	$row = $q->fetchArray();
	return $row !== false && $row['completed'] == 1;
}



include 'footer.inc.php';

?>
