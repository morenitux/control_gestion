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
		$id_usuario = $sql->f("usuario");
	}
}
if ($discriminador=="recepcion_directa_de_buzon") {
	//si viene de insertRespuestaDeBuzonDirecto.php
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
	$sql->query("select fol_orig from docsal where fol_orig='$fol_parametro'");
	$num_turnos = $sql->num_rows($sql);
	if ($num_turnos > 0) {
		$query="SELECT cve_remite,cve_refe from documento where fol_orig='$fol_parametro'";
		$sql = new scg_DB;
		$sql->query($query);
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$cve_remite		= $sql->f("cve_remite");
				$cve_refe		= $sql->f("cve_refe");
			}
		}
		$sql = new scg_DB;
		$sql->query("SELECT tableName from pg_tables where upper(tableName)='DEPE_BUZON'"); //checa si existe la tabla depe_buzon
		if ($sql->num_rows($sql) > 0) {
			//AQUI INICIA AHORA LA REVISION PARA VER SI EL AREA DESTINATARIA ESTA EN EL CATALOGO DE BUZONES
			$query="SELECT base_datos, prop_base from depe_buzon where clave='$cve_remite' and tipo_reg='P'";
			$sql = new scg_DB;
			$sql->query($query);
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$base_datos_padre	= $sql->f("base_datos");
				}
			}
		}
		$query="SELECT fol_orig,conse,remite,sintesis,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,base_datos,prop_base,folio_remite,conse_remite,plazo,viable,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,cve_resp,etapas,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,califresp,to_char(fec_compro,'dd/mm/yyyy') as fec_compro from resp_buzon where fol_orig is not null and fol_orig='$fol_parametro' and conse='$conse_parametro'";
		$sql = new scg_DB;
		$sql->query($query);
		$numero_renglones = $sql->num_rows($sql);
		if ($numero_renglones > 0) {
			while($sql->next_record()) {
				$folio_en_documentos = "";
				$fol_orig		= "";
				$conse			= "";
				$remite			= "";
				$sintesis		= "";
				$cve_docto_resp	= "";
				$fec_elab		= "";
				$base_datos		= "";
				$prop_base		= "";
				$folio_remite	= "";
				$conse_remite	= "";
				$plazo			= "";
				$viable			= "";
				$fec_notifica	= "";
				$cve_resp		= "";
				$etapas			= "";
				$fec_conclu		= "";
				$califresp		= "";
				$fec_compro		= "";
				$parametro		= "";

				$fol_orig		= $sql->f("fol_orig");
				$conse			= $sql->f("conse");
				$remite			= $sql->f("remite");
				$sintesis		= $sql->f("sintesis");
				$cve_docto_resp	= $sql->f("cve_docto");
				$fec_elab		= $sql->f("fec_elab");
				$base_datos		= $sql->f("base_datos");
				$prop_base		= $sql->f("prop_base");
				$folio_remite	= $sql->f("folio_remite");
				$conse_remite	= $sql->f("conse_remite");
				$plazo			= $sql->f("plazo");
				$viable			= $sql->f("viable");
				$fec_notifica	= $sql->f("fec_notifica");
				$cve_resp		= $sql->f("cve_resp");
				$etapas			= $sql->f("etapas");
				$fec_conclu		= $sql->f("fec_conclu");
				$califresp		= $sql->f("califresp");
				$fec_compro		= $sql->f("fec_compro");
				$parametro		= "$fol_orig-$conse";
			}
		}
	}
	$query="update docsal set
	cve_docto='$cve_docto_resp',
	txt_resp='$sintesis',
	cve_resp='$cve_resp',
	viable='$viable',
	califresp='$califresp',
	fec_regi=to_date('$fecha_now','dd/mm/yyyy'),";
} else {
	$query="update docsal set
	cve_docto='$cve_docto',
	txt_resp='$txt_resp',
	cve_resp='$cve_resp',
	viable='$viable',
	califresp='$califresp',
	fec_regi=to_date('$fecha_now','dd/mm/yyyy'),";
}
if ($fec_elab!="") {
	$query.="fec_elab=to_date('$fec_elab','dd/mm/yyyy'),";
}
if ($fec_recdp!="") {
	$query.="fec_recdp=to_date('$fec_recdp','dd/mm/yyyy'),";
}
if ($fec_comp!="") {
	$query.="fec_comp=to_date('$fec_comp','dd/mm/yyyy'),";
}
if ($fec_notifica!="") {
	$query.="fec_notifica=to_date('$fec_notifica','dd/mm/yyyy'),";
}
if ($fec_conclu!="") {
	$query.="fec_conclu=to_date('$fec_conclu','dd/mm/yyyy'),";
}
if ($viene_de=="buzon_respuestas") {
	$query.="fec_recdp=to_date('$fecha_now','dd/mm/yyyy'),";
}
if ($fec_conclu=="S") {
	$query.="usua_resp='$id_usuario' ";
} else {
	$query.="modi_resp='$id_usuario' ";
}
$query.="where
fol_orig='$fol_parametro' and
conse='$conse_parametro'";
//echo $query."<br>";
$resulta = $sql->query($query);
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
}
$texto_etapas="";
if ($numero_total_de_etapas>0) {
	for ($x=0; $x<$numero_total_de_etapas; $x++) {
		eval("\$oid = \"\$oid$x\";");
		eval("\$etapa = \"\$etapa$x\";");
		eval("\$porciento = \"\$porciento$x\";");
		eval("\$fecha = \"\$fecha$x\";");
		if ($oid!="") {
			$borrar="delete from etapas where folio='$fol_parametro' and conse='$conse_parametro' and oid='$oid'";
			//echo $borrar."<br>";
			$resulta = $sql->query($borrar);
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
		}
		if ($etapa!="") {
			$insertar="insert into etapas (folio,conse,etapa,porciento,";
			if ($fecha!="") {
				$insertar.="fecha,";
			}
			$largo_porciento=strlen($porciento);
			$ultimo_caracter=substr($porciento,$largo-1,1);
			if ($ultimo_caracter=="%") {
				$porciento=substr($porciento,0,$largo-1);
			}
			$insertar.="rowid) values ('$fol_parametro','$conse_parametro','$etapa',";
			if ($porciento=="") {
				$insertar.="null,";
			} else {
				$insertar.="'$porciento',";
			}
			if ($fecha!="") {
				$insertar.="to_date('$fecha','dd/mm/yyyy'),";
			}
			$insertar.="now())";
			//echo $insertar."<br>";
			$resulta = $sql->query($insertar);
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
			$dia_fecha	=	substr($fecha,0,2);
			$mes_fecha	=	substr($fecha,3,2);
			$anio_fecha	=	substr($fecha,6,4);
			$fecha_otro_formato		= "$anio_fecha-$mes_fecha-$dia_fecha";
			$texto_etapas.= $etapa."[".$porciento."[".$fecha_otro_formato."[]";
		}
	}
}
//echo "$viene_de y $borrar_buzon_directo<br>";
if ($viene_de=="buzon_respuestas" && $borrar_buzon_directo!="") {
	$resulta = $sql->query("delete from resp_buzon where fol_orig='$fol_parametro' and conse='$conse_parametro'");
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
	}
}
$query="SELECT licencia from tbl_mensaje";
$sql->query($query);
if ($sql->num_rows($sql) > 0) {
	if ($sql->next_record()) { // solo el primero
		$licencia	= $sql->f("licencia");
	}
}
$query="SELECT cve_remite,cve_refe from documento where fol_orig='$fol_parametro'";
$sql->query($query);
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$cve_remite		= $sql->f("cve_remite");
		$cve_refe		= $sql->f("cve_refe");
	}
}
$conse_refe = substr($cve_refe,(strlen($cve_refe)-2),2);
$fol_refe = substr($cve_refe,0,(strlen($cve_refe)-2));
$ultimo_del_folio = substr($fol_refe,(strlen($fol_refe)-1),1);
if ($ultimo_del_folio=='-') {
	$fol_refe = substr($fol_refe,0,(strlen($cve_refe)-1));
}

$base_datos_origen=$sql->Database;
$query = "SELECT upper(tableowner) from pg_tables where upper(tableName)='DOCUMENTO'";
$sql->query($query);
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$prop_base_origen = $sql->f("0");
	}
}
$sql->query("SELECT tableName from pg_tables where upper(tableName)='DEPE_BUZON'"); //checa si existe la tabla depe_buzon
if ($sql->num_rows($sql) > 0) {
	//AQUI INICIA AHORA LA REVISION PARA VER SI EL AREA DESTINATARIA ESTA EN EL CATALOGO DE BUZONES
	$query="SELECT base_datos, prop_base from depe_buzon where clave='$cve_remite' and tipo_reg='P'";
	$sql->query($query);
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$base_datos	= $sql->f("base_datos");
		}
	}
	//FIN DE LA REVISION
	if ($base_datos && $transmitir=='1') { //SI SE ENCONTRÓ EN depe_buzon
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
		$sql->query("SELECT tableName from pg_tables where upper(tableName)='RESP_BUZON'"); //checa si existe la tabla RESP_BUZON
		if ($sql->num_rows($sql) > 0) {
			$insertar_buzon = "INSERT into resp_buzon
			(fol_orig,
			conse,
			fec_salid,
			remite,
			cve_docto,";
			if ($fec_elab!="") {
				$insertar_buzon.="fec_elab,";
			}
			$insertar_buzon.="sintesis,
			base_datos,
			prop_base,
			folio_remite,
			conse_remite,
			plazo,";
			if ($fec_notifica!="") {
				$insertar_buzon.="fec_notifica,";
			}
			$insertar_buzon.="cve_resp,
			viable,
			etapas,";
			if ($fec_conclu!="") {
				$insertar_buzon.="fec_conclu,";
			}
			$insertar_buzon.="califresp";
			if ($fec_comp!="") {
				$insertar_buzon.=",fec_compro";
			}
			$insertar_buzon.=")
			values
			('$fol_refe',
			'$conse_refe' ,
			to_date($fecha_now,'dd/mm/yyyy'),
			'$licencia',
			'$cve_docto',";
			if ($fec_elab!="") {
				$insertar_buzon.="to_date('$fec_elab','dd/mm/yyyy'),";
			}
			$insertar_buzon.="'$txt_resp',
			'$base_datos_origen',
			'$prop_base_origen',
			'$fol_parametro',
			'$conse_parametro',
			'$plazo',";
			if ($fec_notifica!="") {
				$insertar_buzon.="to_date('$fec_notifica','dd/mm/yyyy'),";
			}
			$insertar_buzon.="'$cve_resp',
			'$viable',
			'$texto_etapas',";
			if ($fec_conclu!="") {
				$insertar_buzon.="to_date('$fec_conclu','dd/mm/yyyy'),";
			}
			$insertar_buzon.="'1'";
			if ($fec_comp!="") {
				$insertar_buzon.=",to_date('$fec_comp','dd/mm/yyyy')";
			}
			$insertar_buzon.=")";
			//print ($insertar_buzon);
			$resulta = $sql->query($insertar_buzon);
			if (!$resulta) {
				printf("<br>¡ Error en el query o con la base de datos !\n");
			}
			//INSERTA EN RESP_BUZON
		}
		$sql = new scg_DB; // para regresar a la base de datos de trabajo
		$resulta = $sql->query("update docsal set transresp='T', fec_envioresp=to_date('$fecha_now','dd/mm/yyyy') where fol_orig='$fol_parametro' and conse='$conse_parametro'");
		if (!$resulta) {
			printf("<br>¡ Error en el query o con la base de datos !\n");
		}
	}
}
$up_salida="S";
if ($viene_de=="buzon_respuestas") {
	header("Location: principal.php?sess=$sess&control_botones_superior=8&up_salida=S&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro&folio_capturado=");
} else {
	header("Location: principal.php?sess=$sess&control_botones_superior=2&up_salida=S&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro");
}
?>