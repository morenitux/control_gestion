<?php
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");

$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
if ($fec_regi=="") {
	$fec_regi = $fecha_now;
}

$sql = new scg_DB;
$sql->query("SELECT licencia from tbl_mensaje");
if ($sql->num_rows($sql) > 0) {
	if ($sql->next_record()) { //solo el primero
		$licencia = $sql->f("0");
	}
}
$bd_respuesta=$sql->Database;
$query = "SELECT upper(tableowner) from pg_tables where upper(tableName)='DOCUMENTO'";
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$pb_respuesta = $sql->f("0");
	}
}

if ($control!='1') {
	/*AVISO A SISTEMA ORIGEN*/
	if ($base_datos) {
		$busca_ip_sql = new scg_DB;
		$busca_ip_sql->Database="SSDF_MASTER";
		$busca_ip_sql->query("SELECT * from scg where base_datos='$base_datos'"); //checa si existe la tabla depe_buzon
		if ($busca_ip_sql->num_rows($busca_ip_sql) > 0) {
			while($busca_ip_sql->next_record()) {
				$ip	= $busca_ip_sql->f("ip");
			}
		}
		$sql = new scg_DB;
		$sql->Host		= "$ip";  // para conectarse a la base de datos que envió el documento
		$sql->Database	= "$base_datos"; // para conectarse a la base de datos que envió el documento
		$sql->query("SELECT tableName from pg_tables where upper(tableName)='DOCSAL'"); //checa si existe la tabla DOCSAL
		if ($sql->num_rows($sql) > 0) {
			$avisa_a_origen = "update docsal set fec_recdp=to_timestamp('$fecha_now $hora_now','dd/mm/yyyy HH24:mi') where fol_orig='$folio_en_origen' and conse='$conse_en_origen'";
			//echo "$avisa_a_origen<br>";
			$resulta = $sql->query($avisa_a_origen);
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
		}
		$sql->query("SELECT tableName from pg_tables where upper(tableName)='RESP_BUZON'"); //checa si existe la tabla resp_buzon
		if ($sql->num_rows($sql) > 0) {
			if (!$rechazo && $accion=="borrar") $rechazo="El registro fue eliminado del buzon destinatario";
			$inserta_respuesta = "insert into resp_buzon
			(fol_orig,
			conse,
			fec_salid,
			remite,
			cve_docto,
			fec_elab,
			sintesis,
			base_datos,
			prop_base,
			cve_resp)
			values
			('$folio_en_origen',
			'$conse_en_origen',
			to_timestamp('$fecha_now $hora_now','dd/mm/yyyy HH24:mi'),
			'$licencia',
			'S/N',
			to_date('$fecha_now','dd/mm/yyyy'),
			'$rechazo',
			'$bd_respuesta',
			'$pb_respuesta',
			'S')";
			//echo "$inserta_respuesta<br>";
			$resulta = $sql->query($inserta_respuesta);
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
		}
	}
	/*FIN DE AVISO A ORIGEN*/
}

/*BORRA SOLI_BUZON EN RECEPTOR*/
$sql = new scg_DB; // para reconectarse a la base de datos que está recibiendo
$borra="delete from soli_buzon where fol_orig='$folio_en_origen' and conse='$conse_en_origen' and base_datos='$base_datos' and prop_base='$prop_base'";
//echo "$borra<br>";
$resulta = $sql->query($borra);
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
}
/*FIN BORRAR SOLI_BUZON EN RECEPTOR*/
header("Location: principal.php?sess=$sess&control_botones_superior=7");
?>