<?php
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

$arreglo			= explode("-",$parametro);
$num_cachos			= count($arreglo);
if ($num_cachos>2) {
	$fol_parametro		= $arreglo[0]."-".$arreglo[1];
	$conse_parametro	= $arreglo[2];
} else {
	$fol_parametro		= $arreglo[0];
	$conse_parametro	= $arreglo[1];
}

$sql->query("select fol_orig,conse,fec_salid,fec_comp,remite,cve_urge,sintesis,cve_docto,fec_elab,base_datos,prop_base,dirigido,firmante,cargo_fmte,promotor,particular,expediente,tipo_docto,evento,to_char(fec_eve,'dd/mm/yyyy') as fec_eve,time_eve,nacional,domicilio,colonia,delegacion,codigo_post,entidad,telefono from soli_buzon where fol_orig='$fol_parametro' and conse='$conse_parametro'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$fol_orig			= $sql->f("fol_orig");
		$conse				= $sql->f("conse");
		$fec_salid			= $sql->f("fec_salid");
		$fec_comp			= $sql->f("fec_comp");
		$remite				= $sql->f("remite");
		$cve_urge			= $sql->f("cve_urge");
		$sintesis			= $sql->f("sintesis");
		$cve_docto			= $sql->f("cve_docto");
		$fec_elab			= $sql->f("fec_elab");
		$base_datos			= $sql->f("base_datos");
		$prop_base			= $sql->f("prop_base");
		$dirigido			= $sql->f("dirigido");
		$firmante			= $sql->f("firmante");
		$cargo_fmte			= $sql->f("cargo_fmte");
		$promotor			= $sql->f("promotor");
		$particular			= $sql->f("particular");
		$expediente			= $sql->f("expediente");
		$tipo_docto			= $sql->f("tipo_docto");
		$evento				= $sql->f("evento");
		$fec_eve			= $sql->f("fec_eve");
		$time_eve			= $sql->f("time_eve");
		$nacional			= $sql->f("nacional");
		$domicilio			= $sql->f("domicilio");
		$colonia			= $sql->f("colonia");
		$delegacion			= $sql->f("delegacion");
		$codigo_post		= $sql->f("codigo_post");
		$entidad			= $sql->f("entidad");
		$telefono			= $sql->f("telefono");
	}
	$sql->query("select clave from depe_buzon where tipo_reg='P' and base_datos='$base_datos' and upper(prop_base)='".strtoupper($prop_base)."'");
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$cve_remite = $sql->f("clave");
		}
		if ($cve_remite) {
			$sql->query("select nom_prom from promotor where cve_prom='$cve_remite'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$nom_remitente = $sql->f("nom_prom");
				}
			}
		}
	}
	if ($tipo_docto) {
		$tipo_docto_lower=$tipo_docto;
		$tipo_docto_upper=strtoupper($tipo_docto);
		$sql->query("select cve_ins from instruccion where tipo='D' and (upper(instruccion) like '$tipo_docto_upper' or instruccion like '$tipo_docto_lower')");
		if ($sql->num_rows($sql) == 1) {
			while($sql->next_record()) {
				$cve_tipo = $sql->f("0");
			}
		}
	}
	if ($evento) {
		$evento_lower=$evento;
		$evento_upper=strtoupper($evento);
		$sql->query("select cve_tema from tema where tipo='E' and (upper(topico) like '$evento_upper' or topico like '$evento_lower')");
		if ($sql->num_rows($sql) == 1) {
			while($sql->next_record()) {
				$cve_eve = $sql->f("0");
			}
		}
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
		'$sintesis',
		'$cve_expe',
		'$particular',
		'$comentarios',
		'$cve_segui',
		'$fol_parametro$conse_parametro',
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
			//$busca_ip_sql->disconnect($busca_ip_sql->Link_ID);
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
		}
		/*FIN DE AVISO A ORIGEN*/

		/*BORRA SOLI_BUZON EN RECEPTOR*/
		$sql = new scg_DB; // para reconectarse a la base de datos que está recibiendo
		$borra="delete from soli_buzon where fol_orig='$fol_parametro' and conse='$conse_parametro' and base_datos='$base_datos' and prop_base='$prop_base'";
		$resulta = $sql->query($borra);
		if (!$resulta) {
			printf("<br>¡ Error en el query o con la base de datos !\n");
		}
		//$sql->disconnect($sql->Link_ID);
		/*FIN BORRAR SOLI_BUZON EN RECEPTOR*/
	}
	if ($default->scg_tipo_turnos_captura=="1" && $salida==0) {
		$fol_parametro=$fol_orig_paponer;
		$viene_de="recibir_documento_de_buzon";
		echo "<font class='bigsubtitle'>El documento No. $fol_orig_paponer ha sido registrado.</font>";
		include("turno.php");
		include("./includes/footer.inc");
	} else {
		header("Location: principal.php?sess=$sess&control_botones_superior=7&folio_capturado=$fol_orig_paponer");
	}
} else {
	if ($default->scg_tipo_turnos_captura=="1") {
		echo "<font class='bigsubtitle'>ERROR: El folio No. $fol_orig_paponer ya ha sido registrado.</font>\n";
		echo "<br>\n";
		echo "<br>\n";
		echo "<input type='button' value='Regresar' onClick='javascript: history.go(-1);'>\n";
		include("./includes/footer.inc");
	}
}
?>
