<?php
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$sql = new scg_DB;
$query.="update sesion_activa set ultimo_folio='$parametro' where sess_id='$sess'";
//echo $query."<br>";
$resulta = $sql->query($query);
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
}
header("Location: principal.php?sess=$sess&control_botones_superior=1&fol_parametro=");
?>