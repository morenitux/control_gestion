<?php
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
if ($fec_regi=="") {
	$fec_regi = $fecha_now;
}
if ($fec_recep=="") {
	$fec_recep = $fecha_now;
}
if ($hora_recep=="") {
	$hora_recep = $hora_now;
}
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}

if ($default->scg_tipo_folios=="1") { //folios manuales
//modificación a la captura de folios manuales enero2003
	$anio_pal_folio 	= chop(substr(date("Y"),2,2));
	$particula			= $anio_pal_folio."-";
	$fol_orig_paponer 	= chop($fol_orig_paponer);
	$largo				= strlen($fol_orig_paponer);
	if ($largo<6) {
		$cuanto=6-$largo;
		$ceros_antes="";
		for ($x=1; $y<$cuanto; $y++) {
			$ceros_antes.="0";
		}
		$fol_orig_paponer = $ceros_antes.$fol_orig_paponer;
	}
	if (substr($fol_orig_paponer,2,1)!="-") {
		$fol_orig_paponer=$particula.$fol_orig_paponer;
	}
} else { //folios automaticos
	$sql = new scg_DB;
	$sql->query("SELECT max(fol_sig) as folio_siguiente from folio");
	while($sql->next_record()) {
		$fol_orig_paponer = $sql->f("folio_siguiente");
	}
}


if ($salida!=1) 				{ $salida=0;   			}
if ($clasif!=1) 				{ $clasif=0;   			}
if ($nacional!=1)				{ $nacional=0; 			}
if ($confi!=1)					{ $confi=0;    			}
if ($cve_expe=="")				{ $cve_expe=0; 			}
if ($cve_eve=="0")				{ $cve_expe="";			}
if ($cve_dirigido=="0")			{ $cve_dirigido="";		}
$cve_docto=strtoupper($cve_docto);
$sql = new scg_DB;
$sql->query("select count(*) as preexistentes from documento where fol_orig='$fol_orig_paponer'");
while($sql->next_record()) {
	$preexistentes = $sql->f("preexistentes");
}
if ($preexistentes==0) {
	  $insertar="INSERT into documento (
		fol_orig,";
		if ($fec_regi!='') {
			$insertar.="fec_regi,";
		}
		if ($fec_recep!='') {
			$insertar.="fec_recep,";
		}
		$insertar.="cve_docto,";
		if ($fec_elab!='') {
			$insertar.="fec_elab,";
		}
		$insertar.="firmante,
		cve_prom,
		cve_remite,
		txt_resum,
		cve_expe,
		nom_suje,
		notas,
		cve_segui,
		cve_refe,
		cve_recep,
		usua_doc,
		cve_eve,";
		if ($fec_eve!='') {
			$insertar.="fec_eve,";
		}
		if ($hora_evento!='') {
			$insertar.="time_eve,";
		}
		$insertar.="cve_tipo,
		confi,
		modifica,
		cve_dirigido,
		cargo_fmte,
		nacional,
		domicilio,
		colonia,
		delegacion,
		codigo_post,
		entidad,
		telefono,
		clasif,
		antecedente,";
		if ($fec_comp!='') {
			$insertar.="fec_comp,";
		}
		$insertar.="salida)
		values (
		'$fol_orig_paponer',";
		if ($fec_regi!='') {
			$insertar.="to_date('$fec_regi','dd/mm/yyyy'),";
		}
		if ($fec_recep!='') {
			if ($hora_recep!='') {
				$insertar.="to_timestamp('$fec_recep $hora_recep','dd/mm/yyyy HH24:mi'),";
			} else {
				$insertar.="to_date('$fec_recep','dd/mm/yyyy'),";
			}
		}
		$insertar.="'$cve_docto',";
		if ($fec_elab!='') {
			$insertar.="'$fec_elab',";
		}
		$insertar.="'$firmante',
		'$cve_prom',
		'$cve_remite',
		'$txt_resum',
		'$cve_expe',
		'$nom_suje',
		'$comentarios',
		'$cve_segui',
		'$folio_en_origen$conse_en_origen',
		'$cve_recep',
		'$id_usuario',
		'$cve_evento',";
		if ($fec_eve!='') {
			$insertar.="to_date('$fec_eve','dd/mm/yyyy'),";
		}
		if ($hora_evento!='') {
			//$insertar.="to_timestamp('$hora_evento','HH24:mi'),"; //UTILIZAR ESTA LINEA SI EL CAMPO FUE CREADO COMO "time"
			$insertar.="'$hora_evento',"; //UTILIZAR ESTA LINEA SI EL CAMPO FUE CREADO COMO "time without time zone"
		}
		$insertar.="'$cve_tipo',
		'$confi',
		'',
		'$cve_dirigido',
		'$cargo_fmte',
		'$nacional',
		'$domicilio',
		'$colonia',
		'$delegacion',
		'$codigo_post',
		'$entidad',
		'$telefono',
		'$clasif',
		'$antecedente',";
		if ($fec_comp!='') {
			$insertar.="to_date('$fec_comp','dd/mm/yyyy'),";
		}
		$insertar.="'$salida')
		";
	//echo "$insertar<br>";
	$resulta = $sql->query($insertar);
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
	} else {
		/*AQUI INICIA LA SECCION DEL INSERT MULTIPLE */
		$cuantos_temas=0;
		$cuantos_temas=count($cve_tema); //primero se cuentan el número de selecciones realizadas en el SELECT
		if ($cuantos_temas!=0) {
			$n=0;
			while ($n<$cuantos_temas) {
				$resulta = $sql->query("INSERT into doctem values ('$fol_orig_paponer','$cve_tema[$n]')");
				if (!$resulta) {
					printf("<br>¡ Error en el query o con la base de datos !\n");
				}
				$n++;
			}
		}
		/*FIN SECCION DEL INSERT MULTIPLE */

		/*AQUI SE ACTUALIZA EL ULTIMO_FOLIO EN LA SESION*/
		$actualiza="update sesion_activa set ultimo_folio='$fol_orig_paponer' where sess_id='$sess'";
		$resulta = $sql->query($actualiza);
		if (!$resulta) {
			printf("<br>¡ Error en el query o con la base de datos !\n");
		}
		/*FIN ACTUALIZA EL ULTIMO_FOLIO EN LA SESION*/

		/*AQUI SE ACTUALIZA EL CONTADOR */
		if ($default->scg_tipo_folios!="1") { //folios automáticos
			$largo			= strlen($fol_orig_paponer);
			$numero_buscado	= $largo;
			$i				= $largo-1;
			$hasta_aqui		= false;
			while ($i>=0 && !$hasta_aqui) {
				$letra		= substr($fol_orig_paponer,$i,1);
				$prueba		= ereg ("[0-9]", $letra);
				if ($prueba!=1) {
					$hasta_aqui		= true;
					$numero_buscado	= $i+1;
				}
				$i--;
			}
			$particula_fija		= substr($fol_orig_paponer,0,$numero_buscado);
			$particula_variable	= substr($fol_orig_paponer,$numero_buscado,($largo-$numero_buscado));
			$largo_variable		= strlen($particula_variable);
			$limite				= str_repeat("9", $largo_variable);
			$limite				= ($limite+1)-1;
			$particula_variable	= $particula_variable+1;
			$particula_variable	= str_pad($particula_variable, $largo_variable, "0", STR_PAD_LEFT);
			if ($particular_variable>$limite) {
				printf("<br>¡ Atención. Se ha alcanzado el limite de folios. No podrá seguir registrándo más documentos. !\n");
			}
			$fol_sig			= $particula_fija.$particula_variable;
			$resulta = $sql->query("UPDATE folio set fol_sig='$fol_sig'");
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
			/*FIN ACTUALIZACION CONTADOR */
		}



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
			$sql->Host		= "$ip";
			$sql->Database	= "$base_datos";
			$sql->query("SELECT tableName from pg_tables where upper(tableName)='DOCSAL'"); //checa si existe la tabla DOCSAL
			if ($sql->num_rows($sql) > 0) {
				$avisa_a_origen = "update docsal set fec_recdp=to_timestamp('$fecha_now $hora_now','dd/mm/yyyy HH24:mi') where fol_orig='$folio_en_origen' and conse='$conse_en_origen'";
				//echo "$avisa_a_origen<br>";
				$resulta = $sql->query($avisa_a_origen);
				if (!$resulta) {
					printf("<br>¡ Error en el query o con la base de datos !\n");
				}
			}
		}
		/*FIN DE AVISO A ORIGEN*/
	}
	if ($default->scg_tipo_turnos_captura=="1" && $salida==0) {
		require("./includes/readhd.php");
		$titulo_en_header = $default->scg_title_in_header;
		$windowname = "Principal";
		include("./includes/header.inc");
		$fol_parametro=$fol_orig_paponer;
		$viene_de="recibir_documento_de_buzon";
		echo "<font class='bigsubtitle'>El documento No. $fol_orig_paponer ha sido registrado.</font>";
		include("turno.php");
		include("./includes/footer.inc");
	} else {
		header("Location: principal.php?sess=$sess&control_botones_superior=1&folio_capturado=$fol_orig_paponer");
	}
} else {
	if ($default->scg_tipo_turnos_captura=="1") {
		require("./includes/readhd.php");
		$titulo_en_header = $default->scg_title_in_header;
		$windowname = "Principal";
		include("./includes/header.inc");
		echo "<font class='bigsubtitle'>ERROR: El folio No. $fol_orig_paponer ya ha sido registrado.</font>\n";
		echo "<br>\n";
		echo "<br>\n";
		echo "<input type='button' value='Regresar' onClick='javascript: history.go(-1);'>\n";
		include("./includes/footer.inc");
	}
}
?>
