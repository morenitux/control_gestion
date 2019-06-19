<?php
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$sql = new scg_DB;

$resulta = $sql->query("delete from privi_opcion where usuario='$usuario'");
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
} else {

	$insertArray = array();
	$i=0;

	if ($estdocumentos=="estdocumentos") {
		$insertArray[$i]="insert into privi_opcion values ('PBESTDOC','$usuario')";
		$i++;
	}

	if ($estturnos=="estturnos") {
		$insertArray[$i]="insert into privi_opcion values ('PBSEGEJEC','$usuario')";
		$i++;
	}

	if ($buzonsolicitudes=="buzonsolicitudes") {
		$insertArray[$i]="insert into privi_opcion values ('PBBUZONV','$usuario')";
		$i++;
	}

	if ($buzonrespuestas=="buzonrespuestas") {
		$insertArray[$i]="insert into privi_opcion values ('PBBUZONRESP','$usuario')";
		$i++;
	}

	if ($promotores=="promotores") {
		$insertArray[$i]="insert into privi_opcion values ('PBPROMO','$usuario')";
		$i++;
	}

	if ($expedientes=="expedientes") {
		$insertArray[$i]="insert into privi_opcion values ('PBEXPE','$usuario')";
		$i++;
	}

	if ($temas=="temas") {
		$insertArray[$i]="insert into privi_opcion values ('PBTEMA','$usuario')";
		$i++;
	}

	if ($eventos=="eventos") {
		$insertArray[$i]="insert into privi_opcion values ('PBEVENTO','$usuario')";
		$i++;
	}

	if ($dependencias=="dependencias") {
		$insertArray[$i]="insert into privi_opcion values ('PBDEPE','$usuario')";
		$i++;
	}

	if ($turnadores=="turnadores") {
		$insertArray[$i]="insert into privi_opcion values ('PBTURNA','$usuario')";
		$i++;
	}

	if ($instrucciones=="instrucciones") {
		$insertArray[$i]="insert into privi_opcion values ('PBINSTRU','$usuario')";
		$i++;
	}

	if ($tiposdocumento=="tiposdocumento") {
		$insertArray[$i]="insert into privi_opcion values ('PBTIPODOC','$usuario')";
		$i++;
	}

	if ($destinatarios=="destinatarios") {
		$insertArray[$i]="insert into privi_opcion values ('PBDIRIGE','$usuario')";
		$i++;
	}

	if ($controlusuarios=="controlusuarios" && !$cve_depe) {
		$insertArray[$i]="insert into privi_opcion values ('PBUSERS','$usuario')";
		$i++;
	}

	if ($onDocumentos==1) {
		$insertArray[$i]="insert into privi_opcion values ('PBSOLVOL','$usuario')";
		$i++;
	}

	if ($onDocumentos==2) {
		$insertArray[$i]="insert into privi_opcion values ('PBCONSUDOC','$usuario')";
		$i++;
	}

	if ($onDescargos==1) {
		$insertArray[$i]="insert into privi_opcion values ('PBRESP','$usuario')";
		$i++;
	}

	if ($onDescargos==2) {
		$insertArray[$i]="insert into privi_opcion values ('PBCONSURESP','$usuario')";
		$i++;
	}

	if ($cve_depe) {
		$insertArray[$i]="insert into privi_opcion values ('".$cve_depe."VISTA','$usuario')";
		$i++;
	}

	$errores = "NOP";

	for ($iCount=0; $iCount<count($insertArray); $iCount++) {
		$resultaInsert = $sql->query($insertArray[$iCount]);
		if (!$resultaInsert) {
			$errores = "SIP";
		}
	}

	//header("Location: principal.php?sess=$sess&control_botones_superior=10&variable=cambiaPrivilegios&parametro=$usuario");
	header("Location: principal.php?sess=$sess&control_botones_superior=10");
}
?>