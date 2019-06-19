<?php
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
if ($fec_regi=="") {
	$fec_regi = $fecha_now;
}
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$arreglo				= explode("-",$parametro);
$num_cachos				= count($arreglo);
if ($num_cachos>2) {
	$fol_parametro		= $arreglo[0]."-".$arreglo[1];
	$conse_parametro	= $arreglo[2];
} else {
	$fol_parametro		= $arreglo[0];
	$conse_parametro	= $arreglo[1];
}
$sql = new scg_DB;
$resulta = $sql->query("delete from resp_buzon where fol_orig='$fol_parametro' and conse='$conse_parametro'");
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
}
header("Location: principal.php?sess=$sess&control_botones_superior=8&folio_capturado=");
?>
