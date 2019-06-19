<?php
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
if ($fec_regi=="") {
	$fec_regi = $fecha_now;
}
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario 		= $sql->f("usuario");
	}
}
$sql->query("select cve_prom,cve_remite,confi from documento where fol_orig='$fol_orig';");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$cve_prom		= $sql->f("cve_prom");
		$cve_remite	= $sql->f("cve_remite");
		$confi			= $sql->f("confi");
	}
}

$sql->query("select cve_resp from docsal where fol_orig='$fol_orig' and conse='$conse_fijo'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$cve_resp		= $sql->f("cve_resp");
	}
}
if ($cve_resp<>'S' and $cve_urge<>'') $cve_resp='N';
if ($cve_urge=='') $cve_resp=' ';
$actualizar_turno="UPDATE docsal set
fec_salid=to_timestamp('$fec_regi $hora_now','dd/mm/yyyy hh24:mi'),";
if ($fec_comp!="") {
	$actualizar_turno.="fec_comp=to_date('$fec_comp','dd/mm/yyyy'),";
}
$actualizar_turno.="cve_turn='$cve_turn',
cve_depe='$cve_depe',
coment='$coment',
cve_urge='$cve_urge',
cve_prom='$cve_prom',
cve_remite='$cve_remite',
cve_ins='$cve_ins',
confi='$confi',
especial='$especial',
modi_sal='$id_usuario',
cve_resp='$cve_resp'

where
fol_orig='$fol_orig'
and conse='$conse_fijo'";

echo $actualizar_turno."<br>";
$resulta = $sql->query($actualizar_turno);
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
} else {
	$resulta = $sql->query("update documento set cve_segui='1' where fol_orig='$fol_orig'");
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
	}

	$resulta = $sql->query("DELETE from salccp where fol_orig='$fol_orig' and conse='$conse_fijo'");
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
	}

	$cuantas_copias=0;
	$cuantas_copias=count($nom_ccp); //primero se cuentan el número de selecciones realizadas en el SELECT
	if ($cuantas_copias!=0) {
		$n=0;
		$cadena_insertar="";
		$particula="";
		while ($n<$cuantas_copias) {
			$sql2 = new scg_DB;
			$sql2->query("select cve_depe,titulo_titu,nom_titu from dependencia where cve_depe='$nom_ccp[$n]'");
			if ($sql2->num_rows($sql2) > 0) {
				if ($sql2->next_record()) {
					$cve_depe			= $sql2->f("cve_depe");
					$titulo_titu	= $sql2->f("titulo_titu");
					$nom_titu			= $sql2->f("nom_titu");
					$particula="[000";
					if ($titulo_titu!="") {
						$particula.="$titulo_titu ";
					}
					$particula.="$nom_titu]";
					$particula.="[$cve_depe]";
					$cadena_insertar.=$particula;
				}
			}
			$n++;
		}
		$resulta = $sql->query("INSERT into salccp values ('$fol_orig','$conse_fijo','$cadena_insertar')");
		if (!$resulta) {
			printf("<br>¡ Error en el query o con la base de datos !\n");
		}
	}
}
//$sql->disconnect($sql->Link_ID);
header("Location: turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_orig&conse_parametro=$conse_fijo&control_botones_superior=1&folio_actualizado=$fol_orig");
?>