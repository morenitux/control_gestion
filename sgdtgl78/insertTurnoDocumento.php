<?php
if ($cve_urge) { $cve_resp='N'; } else { $cve_resp=''; }
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
$fol_orig = chop($fol_orig);
$max_conse="";
$sql = new scg_DB;
$sql->query("select max(conse) from docsal where fol_orig='$fol_orig'");
if ($sql->next_record()) {
	$max_conse = $sql->f("0")*1;
}
if ($max_conse=="") $max_conse=0;
$siguiente=$max_conse+1;
$largo=strlen($siguiente);
if ($largo==1) {
	$siguiente="0".$siguiente;
}
$sql = new scg_DB;
$sql->query("select cve_prom,cve_remite,confi,txt_resum from documento where fol_orig='$fol_orig';");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$cve_prom		= $sql->f("cve_prom");
		$cve_remite		= $sql->f("cve_remite");
		$confi			= $sql->f("confi");
		$txt_resum		= $sql->f("txt_resum");
	}
}
$insertar_turno="INSERT into docsal
(fol_orig,
conse,
fec_salid,";
if ($fec_comp!="") {
	$insertar_turno.="fec_comp,";
}
$insertar_turno.="cve_turn,
cve_depe,
coment,
cve_resp,
cve_urge,
cve_prom,
cve_remite,
cve_ins,
confi,
especial,
usua_sal,
transimp)
values
('$fol_orig',
'$siguiente',
to_timestamp('$fecha_now $hora_now','dd/mm/yyyy hh24:mi'),";
if ($fec_comp!="") {
	$insertar_turno.="to_date('$fec_comp','dd/mm/yyyy'),";
}
$insertar_turno.="'$cve_turn',
'$cve_depe',
'$coment',
'$cve_resp',
'$cve_urge',
'$cve_prom',
'$cve_remite',
'$cve_ins',
'$confi',
'$especial',
'$id_usuario',
'F')";
$sql = new scg_DB;
$resulta = $sql->query($insertar_turno);
if (!$resulta) {
	printf("<br>¡ Error en el query o con la base de datos !\n");
} else {
	$sql = new scg_DB;
	$resulta = $sql->query("update documento set cve_segui='1' where fol_orig='$fol_orig'");
	if (!$resulta) {
		printf("<br>¡ Error en el query o con la base de datos !\n");
	}
	$cuantas_copias=0;
	$cuantas_copias=count($nom_ccp); //primero se cuentan el número de selecciones realizadas en el SELECT
	if ($cuantas_copias!=0) {
		$n=0;
		$cadena_insertar="";
		$cadena_para_buzon="";
		$particula="";
		$particula2="";
		while ($n<$cuantas_copias) {
			$sql2 = new scg_DB;
			$sql2->query("select cve_depe,titulo_titu,nom_titu from dependencia where cve_depe='$nom_ccp[$n]'");
			if ($sql2->num_rows($sql2) > 0) {
				if ($sql2->next_record()) {
					$cve_depe_ccp		= $sql2->f("cve_depe");
					$titulo_titu_ccp	= $sql2->f("titulo_titu");
					$nom_titu_ccp		= $sql2->f("nom_titu");
					$particula="[000";
					if ($titulo_titu_ccp!="") {
						$particula.="$titulo_titu_ccp ";
						$particula2.="$titulo_titu_ccp ";
					}
					$particula2.="$nom_titu_ccp, ";
					$cadena_para_buzon.=$particula2;
					$particula2="";

					$particula.="$nom_titu_ccp]";
					$particula.="[$cve_depe_ccp]";
					$cadena_insertar.=$particula;
					$particula="";
				}
			}
			$n++;
			//$sql2->disconnect($sql2->Link_ID);
		}
		$sql = new scg_DB;
		$resulta = $sql->query("INSERT into salccp values ('$fol_orig','$siguiente','$cadena_insertar')");
		if (!$resulta) {
			printf("<br>¡ Error en el query o con la base de datos !\n");
		}
	}
	$sql = new scg_DB;
	$query="SELECT cve_docto,fec_elab,firmante,cargo_fmte,nom_suje,cve_dirigido,cve_expe,cve_tipo,cve_eve,fec_eve,time_eve,nacional,domicilio,colonia,delegacion,codigo_post,entidad,telefono from documento where fol_orig='$fol_orig'";
	$sql->query($query);
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$cve_docto		= $sql->f("cve_docto");
			$fec_elab		= $sql->f("fec_elab");
			$firmante		= $sql->f("firmante");
			$cargo_fmte		= $sql->f("cargo_fmte");
			$particular		= $sql->f("nom_suje");
			$cve_dirigido	= $sql->f("cve_dirigido");
			$cve_expe		= $sql->f("cve_expe");
			$cve_tipo		= $sql->f("cve_tipo");
			$cve_eve		= $sql->f("cve_eve");
			$fec_eve		= $sql->f("fec_eve");
			$time_eve		= $sql->f("time_eve");
			$nacional		= $sql->f("nacional");
			$domicilio		= $sql->f("domicilio");
			$colonia		= $sql->f("colonia");
			$delegacion		= $sql->f("delegacion");
			$codigo_post	= $sql->f("codigo_post");
			$entidad		= $sql->f("entidad");
			$telefono		= $sql->f("telefono");



			/*
			---- ESTOS CAMPOS JALAN TAL CUAL ----
			cve_docto,
			fec_elab,
			firmante,
			cargo_fmte,
			particular,
			fec_eve,
			time_eve,
			nacional,
			domicilio,
			colonia,
			codigo_post,
			telefono
			---- ESTOS CAMPOS SE LLAMAN IGUAL PERO NO LLEVARAN LO MISMO ----
			delegacion	delegacion,
			entidad		entidad,
			---- ESTOS CAMPOS SOLO JALO LA CLAVE Y LUEGO TENGO QUE TRAER EL DESCRIPTOR ----
			cve_prom		promotor,
			cve_dirigido		dirigido,
			cve_expe		expediente,
			cve_tipo		tipo_docto,
			cve_eve		evento,
			*/
			if ($cve_prom) {
				$sql2 = new scg_DB;
				$sql2->query("select nom_prom from promotor where cve_prom='$cve_prom'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$promotor	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_dirigido) {
				$sql2 = new scg_DB;
				$sql2->query("select nombre from dirigido where clave='$cve_dirigido'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$dirigido	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_expe) {
				$sql2 = new scg_DB;
				$sql2->query("select nom_expe from expediente where cve_expe='$cve_expe'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$expediente	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_tipo) {
				$sql2 = new scg_DB;
				$sql2->query("select instruccion from instruccion where cve_ins='$cve_tipo' and tipo='D'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$tipo_docto	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_eve) {
				$sql2 = new scg_DB;
				$sql2->query("select topico from tema where cve_tema='$cve_eve' and tipo='E'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$evento	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_remite) {
				$sql2 = new scg_DB;
				$sql2->query("select nom_turn from turnador where cve_turn='$cve_turn'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$remite	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_ins) {
				$sql2 = new scg_DB;
				$sql2->query("select instruccion from instruccion where cve_ins='$cve_ins' and tipo='I'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$instruccion	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($delegacion) {
				$sql2 = new scg_DB;
				$sql2->query("select delegacion from delegacion where clave='$delegacion'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$delegacion	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($entidad) {
				$sql2 = new scg_DB;
				$sql2->query("select entidad from entidad where clave='$entidad'");
				if ($sql2->num_rows($sql2) > 0) {
					if ($sql2->next_record()) {
						$entidad	= $sql2->f("0");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
		}
	}
	//$sql = new scg_DB;
	$base_datos_origen=$sql->Database;
	$query = "SELECT upper(tableowner) from pg_tables where upper(tableName)='DOCUMENTO'";
	$sql = new scg_DB;
	$sql->query($query);
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$prop_base_origen = $sql->f("0");
		}
	}
	$sql = new scg_DB;
	$sql->query("SELECT tableName from pg_tables where upper(tableName)='DEPE_BUZON'"); //checa si existe la tabla depe_buzon
	if ($sql->num_rows($sql) > 0) {
		//AQUI INICIA AHORA LA REVISION PARA VER SI EL AREA DESTINATARIA ESTA EN EL CATALOGO DE BUZONES
		$sql = new scg_DB;
		$query="SELECT base_datos,prop_base from depe_buzon where clave='$cve_depe' and tipo_reg='D'";
		$sql->query($query);
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$base_datos	= $sql->f("base_datos");
			}
		}
		//FIN DE LA REVISION
		if ($base_datos) { //SI SE ENCONTRÓ EN depe_buzon
			$busca_ip_sql = new scg_DB;
			$busca_ip_sql->Database="SSDF_MASTER";
			$busca_ip_sql->query("SELECT * from scg where base_datos='$base_datos'"); //checa si existe la tabla depe_buzon
			if ($busca_ip_sql->num_rows($busca_ip_sql) > 0) {
				while($busca_ip_sql->next_record()) {
					$ip	= $busca_ip_sql->f("ip");
				}
			}
			//$busca_ip_sql->disconnect($busca_ip_sql->Link_ID);
			$sql3 = new scg_DB;
			$sql3->Host		= "$ip";
			$sql3->Database	= "$base_datos";
			$sql3->query("SELECT tableName from pg_tables where upper(tableName)='SOLI_BUZON'"); //checa si existe la tabla depe_buzon
			if ($sql3->num_rows($sql3) > 0) {
				if ((strtoupper($txt_resum))!=(strtoupper($coment))) $coment="$txt_resum\n$coment";
				$texto_sintesis= "$coment\n$instruccion";
				if ($cadena_para_buzon) $texto_sintesis.="\n\nC.c.p.\n$cadena_para_buzon";
				$insertar_buzon = "INSERT into soli_buzon
				(fol_orig,
				conse,
				fec_salid,";
				if ($fec_comp!="") {
					$insertar_buzon.="fec_comp,";
				}
				$insertar_buzon.="remite,
				cve_urge,
				sintesis,
				cve_docto,";
				if ($fec_elab!="") {
					$insertar_buzon.="fec_elab,";
				}
				$insertar_buzon.="base_datos,
				prop_base,
				promotor,
				firmante,
				cargo_fmte,
				particular,
				dirigido,
				expediente,
				tipo_docto,
				evento,";
				if ($fec_eve!="") {
					$insertar_buzon.="fec_eve,";
				}
				if ($time_eve!="") {
					$insertar_buzon.="time_eve,";
				}
				$insertar_buzon.="nacional,
				domicilio,
				colonia,
				delegacion,
				codigo_post,
				entidad,
				telefono)
				values
				('$fol_orig',
				'$siguiente',
				to_timestamp('$fecha_now $hora_now','dd/mm/yyyy hh24:mi'),";
				if ($fec_comp!="") {
					$insertar_buzon.="to_date('$fec_comp','dd/mm/yyyy'),";
				}
				$insertar_buzon.="'$remite',
				'$cve_urge',
				'$texto_sintesis',
				'$cve_docto',";
				if ($fec_elab!="") {
					$insertar_buzon.="to_date('$fec_elab','dd/mm/yyyy'),";
				}
				$insertar_buzon.="'$base_datos_origen',
				'$prop_base_origen',
				'$promotor',
				'$firmante',
				'$cargo_fmte',
				'$particular',
				'$dirigido',
				'$expediente',
				'$tipo_docto',
				'$evento',";
				if ($fec_eve!="") {
					$insertar_buzon.="to_date('$fec_eve','dd/mm/yyyy'),";
				}
				if ($time_eve!="") {
					$insertar_buzon.="'$time_eve',";
				}
				$insertar_buzon.="'$nacional',
				'$domicilio',
				'$colonia',
				'$delegacion',
				'$codigo_post',
				'$entidad',
				'$telefono'
				)";
				//print ($insertar_buzon);
				$resulta = $sql3->query($insertar_buzon);
				if (!$resulta) {
					printf("<br>¡ Error en el query o con la base de datos !\n");
				}
				//INSERTA EN SOLI_BUZON
			}
			//$sql3->disconnect($sql3->Link_ID);
		}
	}
}
if ($viene_de=="recibir_documento_de_buzon") {
	header("Location: principal.php?sess=$sess&control_botones_superior=7&folio_capturado=");
} else {
	if ($viene_de=="insertar_documento") {
		header("Location: principal.php?sess=$sess&control_botones_superior=1&folio_capturado=");
	} else {
		header("Location: principal.php?sess=$sess&control_botones_superior=1");
	}
}
//$sql->disconnect($sql->Link_ID);
?>