<?php
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
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

if ($salida!=1) 				{ $salida=0;   			}
if ($clasif!=1) 				{ $clasif=0;   			}
if ($nacional!=1)				{ $nacional=0; 			}
if ($confi!=1)					{ $confi=0;    			}
if ($cve_expe=="")			{ $cve_expe=0; 			}
if ($cve_eve=="0")			{ $cve_expe="";			}
if ($cve_dirigido=="0")	{ $cve_dirigido="";	}
$cve_docto=strtoupper($cve_docto);
$sql->query("select count(*) as preexistentes from documento where fol_orig='$fol_orig'");
while($sql->next_record()) {
	$preexistentes = $sql->f("preexistentes");
}
if ($preexistentes==1) {
	  $actualizar="UPDATE documento set ";
		if ($fec_recep!='') {
			if ($hora_recep!='') {
				$actualizar.="fec_recep=to_timestamp('$fec_recep $hora_recep','dd/mm/yyyy HH24:mi'),";
			} else {
				$actualizar.="fec_recep=to_date('$fec_recep','dd/mm/yyyy'),";
			}
		}
		$actualizar.="cve_docto='$cve_docto',";
		if ($fec_elab!='') {
			$actualizar.="fec_elab=to_date('$fec_elab','dd/mm/yyyy'),";
		}
		$actualizar.="firmante='$firmante',
		cve_prom='$cve_prom',
		cve_remite='$cve_remite',
		txt_resum='$txt_resum',
		cve_expe='$cve_expe',
		nom_suje='$nom_suje',
		notas='$comentarios',
		cve_refe='$cve_refe',
		cve_recep='$cve_recep',
		cve_eve='$cve_evento',";
		if ($fec_eve!='') {
			$actualizar.="fec_eve=to_date('$fec_eve','dd/mm/yyyy'),";
		} else {
			$actualizar.="fec_eve=null,";
		}
		if ($hora_evento!='') {
			//$actualizar.="time_eve=to_timestamp('$hora_evento','HH24:mi'),"; //UTILIZAR ESTA LINEA SI EL CAMPO FUE CREADO COMO "time"
			$actualizar.="time_eve='$hora_evento',"; //UTILIZAR ESTA LINEA SI EL CAMPO FUE CREADO COMO "time without time zone"
		} else {
			$actualizar.="time_eve=null,";
		}
		$actualizar.="cve_tipo='$cve_tipo',
		confi='$confi',
		modifica='$id_usuario',
		cve_dirigido='$cve_dirigido',
		cargo_fmte='$cargo_fmte',
		nacional='$nacional',
		domicilio='$domicilio',
		colonia='$colonia',
		delegacion='$delegacion',
		codigo_post='$codigo_post',
		entidad='$entidad',
		telefono='$telefono',
		clasif='$clasif',
		antecedente='$antecedente',";
		if ($fec_comp!='') {
			$actualizar.="fec_comp=to_date('$fec_comp','dd/mm/yyyy'),";
		}
		$actualizar.="salida='$salida'
		where
		fol_orig='$fol_orig'";
		$resulta = $sql->query($actualizar);
		if (!$resulta) {
			//printf("<br>¡ Error en el query o con la base de datos !\n");
		} else {
			/*PRIMERO BORRO LOS TEMAS REGISTRADOS */
			$resulta = $sql->query("DELETE from doctem where fol_orig='$fol_orig'");
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
			/*FIN BORRAR LOS TEMAS REGISTRADOS */

			/*AQUI INICIA LA SECCION DEL INSERT MULTIPLE */
			$cuantos_temas=0;
			$cuantos_temas=count($cve_tema); //primero se cuentan el número de selecciones realizadas en el SELECT
			if ($cuantos_temas!=0) {
				$n=0;
				while ($n<$cuantos_temas) {
					$resulta = $sql->query("INSERT into doctem values ('$fol_orig','$cve_tema[$n]')");
					if (!$resulta) {
						printf("<br>¡ Error en el query o con la base de datos !\n");
					}
					$n++;
				}
			}
			/*FIN SECCION DEL INSERT MULTIPLE */
		}
		header("Location: listados.php?sess=$sess&control_botones_superior=1&folio_actualizado=$fol_orig&variable=detalle_documento&parametro=$fol_orig");
} else {
	if ($default->scg_tipo_turnos_captura=="1") {
		require("./includes/readhd.php");
		$titulo_en_header = $default->scg_title_in_header;
		$windowname = "Principal";
		include("./includes/header.inc");
		echo "<font class='bigsubtitle'>ERROR: El folio No. $fol_orig no existe.</font>\n";
		echo "<br>\n";
		echo "<br>\n";
		echo "<input type='button' value='Regresar' onClick='javascript: history.go(-1);'>\n";
		include("./includes/footer.inc");
	}
}
//$sql->disconnect($sql->Link_ID);
?>
