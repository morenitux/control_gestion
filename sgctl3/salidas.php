<?php
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$horalarga_now  =date("H:i:s");
$alineacion_vertical="top";
$espaciado=1;
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";

if ($accion=="borra_etapa") {
	$borrar="delete from etapas where folio='$fol_parametro' and conse='$conse_parametro' and oid='$oid'";
	$sql = new scg_DB;
	$resulta = $sql->query($borrar);
	if (!$resulta) {
		printf("<br> Error en el query o con la base de datos !\n");
	}
}
if ($accion=="agrega_etapa") {
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
	$sql = new scg_DB;
	$resulta = $sql->query($insertar);
	if (!$resulta) {
		printf("<br> Error en el query o con la base de datos !\n");
	}
}
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
?>
<script language="JavaScript" src="includes/isValidDate.js"></script>
<script language="JavaScript" src="includes/date-picker.js"></script>
<script language="JavaScript" src="includes/newWindow.js"></script>
<script language="JavaScript">
 self.name="CapturaSalida";
	function regform_ValidatorBusqueda() {
	}
	function regform_Validator() {
		j = document.busca_documento;
		f = document.plantilla_salida;
		if (j.fol_parametro.value.length < 1) {
			alert("Busque y/o seleccione primero el turno que desea descargar");
			j.fol_parametro.focus();
			return(false);
		}
		if (j.conse_parametro.value.length < 1) {
			alert("Busque y/o seleccione primero el turno que desea descargar");
			j.conse_parametro.focus();
			return(false);
		}
		if (f.fec_recdp.value.length>0) {
			fechaAcuseValida=isValidDate(f.fec_recdp.value);
			if (fechaAcuseValida) {
				var comparacion=ComparacionEntreFechas(f.fec_recdp.value,'<? echo $fecha_now; ?>');
				if (comparacion=='ERRORF1') {
					f.fec_recdp.focus();
					return(false);
				}
				if (comparacion=='MAYOR') {
					alert ('La fecha de acuse no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>');
					f.fec_recdp.focus();
					return(false);
				}
				var comparacion=ComparacionEntreFechas(f.fec_recdp.value,j.fec_salid.value);
				if (comparacion=='ERRORF1') {
					f.fec_recdp.focus();
					return(false);
				}
				if (comparacion=='ERRORF2') {
					j.fec_salid.focus();
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha de acuse no puede ser menor a la fecha del turno: '+j.fec_salid.value);
					f.fec_recdp.focus();
					return(false);
				}
			} else {
				f.fec_recdp.focus();
				return(false);
			}
		}
		if (f.fec_elab.value.length>0) {
			fechaAcuseValida=isValidDate(f.fec_elab.value);
			if (fechaAcuseValida) {
				var comparacion=ComparacionEntreFechas(f.fec_elab.value,'<? echo $fecha_now; ?>');
				if (comparacion=='ERRORF1') {
					f.fec_elab.focus();
					return(false);
				}
				if (comparacion=='MAYOR') {
					alert ('La fecha de elaboración no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>');
					f.fec_elab.focus();
					return(false);
				}
				var comparacion=ComparacionEntreFechas(f.fec_elab.value,j.fec_salid.value);
				if (comparacion=='ERRORF1') {
					f.fec_elab.focus();
					return(false);
				}
				if (comparacion=='ERRORF2') {
					j.fec_salid.focus();
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha de elaboración no puede ser menor a la fecha del turno: '+j.fec_salid.value);
					f.fec_elab.focus();
					return(false);
				}
			} else {
				f.fec_elab.focus();
				return(false);
			}
		}
		if (f.cve_docto.value.length<1) {
			alert ('El folio o número del documento no debe ser nulo');
			f.cve_docto.focus();
			return(false);
		}
		if (f.txt_resp.value.length<1) {
			alert ('La síntesis de la respuesta no debe ser nula');
			f.txt_resp.focus();
			return(false);
		}
		for (var i = 0; i < f.numero_total_de_etapas.value; i++) {
		   if ((i==(f.numero_total_de_etapas.value-1)) && (f.estamos_aumentando_una) && (eval("f.etapa"+i+".value==''")) && (eval("f.porciento"+i+".value==''")) && (eval("f.fecha"+i+".value==''"))) {
			 } else {
		   	var controla_etapas=valida_etapa(i);
		 	 	if (!controla_etapas) { return(false); }
		 	 }
		}
		if (f.fec_notifica.value.length>0) {
			fechaAcuseValida=isValidDate(f.fec_notifica.value);
			if (fechaAcuseValida) {
				var comparacion=ComparacionEntreFechas(f.fec_notifica.value,'<? echo $fecha_now; ?>');
				if (comparacion=='ERRORF1') {
					f.fec_notifica.focus();
					return(false);
				}
				if (comparacion=='MAYOR') {
					alert ('La fecha de notificación no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>');
					f.fec_notifica.focus();
					return(false);
				}
				var comparacion=ComparacionEntreFechas(f.fec_notifica.value,j.fec_salid.value);
				if (comparacion=='ERRORF1') {
					f.fec_notifica.focus();
					return(false);
				}
				if (comparacion=='ERRORF2') {
					j.fec_salid.focus();
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha de notificación no puede ser menor a la fecha del turno: '+j.fec_salid.value);
					f.fec_notifica.focus();
					return(false);
				}
			} else {
				f.fec_notifica.focus();
				return(false);
			}
		}
		if (f.concluir.checked) {
			if (f.fec_conclu.value.length>0) {
				fechaAcuseValida=isValidDate(f.fec_conclu.value);
				if (fechaAcuseValida) {
					var comparacion=ComparacionEntreFechas(f.fec_conclu.value,'<? echo $fecha_now; ?>');
					if (comparacion=='ERRORF1') {
						f.fec_conclu.focus();
						return(false);
					}
					if (comparacion=='MAYOR') {
						alert ('La fecha de conclusión no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>');
						f.fec_conclu.focus();
						return(false);
					}
					var comparacion=ComparacionEntreFechas(f.fec_conclu.value,j.fec_salid.value);
					if (comparacion=='ERRORF1') {
						f.fec_conclu.focus();
						return(false);
					}
					if (comparacion=='ERRORF2') {
						j.fec_salid.focus();
						return(false);
					}
					if (comparacion=='MENOR') {
						alert ('La fecha de conclusión no puede ser menor a la fecha del turno: '+j.fec_salid.value);
						f.fec_conclu.focus();
						return(false);
					}
				} else {
					f.fec_conclu.focus();
					return(false);
				}
			}
		}
	}
<?php
$num_turnos		=0;
$fol_orig		="";
$conse			="";
$fec_salid		="";
$fec_comp		="";
$fec_recdp		="";
$fec_elab		="";
$fec_notifica	="";
$fec_conclu		="";
$coment			="";
$cve_depe		="";
$nom_depe		="";
$cve_ins		="";
$instruccion	="";
$cve_docto		="";
$txt_resp		="";
$viable			="";
$califresp		="";
$cve_urge		="";
$usua_sal		="";
$modi_sal		="";
$usua_resp		="";
$modi_resp		="";
if ($fol_parametro!="") {
	$sql = new scg_DB;
	$sql->query("select fol_orig from docsal where fol_orig='$fol_parametro'");
	$num_turnos = $sql->num_rows($sql);
	if ($num_turnos > 0) {
		$sql = new scg_DB;
		$query="select fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid,cve_depe,coment,cve_ins,to_char(fec_comp,'dd/mm/yyyy') as fec_comp,to_char(fec_recdp,'dd/mm/yyyy') as fec_recdp,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,txt_resp,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,viable,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,cve_urge,califresp,usua_sal,modi_sal,usua_resp,modi_resp,cve_resp from docsal where fol_orig='$fol_parametro' ";
		if ($conse_parametro!="") {
			$query.= "and conse='$conse_parametro'";
		}
		$query.=" order by fol_orig,conse";
		$sql = new scg_DB;
		$sql->query($query);
		while ($sql->next_record()) {
			$fol_orig		= $sql->f("fol_orig");
			$conse			= $sql->f("conse");
			$fec_salid		= $sql->f("fec_salid");
			$cve_depe		= $sql->f("cve_depe");
			$coment			= $sql->f("coment");
			$cve_ins		= $sql->f("cve_ins");
			$fec_comp		= $sql->f("fec_comp");
			$fec_recdp		= $sql->f("fec_recdp");
			$cve_docto		= $sql->f("cve_docto");
			$fec_elab		= $sql->f("fec_elab");
			$txt_resp		= $sql->f("txt_resp");
			$fec_notifica	= $sql->f("fec_notifica");
			$viable			= $sql->f("viable");
			$fec_conclu		= $sql->f("fec_conclu");
			$cve_urge		= $sql->f("cve_urge");
			$califresp		= $sql->f("califresp");
			$usua_sal		= $sql->f("usua_sal");
			$modi_sal		= $sql->f("modi_sal");
			$usua_resp		= $sql->f("usua_resp");
			$modi_resp		= $sql->f("modi_resp");
			$cve_resp		= $sql->f("cve_resp");
			if ($cve_depe!="") {
				$sql2 = new scg_DB;
				$sql2->query("select nom_depe from dependencia where cve_depe='$cve_depe'");
				if ($sql2->num_rows($sql2) == 1) {
					if ($sql2->next_record()) {
						$nom_depe	= $sql2->f("nom_depe");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);
			}
			if ($cve_ins!="") {
				$sql2 = new scg_DB;
				$sql2->query("select instruccion from instruccion where cve_ins='$cve_ins'");
				if ($sql2->num_rows($sql2) == 1) {
					if ($sql2->next_record()) {
						$instruccion = $sql2->f("instruccion");
					}
				}
				//$sql2->disconnect($sql2->Link_ID);

			}
		}
		$sql = new scg_DB;
		$query="SELECT cve_remite,cve_refe from documento where fol_orig='$fol_parametro'";
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
			$sql->query($query);
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$base_datos	= $sql->f("base_datos");
				}
			}
		}
	}
	?>
	function cambia_conclusion() {
		if (document.plantilla_salida.cve_resp.options[document.plantilla_salida.cve_resp.selectedIndex].value=='S') {
			document.plantilla_salida.fec_conclu.value='<?php if ($fec_conclu!="") { echo $fec_conclu; } else { echo $fecha_now; } ?>';
			document.plantilla_salida.fec_conclu.focus();
		} else {
			document.plantilla_salida.fec_conclu.value='';
			document.plantilla_salida.califresp.selectedIndex=0;
		}
	}
  	<? if ($base_datos) { ?>
	function verifica_transmision() {
		if (document.plantilla_salida.transmitir.checked) {
			document.plantilla_salida.transmitir.value=1;
		} else {
			document.plantilla_salida.transmitir.value=0;
		}
	}
	<? } ?>
	function valida_etapa(numero) {
		var tam_etapa=eval('document.plantilla_salida.etapa'+numero+'.value.length;');
		if (tam_etapa<1) {
			alert('La etapa no debe ser nula');
			eval('document.plantilla_salida.etapa'+numero+'.focus();');
			return(false);
		}
		var tam_porciento=eval('document.plantilla_salida.porciento'+numero+'.value.length;');
		if (tam_porciento>1) {
			var patron_porcentaje = /^(\d{1,3})(\%|)$/;
			valor=eval('document.plantilla_salida.porciento'+numero+'.value');
			var matcha = valor.match(patron_porcentaje);
			if (matcha == null) {
				alert('Verifique que el porcentaje de avance sólo contenga n�meros enteros');
				eval('document.plantilla_salida.porciento'+numero+'.focus();');
				return(false);
  		}
  	}
		var tam_fecha=eval('document.plantilla_salida.fecha'+numero+'.value.length;');
		if (tam_fecha>0) {
			var fechaValida=eval('isValidDate(document.plantilla_salida.fecha'+numero+'.value);');
			if (fechaValida) {
				var comparacion=eval("ComparacionEntreFechas(document.plantilla_salida.fecha"+numero+".value,'<? echo $fecha_now; ?>');");
				if (comparacion=='ERRORF1') {
					eval('document.plantilla_salida.fecha'+numero+'.focus();');
				}
				if (comparacion=='MAYOR') {
					alert ('La fecha no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>');
					eval('document.plantilla_salida.fecha'+numero+'.focus();');
					return(false);
				}
				var comparacion=eval("ComparacionEntreFechas(document.plantilla_salida.fecha"+numero+".value,document.busca_documento.fec_salid.value);");
				if (comparacion=='ERRORF1') {
					eval('document.plantilla_salida.fecha'+numero+'.focus();');
					return(false);
				}
				if (comparacion=='ERRORF2') {
					document.busca_documento.fec_salid.focus();
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha no puede ser menor a la fecha del turno: '+document.busca_documento.fec_salid.value);
					eval('document.plantilla_salida.fecha'+numero+'.focus();');
					return(false);
				}
			} else {
				eval('document.plantilla_salida.fecha'+numero+'.focus();');
				return(false);
			}
		}
		return(true);
  }
	</script>
	<?
	if ($num_turnos==0) {
		$error_alert= "<body onLoad='alert(\"El documento $fol_parametro ";
		if ($conse_parametro!="") {
			$error_alert.= "con turno $conse_parametro ";
		}
		$error_alert.= "no existe o no ha sido turnado. Favor de verificar.\")'></body>\n";
		echo $error_alert;
	}
} else {
	echo "</script>\n";
}
?>
<form name="busca_documento" method="post" action="principal.php?sess=<? echo $sess; ?>&control_botones_superior=2" target="_self" onsubmit="return regform_ValidatorBusqueda(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<table width="700" border="0" cellspacing="0" cellpadding="0">
 <tr><td><a href="javascript: history.go(-1);"><?php echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a></td></tr>
</table>
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	 <table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Folio:</font>
	   </td>
	   <td width="6%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <input type="text" name="fol_parametro" value="<? echo $fol_orig; ?>" size=10 maxlength=10>
	   </td>
	   <td width="6%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Turno:</font>
	   </td>
	   <td width="30%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <input type="text" name="conse_parametro" value="<? echo $conse; ?>" size=3 maxlength=3>
	    <input type="submit" name="buscar" value="Buscar">
	   </td>
	   <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Turnado el:</font>
	   </td>
	   <td width="6%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <input type="text" name="fec_salid" value="<? echo $fec_salid; ?>" size=10 maxlength=10 onFocus="this.blur();">
	   </td>
	   <td colspan=2 valign="<?php echo $alineacion_vertical; ?>" align="center">
	   	<?
	   	if ($fol_parametro!="" && $num_turnos>0) {
				if ($conse_parametro=="") $conse_parametro=$num_turnos;
				if (strlen($conse_parametro)==1) $conse_parametro="0".$conse_parametro;
				$antes		=$conse_parametro-1;
				$despues	=$conse_parametro+1;
				if (strlen($antes)==1) $antes="0".$antes;
				if (strlen($despues)==1) $despues="0".$despues;
				if (strlen($num_turnos)==1) { $num_turnos_txt="0".$num_turnos; } else { $num_turnos_txt=$num_turnos; };
				if ($conse_parametro!="01") {
					print("<a href='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=01&control_botones_superior=2'><img src='$default->scg_graphics_url"."/bot2e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot1d.gif' border=0>");
				}
				if ($conse_parametro!="01") {
					print("<a href='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$antes&control_botones_superior=2'><img src='$default->scg_graphics_url"."/bot1e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot2d.gif' border=0>");
				}
				if ($conse_parametro!=$num_turnos_txt) {
				print("<a href='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$despues&control_botones_superior=2'><img src='$default->scg_graphics_url"."/bot3e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot3d.gif' border=0>");
				}
				if ($conse_parametro!=$num_turnos_txt) {
				print("<a href='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$num_turnos_txt&control_botones_superior=2'><img src='$default->scg_graphics_url"."/bot4e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot4d.gif' border=0>");
				}
			} else {
				print("&nbsp;");
			}
	    ?>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Turnado a:</font>
	   </td>
	   <td colspan=7>
	    <input type="text" name="nom_depe" value="<? echo $nom_depe; ?>" size=70 maxlength=100 onFocus="this.blur();">
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Síntesis:</font>
	   </td>
	   <td colspan=7>
	    <textarea name="coment" wrap cols=68 rows=4 onFocus="this.blur();"><? echo $coment; ?></textarea>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Instrucción:</font>
	   </td>
	   <td colspan=7>
	    <input type="text" name="instruccion" value="<? echo $instruccion; ?>" size=70 maxlength=100 onFocus="this.blur();">
	   </td>
	  </tr>
	  <tr>
	   <td colspan=8 valign="<?php echo $alineacion_vertical; ?>" align="center">
			<br>
	   </td>
	  </tr>
	 </table>
  </td>
 </tr>
</table>
</form>
<form name="plantilla_salida" method="post" action="updateSalida.php?sess=<? echo $sess; ?>&control_botones_superior=1" target="_self" onsubmit="return regform_Validator();" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<input type="hidden" name="fol_parametro" value="<? echo $fol_parametro; ?>">
<input type="hidden" name="conse_parametro" value="<? echo $conse_parametro; ?>">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	 <table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Acuse:</font>
	   </td>
	   <td>
	    <input type="text" name="fec_recdp" value="<? echo $fec_recdp; ?>" size=10 maxlength=10>
	    <a href="javascript:show_calendar('plantilla_salida.fec_recdp');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>&nbsp;&nbsp;&nbsp;
	    <select name="viable">
	    	<option value=""></option>
	    	<option value="">(Ninguno)</option>
	    	<option value="1"<?php if ($viable=="1") echo " selected"; ?>>No viable</option>
	    	<option value="0"<?php if ($viable=="0") echo " selected"; ?>>Viable</option>
	    </select>
	   </td>
	   <td >
	   	<font class="chiquito">Elaboración:</font><input type="text" name="fec_elab" value="<? echo $fec_elab; ?>" size=10 maxlength=10>
	   	<a href="javascript:show_calendar('plantilla_salida.fec_elab');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	   </td>
	   <td width="25%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Plazo:</font>
	    <select name='plazo'>
	    	<option value=''></option>
	    	<option value='0'>(Ninguno)</option>
	    	<option value='1'>Corto</option>
	    	<option value='2'>Mediano</option>
	    	<option value='3'>Largo</option>
	    </select>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right" bgcolor="#FFFFCC">
	    <font class="chiquito">Documento:</font>
	   </td>
	   <td>
	    <input type="text" name="cve_docto" value="<? echo $cve_docto; ?>" size=30 maxlength=50>
	   </td>
	   <td>
	    <font class="chiquito">Notificación:</font><input type="text" name="fec_notifica" value="<? echo $fec_notifica; ?>" size=10 maxlength=10>
	    <a href="javascript:show_calendar('plantilla_salida.fec_notifica');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	   </td>
	   <td>
	    <font class="chiquito">Compromiso:</font><input type="text" name="fec_comp" value="<? echo $fec_comp; ?>" size=10 maxlength=10>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right" bgcolor="#FFFFCC">
	    <font class="chiquito">Respuesta:</font>
	   </td>
	   <td colspan=3>
	    <textarea name="txt_resp" wrap cols=68 rows=4><? echo $txt_resp; ?></textarea>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <table width="100%" border=0 cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	     <tr>
	      <td valign="<?php echo $alineacion_vertical; ?>" align="right">
	       <font class="chiquito">Etapas:</font>
	      </td>
	     </tr>
	    </table>
	   </td>
	   <td colspan=3 valign="top">
	    <!-- INICIO ETAPAS -------------------------------------------------------------------------------------------------- -->
	    <table width="100%" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
       <tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
    		<td width="5%" align='center' class='chiquitoblanco'>
    		 <?php if ($accion!="nueva_etapa" && $num_turnos>0 && $accion!="agrega_etapa") { print("<a href='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro&control_botones_superior=2&accion=nueva_etapa'><img src='$default->scg_graphics_url"."/new_etapae.gif' border=0></a>"); } else { print("&nbsp;"); } ?>
    		</td>
    		<td width="70%" align='center' class='chiquitoblanco'>
    		 Etapa
    		</td>
    		<td width="10%" align='center' class='chiquitoblanco'>
    		 Porcentaje
    		</td>
    		<td width="15%" align='center' class='chiquitoblanco'>
    		 Fecha
    		</td>
    	 </tr>
				<?
				$x=0;
				if ($fol_parametro!="" && $conse_parametro!="") {
					$sql = new scg_DB;
					$sql->query("select oid,etapa,porciento,to_char(fecha,'dd/mm/yyyy') as fecha from etapas where folio='$fol_parametro' and conse='$conse_parametro' order by oid");
					$num_etapas=0;
					$num_etapas = $sql->num_rows($sql);
					if ($num_etapas > 0) {
						while ($sql->next_record()) {
							$oid				= $sql->f("0");
							$etapa			= $sql->f("etapa");
							$porciento	= $sql->f("porciento");
							$fecha			= $sql->f("fecha");
							if ($porciento!="") {
								$cadena_porciento="$porciento%";
							} else {
								$cadena_porciento="";
							}
							print("<tr>\n<td>\n");
							print("<a href='principal.php?sess=$sess&oid=$oid&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro&control_botones_superior=2&accion=borra_etapa'><img src='$default->scg_graphics_url"."/del_etapae.gif' border=0></a>");
							print("\n</td>\n<td>");
							print("<input type='text' name='etapa$x' value='$etapa' size=50 maxlength=100>\n");
							print("\n</td>\n<td>\n");
							print("<input type='text' name='porciento$x' value='$cadena_porciento' size=4 maxlength=4>\n");
							print("\n</td>\n<td>");
							print("<input type='text' name='fecha$x' value='$fecha' size=10 maxlength=10>\n");
							print("\n</td>\n</tr>\n");
							print("<input type='hidden' name='oid$x' value='$oid'>\n");
							$x++;
						}
					}
				}
				if ($accion=="nueva_etapa" || $accion=="agrega_etapa") {
					$cuantas_son=$num_etapas+1;
					print("<input type='hidden' name='numero_total_de_etapas' value=$cuantas_son>");
					print("<input type='hidden' name='estamos_aumentando_una' value=true>");
					print("<tr>\n<td>\n");
					print("<a href=\"javascript: if (valida_etapa($x)) { eval(window.location='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro&control_botones_superior=2&accion=agrega_etapa&etapa='+document.plantilla_salida.etapa$x.value+'&porciento='+document.plantilla_salida.porciento$x.value+'&fecha='+document.plantilla_salida.fecha$x.value); }\"><img src='$default->scg_graphics_url"."/new_etapae.gif' border=0></a>");
					print("\n</td>\n<td>");
					print("<input type='text' name='etapa$x' value='' size=50 maxlength=100>\n");
					print("\n</td>\n<td>\n");
					print("<input type='text' name='porciento$x' value='' size=4 maxlength=4>\n");
					print("\n</td>\n<td>");
					print("<input type='text' name='fecha$x' value='' size=10 maxlength=10>\n");
					print("\n</td>\n</tr>\n");
					print("<input type='hidden' name='oid$x' value=''");
				} else {
					$cuantas_son=$num_etapas;
					print("<input type='hidden' name='numero_total_de_etapas' value=$cuantas_son>");
				}
				print("<tr>\n<td>\n&nbsp;\n</td>\n<td>&nbsp;\n</td>\n<td>\n&nbsp;\n</td>\n<td>&nbsp;\n</td>\n</tr>\n");
				print("<input type='hidden' name='estamos_aumentando_una' value=false>");
				?>
      </table>
      <!-- FIN ETAPAS -------------------------------------------------------------------------------------------------- -->
     </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito"><br></font>
	   </td>
	   <td colspan=2>
	    <select name="cve_resp" onChange="cambia_conclusion();">
	     <!--<option value="" <? if ($cve_resp=="") { echo "selected"; } ?>>NO REQUIERE RESPUESTA</option>-->
	     <option value="" <? if ($cve_resp=="") { echo "selected"; } ?>></option>
	     <option value="N" <? if ($cve_resp=="N") { echo "selected"; } ?>>PENDIENTE</option>
	     <option value="A" <? if ($cve_resp=="A") { echo "selected"; } ?>>EN TR�MITE</option>
	     <option value="S" <? if ($cve_resp=="S") { echo "selected"; } ?>>CONCLUIDO</option>
	    </select>
	    <input type="text" name="fec_conclu" value="<?php echo $fec_conclu; ?>" size=10 maxlength=10 onFocus="if (document.plantilla_salida.cve_resp.options[document.plantilla_salida.cve_resp.selectedIndex].value!='S') { this.blur(); }">
		<select name="califresp" onFocus="if (document.plantilla_salida.cve_resp.options[document.plantilla_salida.cve_resp.selectedIndex].value!='S') { this.blur(); }">
		 <option value=""></option>
		 <option value="0"<?php if ($califresp=="0") echo " selected"; ?>>Negativa</option>
		 <option value="1"<?php if ($califresp=="1") echo " selected"; ?>>Positiva</option>
	    </select>
	   </td>
	   <td align="right">
	    <? if ($base_datos) echo "&nbsp;<font class=chiquito>Transmitir:</font><input name='transmitir' type='checkbox' value='0' onClick='verifica_transmision();' onFocus='verifica_transmision();' onChange='verifica_transmision();' onSelect='verifica_transmision();'><br>"; ?>
	   </td>
	  </tr>
	  <tr>
	   <td colspan=4>
	    <table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 	     <tr>
   	    <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <font class="chiquito">Reg:<br>
	 	     <?php
	 	  	  if ($usua_sal=="" && $usua_resp=="") {
						echo $id_usuario;
					} else {
						switch ($cve_resp) {
							case "N":
								if ($usua_sal=="") {
									echo $id_usuario;
								} else {
									echo $usua_sal;
								}
							break;
							case "S":
								if ($usua_resp=="") {
									echo $id_usuario;
								} else {
									echo $usua_resp;
								}
							break;
						}
					}
				 ?>
				 </font>
	 	    </td>
	 	    <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <font class="chiquito">Mod:<br>
	 	     <?php
	 	     	if ($modi_sal=="" && $modi_resp=="") {
						echo "&nbsp;";
					}	else {
						switch ($cve_resp) {
							case "N":
								if ($modi_sal=="") {
									echo "&nbsp;";
								} else {
									echo $modi_sal;
								}
							break;
							case "S":
								if ($modi_resp=="") {
									echo $id_usuario;
								} else {
									echo $modi_resp;
								}
							break;
						}
					}
					?>
					</font>
	 	    </td>
	 	    <td width="72%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <br>
	 	    </td>
 		   </tr>
 		  </table>
 	   </td>
	  </tr>
   </table>
  </td>
 </tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0">
 <tr>
 <td width=33% align=left><a href="javascript: history.go(-1);"><?php echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a></td>
 <td width=33% align=center><input type="submit" name="guardar" value="Guardar"></td>
 <td width=33% align=right>&nbsp;</td>
 </tr>
</table>
</form>
<?
//$sql->disconnect($sql->Link_ID);
?>
