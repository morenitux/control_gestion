<script language="JavaScript" src="includes/isValidDate.js"></script>
<script language="JavaScript" src="includes/date-picker.js"></script>
<script language="JavaScript" src="includes/newWindow.js"></script>
<script language="JavaScript">
 self.name="CapturaDocumento";
 function regform_Validator(f) {
	fechaRecValida=isValidDate(f.fec_recep.value);
	horaRecValida=isValidHour(f.hora_recep.value);
	if (fechaRecValida && horaRecValida) {
		var comparacion=ComparacionEntreFechasConHoras(f.fec_recep.value,f.hora_recep.value,'<? echo $fecha_now; ?>','<? echo $hora_now; ?>');
		if (comparacion=='ERRORF1') {
			f.fec_recep.focus();
			return(false);
		}
		if (comparacion=='ERRORH1') {
			f.hora_recep.focus();
			return(false);
		}
		if (comparacion=='MAYOR') {
			alert ('La fecha de acuse no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>'+' '+'<? echo $hora_now; ?>'+' hrs.');
			f.fec_recep.focus();
			return(false);
		}
		if (comparacion=='MAYOR EN HORAS') {
			alert ('La hora del acuse no puede ser mayor a la hora actual: '+'<? echo $hora_now; ?>'+' hrs.');
			f.hora_recep.focus();
			return(false);
		}
	} else {
		if (!fechaRecValida) {
			f.fec_recep.focus();
			return(false);
		}
		if (!horaRecValida) {
			f.hora_recep.focus();
			return(false);
		}

	}
	if (f.cve_docto.value.length < 1) {
		  alert("El número del documento no debe ser nulo \n(Escriba S/N cuando el documento no tenga número)");
		  f.cve_docto.focus();
		  return(false);
	}

	fechaElabValida=isValidDate(f.fec_elab.value);
	if (fechaElabValida) {
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

		var comparacion=ComparacionEntreFechas(f.fec_elab.value,f.fec_recep.value);
		if (comparacion=='ERRORF1') {
			f.fec_elab.focus();
			return(false);
		}
		if (comparacion=='ERRORF2') {
			f.fec_recep.focus();
			return(false);
		}
		if (comparacion=='MAYOR') {
			alert ('La fecha de elaboración no puede ser mayor a la fecha de acuse: '+f.fec_recep.value);
			f.fec_elab.focus();
			return(false);
		}

	} else {
		if (!fechaElabValida) {
			f.fec_elab.focus();
			return(false);
		}
	}
	if (f.firmante.options[f.firmante.selectedIndex].value==0 || f.firmante.options[f.firmante.selectedIndex].value=="OTRO") {
		  alert("El firmante no debe ser nulo.\nPor favor selecione o introduzca el dato.");
		  f.firmante.focus();
		  return(false);
	}
	if (f.txt_resum.value.length < 1) {
		  alert("El texto del documento no debe ser nulo.");
		  f.txt_resum.focus();
		  return(false);
	}
	var largo_maximo=2000;
	if (f.txt_resum.value.length > largo_maximo) {
		  alert("El tamaño máximo de este campo es de "+largo_maximo+" caracteres. Por favor reduzca su texto.");
		  f.txt_resum.focus();
		  return(false);
	}
	if (f.fec_eve.value.length>0) {
	    valida=isValidDate(f.fec_eve.value);
	    if (!valida) {
	        f.fec_eve.focus();
	        return(false);
	    }
	}
	if (f.hora_evento.value.length>0) {
	    valida=isValidHour(f.hora_evento.value);
	    if (!valida) {
	        f.hora_evento.focus();
	        return(false);
	    }
	}
 }

 function OtroFirmante(inForm,selected) {
  //alert("Seleccionado:"+selected+".");
  if (selected=='OTRO') {
    descripcion='';
    while (descripcion=='') {
      descripcion=prompt('Firmante:','');
    }
    if (descripcion != null && descripcion != "") {
      inForm.firmante.options[(inForm.firmante.options.length-1)]=new Option(descripcion,descripcion,true,true);
      //var selectedArray = eval("e" + selected + "Array");
    }
  }
 }
 <?php

 	echo "\n\n";
 	echo "//-----------------------------------------------------------------------\n";
 	echo "//AQUI INICIA LA GENERACION DE ARREGLOS DE PROMOTORES\n";
 	echo "//-----------------------------------------------------------------------\n";
	//PRIMERO PROMOTORES
	$i=0;
	$promotor_array0[$i]="0";
	$promotor_array1[$i]="Sin promotor";
	$sql = new scg_DB;
	$sql->query("select nom_prom,cve_prom from promotor where tipo in ('P','Q') and baja is null order by nom_prom,cve_prom");
	$num_promotor = $sql->num_rows($sql);
	if ($num_promotor > 0) {
		while($sql->next_record()) {
			$nom_prom = $sql->f("nom_prom");
			$cve_prom = $sql->f("cve_prom");
			$cve_prom_js	= str_replace(".","_",$cve_prom);
			$promotor_array0[$i+1]=$cve_prom_js;
			$promotor_array1[$i+1]=$nom_prom;
			echo "var p".$cve_prom_js."Array =  new Array(\"('Seleccione el firmante ---------------------------','',true,true)\",\n";
			$i++;
			$sql2 = new scg_DB;
			$sql2->query("SELECT cve_prom, siglas, nom_prom, tit_prom, tipo, domicilio, colonia, delegacion, codigo_post, entidad, telefono, car_titu from promotor where cve_prom='$cve_prom' and baja is null");
			$num_titulares = $sql2->num_rows($sql2);
			if ($num_titulares > 0) {
				$j = 0;
				while($sql2->next_record()) {
					$cve_prom2 = $sql2->f("cve_prom");
					$nom_prom2 = $sql2->f("nom_prom");
					$tit_prom  = $sql2->f("tit_prom");
					echo "\"('$tit_prom', '$tit_prom')\"";
					$j++;
					if ($j==$num_titulares) {
						echo ",\"('------------------------------------------------------------', 0)\"";
						echo ",\"('Otro', 'OTRO')\");\n";
					} else {
						echo ",\n";
					}
				}
			}
		}
	}

	echo "//-----------------------------------------------------------------------\n";
	echo "//AQUI TERMINA LA GENERACION DE ARREGLOS DE PROMOTORES E INICIA LA GENERACION DE ARREGLOS DE REMITENTES\n";
 	echo "//-----------------------------------------------------------------------\n";
	//SEGUNDO REMITENTES

	$i=0;
	$sql = new scg_DB;
	$sql->query("select nom_prom,cve_prom from promotor where tipo in ('R','Q') and baja is null order by nom_prom,cve_prom");
	$num_remitente = $sql->num_rows($sql);
	if ($num_remitente > 0) {
		while($sql->next_record()) {
			$nom_prom = $sql->f("nom_prom");
			$cve_prom = $sql->f("cve_prom");
			$cve_prom_js	= str_replace(".","_",$cve_prom);
			$remitente_array0[$i+1]=$cve_prom_js;
			$remitente_array1[$i+1]=$nom_prom;
			echo "var r".$cve_prom_js."Array =  new Array(\"('Seleccione el firmante ---------------------------','',true,true)\",\n";
			$i++;
			$sql2 = new scg_DB;
			$sql2->query("SELECT cve_prom, siglas, nom_prom, tit_prom, tipo, domicilio, colonia, delegacion, codigo_post, entidad, telefono, car_titu from promotor where cve_prom='$cve_prom' and baja is null");
			$num_titulares = $sql2->num_rows($sql2);
			if ($num_titulares > 0) {
				$j = 0;
				while($sql2->next_record()) {
					$cve_prom2 = $sql2->f("cve_prom");
					$nom_prom2 = $sql2->f("nom_prom");
					$tit_prom  = $sql2->f("tit_prom");
					echo "\"('$tit_prom', '$tit_prom')\"";
					$j++;
					if ($j==$num_titulares) {
						echo ",\"('------------------------------------------------------------', 0)\"";
						echo ",\"('Otro', 'OTRO')\");\n";
					} else {
						echo ",\n";
					}
				}
			}
		}
	}
	echo "//-----------------------------------------------------------------------\n";
	echo "//AQUI FIN DE REMITENTES\n";
 	echo "//-----------------------------------------------------------------------\n";
 ?>
 function despliegaFirmantesFromPromotor(inForm,selected) {
	if (selected!=0) {
		var selectedArray = eval("p" + selected + "Array");
		if (inForm.cve_remite.selectedIndex>0 && inForm.cve_remite[inForm.cve_remite.selectedIndex].value!=inForm.cve_prom[inForm.cve_prom.selectedIndex].value) { //El remitente ya está seleccionado y hay que combinar ambos listados
			var previousArray = eval("r" + inForm.cve_remite[inForm.cve_remite.selectedIndex].value + "Array");
			while (inForm.firmante.options.length > 0) {
				inForm.firmante.options[(inForm.firmante.options.length - 1)] = null;
			}
			//primero el del promotor; el -2 es para no añadir la raya y el "OTRO" en medio del nuevo listado
			for (var i=0; i < selectedArray.length-2; i++) {
				eval("inForm.firmante.options[i]=" + "new Option" + selectedArray[i]);
			}
			//después el del remitente; el -1 es para no añadir el "Seleccione el remitente---" en medio del nuevo listado
			for (var j=0; j < previousArray.length-1; j++) {
				eval("inForm.firmante.options[j+i]=" + "new Option" + previousArray[j+1]);
			}
		} else { //El remitente no ha sido seleccionado y se arma el listado de firmantes sólo con base en el promotor.
			while (selectedArray.length < inForm.firmante.options.length) {
				inForm.firmante.options[(inForm.firmante.options.length - 1)] = null;
			}
			for (var i=0; i < selectedArray.length; i++) {
				eval("inForm.firmante.options[i]=" + "new Option" + selectedArray[i]);
			}
		}
		/* Aqui se refresca la lista */
		if (inForm.cve_prom.options[0].value == '') {
			inForm.cve_prom.options[0]= null;
			if ( navigator.appName == 'Netscape') {
				if (parseInt(navigator.appVersion) < 4) {
					window.history.go(0);
				} else {
					if (navigator.platform == 'Win32' || navigator.platform == 'Win16') {
						window.history.go(0);
					}
				}
			}
		}
	}
 }
 function despliegaFirmantesFromRemitente(inForm,selected) {
	if (selected!=0) {
		var selectedArray = eval("r" + selected + "Array");
		if (inForm.cve_prom.selectedIndex>0 && inForm.cve_remite[inForm.cve_remite.selectedIndex].value!=inForm.cve_prom[inForm.cve_prom.selectedIndex].value) { //El promotor ya está seleccionado y hay que combinar ambos listados
			var previousArray = eval("p" + inForm.cve_prom[inForm.cve_prom.selectedIndex].value + "Array");
			while (inForm.firmante.options.length > 0) {
				inForm.firmante.options[(inForm.firmante.options.length - 1)] = null;
			}
			//primero el del promotor; el -2 es para no añadir la raya y el "OTRO" en medio del nuevo listado
			for (var i=0; i < previousArray.length-2; i++) {
				eval("inForm.firmante.options[i]=" + "new Option" + previousArray[i]);
			}
			//después el del remitente; el -1 es para no añadir el "Seleccione el remitente---" en medio del nuevo listado
			for (var j=0; j < selectedArray.length-1; j++) {
				eval("inForm.firmante.options[j+i]=" + "new Option" + selectedArray[j+1]);
			}

		} else { //El promotor no ha sido seleccionado y se arma el listado de firmantes sólo con base en el remitente.
			while (selectedArray.length < inForm.firmante.options.length) {
				inForm.firmante.options[(inForm.firmante.options.length - 1)] = null;
			}
			for (var i=0; i < selectedArray.length; i++) {
				eval("inForm.firmante.options[i]=" + "new Option" + selectedArray[i]);
			}
		}

		/* Aqui se refresca la lista */
		if (inForm.cve_prom.options[0].value == '') {
			inForm.cve_prom.options[0]= null;
			if ( navigator.appName == 'Netscape') {
				if (parseInt(navigator.appVersion) < 4) {
					window.history.go(0);
				} else {
					if (navigator.platform == 'Win32' || navigator.platform == 'Win16') {
						window.history.go(0);
					}
				}
			}
		}
	}
 }
 //  End -->
</script>
<?php
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$alineacion_vertical="top";
$espaciado=1;
// echo "$$$$$$$$$$$$$$$$$";

$fol_orig			= "";
$fec_regi			= "";
$fec_recep			= "";
$cve_docto			= "";
$fec_elab			= "";
$firmante			= "";
$cve_prom			= "";
$cve_remite			= "";
$txt_resum			= "";
$cve_expe			= "";
$nom_suje			= "";
$notas				= "";
$cve_segui			= "";
$cve_refe			= "";
$cve_recep			= "";
$usua_doc			= "";
$cve_eve			= "";
$fec_eve			= "";
$time_eve			= "";
$cve_tipo			= "";
$confi				= "";
$modifica			= "";
$cve_dirigido		= "";
$cargo_fmte  		= "";
$nacional			= "";
$domicilio			= "";
$colonia			= "";
$delegacion			= "";
$codigo_post		= "";
$entidad			= "";
$telefono			= "";
$clasif				= "";
$antecedente		= "";
$fec_comp			= "";
$salida				= "";
$hora_recep			= "";
$ctr_entidad		= "";

$query="SELECT fol_orig,
to_char(fec_regi,'dd/mm/yyyy'),
to_char(fec_recep,'dd/mm/yyyy'),
cve_docto,
to_char(fec_elab,'dd/mm/yyyy'),
firmante,
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
cve_eve,
to_char(fec_eve,'dd/mm/yyyy'),
time_eve,
cve_tipo,
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
antecedente,
to_char(fec_comp,'dd/mm/yyyy'),
salida,
to_char(fec_recep,'HH24:mi')
from documento
where fol_orig='$parametro'";
$sql = new scg_DB;
$sql->query($query);
if ($sql->next_record()) {
	$fol_orig			= $sql->f("0");
	$fec_regi			= $sql->f("1");
	$fec_recep			= $sql->f("2");
	$cve_docto			= $sql->f("3");
	$fec_elab			= $sql->f("4");
	$firmante			= $sql->f("5");
	$cve_prom			= $sql->f("6");
	$cve_remite			= $sql->f("7");
	$txt_resum			= $sql->f("8");
	$cve_expe			= $sql->f("9");
	$nom_suje			= $sql->f("10");
	$notas				= $sql->f("11");
	$cve_segui			= $sql->f("12");
	$cve_refe			= $sql->f("13");
	$cve_recep			= $sql->f("14");
	$usua_doc			= $sql->f("15");
	$cve_eve			= $sql->f("16");
	$fec_eve			= $sql->f("17");
	$time_eve			= $sql->f("18");
	$cve_tipo			= $sql->f("19");
	$confi				= $sql->f("20");
	$modifica			= $sql->f("21");
	$cve_dirigido		= $sql->f("22");
	$cargo_fmte  		= $sql->f("23");
	$nacional			= $sql->f("24");
	$domicilio			= $sql->f("25");
	$colonia			= $sql->f("26");
	$delegacion			= $sql->f("27");
	$codigo_post		= $sql->f("28");
	$entidad			= $sql->f("29");
	$telefono			= $sql->f("30");
	$clasif				= $sql->f("31");
	$antecedente		= $sql->f("32");
	$fec_comp			= $sql->f("33");
	$salida				= $sql->f("34");
	$hora_recep			= $sql->f("35");
	$ctr_entidad		= $entidad*1;
}
$sql = new scg_DB;
$sql->query("SELECT * from doctem where fol_orig='$parametro'");
$x=0;
$total_temas=$sql->num_rows($sql);
while ($sql->next_record()) {
	$cve_tema[$x] = $sql->f("cve_tema");
	$x++;
}
if ($entidad!="") {
	$sql = new scg_DB;
	$sql->query("select id_entidad_federativa,entidad_federativa from cat_entidad_federativa where id_entidad_federativa='$entidad'");
	if ($sql->next_record()) {
		$numero_entidad	= $sql->f("id_entidad_federativa")*1;
		$nombre_entidad = $sql->f("entidad_federativa");
	}
}
if ($delegacion!="") {
	$sql = new scg_DB;
	$sql->query("select id_delegacion_municipio,delegacion_municipio from cat_delegacion_municipio where id_delegacion_municipio='$delegacion'");
	if ($sql->next_record()) {
		$numero_delegacion	= $sql->f("id_delegacion_municipio")*1;
		$nombre_delegacion 	= $sql->f("delegacion_municipio");
	}
}
?>
<form name="plantilla_documento" method="post" action="updateDocumento.php?sess=<? echo $sess; ?>&control_botones_superior=1" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<script language="JavaScript">var captura=false;</script>
<input type="hidden" name="control_ventana" value="">
<input type="hidden" name="domicilio" value="<? echo $domicilio; ?>">
<input type="hidden" name="colonia" value="<? echo $colonia; ?>">
<input type="hidden" name="codigo_post" value="<? echo $codigo_post; ?>">
<input type="hidden" name="telefono" value="<? echo $telefono; ?>">
<input type="hidden" name="entidad" value="<? echo $entidad; ?>">
<input type="hidden" name="control_entidad" value="<? echo $ctr_entidad; ?>">
<input type="hidden" name="valor_entidad" value="<? echo $nombre_entidad; ?>">
<input type="hidden" name="delegacion" value="<? echo $delegacion; ?>">
<input type="hidden" name="control_delegacion" value="<? echo $numero_delegacion; ?>">
<input type="hidden" name="valor_delegacion" value="<? echo $nombre_delegacion; ?>">
<input type="hidden" name="cve_refe" value="<? echo $cve_refe; ?>">
<input type="hidden" name="comentarios" value="<? echo $notas; ?>">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="2%" valign="center" align="left">
	   <a href="javascript: history.go(-1);"><?php echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
	  </td>
	  <td width="14%" valign="center" align="right">
	   <font class="chiquito">Número de Entrada:</font>
	  </td>
	  <td width="37%" valign="center" align="left">
	   <input type="text" name="fol_orig" value="<? echo $fol_orig; ?>" size=12 maxlength=10>&nbsp;&nbsp;
	   <?
	   echo "&nbsp;";
		 echo "<input type=\"button\" value=\"Buscar\" onClick=\"if (document.plantilla_documento.fol_orig.value!='') { eval(window.location='buscar_documento.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&&parametro='+document.plantilla_documento.fol_orig.value); };\">";
		 ?>
	   <a href="turnoDocumento.php?sess=<? echo $sess; ?>&fol_parametro=<? echo $fol_orig; ?>&control_botones_superior=1"><img src="<? echo $default->scg_graphics_url; ?>/turnador.gif" border=0 alt="Turnos"></a>
	   <?php
	   echo "<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento_consulta&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'><img src='$default->scg_graphics_url/bot_consulta.gif' border='0' alt='Detalle'></a>";
	   ?>
	  </td>
	  <td width="7%" valign="center" align="right">
	   <font class="chiquito">Acuse:</font>
	  </td>
	  <td width="25%" valign="center" align="left">
			<input type="text" name="fec_recep" value="<?php echo $fec_recep; ?>" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_recep');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
			&nbsp;
			<input type="text" name="hora_recep" value="<? echo $hora_recep; ?>" size=5 maxlength=5>
	  </td>
	  <td width=15%>
			<?php
			$letrero="";
			$sql = new scg_DB;
			$sql->query("select count(*) from docsal where fol_orig='$parametro'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$total_turnos = $sql->f("0");
				}
			}
			// NO REQUIEREN RESPUESTA SI cve_resp=''
			$sql = new scg_DB;
			$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp=''");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$total_no_requiere = $sql->f("0");
				}
			}
			// SI REQUIEREN RESPUESTA SI (CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S')
			// PENDIENTES SI CVE_RESP='N'
			$sql = new scg_DB;
			$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp='N'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$total_pendientes = $sql->f("0");
				}
			}
			// EN SEGUIMIENTO O TRAMITE SI cve_resp='A'
			$sql = new scg_DB;
			$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp='A'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$total_seguimiento = $sql->f("0");
				}
			}
			// RESUELTOS O CONCLUIDOS SI cve_resp='S'
			$sql = new scg_DB;
			$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp='S'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$total_concluidos = $sql->f("0");
				}
			}
			if ($total_turnos>0) {
				$letrero.="$total_turnos ";
				if ($total_turnos==1) {
					$letrero.="turno";
				} else {
					$letrero.="turnos";
				}
				if ($total_no_requiere>0) {
					$letrero.=" / $total_no_requiere ";
					if ($total_no_requiere==1) {
						$letrero.="no requiere respuesta";
					} else {
						$letrero.="no requieren respuesta";
					}
				}
				if ($total_pendientes>0) {
					$letrero.=" / $total_pendientes ";
					if ($total_pendientes==1) {
						$letrero.="pendiente";
					} else {
						$letrero.="pendientes";
					}
				}
				if ($total_seguimiento>0) {
					$letrero.=" / $total_seguimiento ";
					if ($total_seguimiento==1) {
						$letrero.="seguimiento";
					} else {
						$letrero.="seguimientos";
					}
				}
				if ($total_concluidos>0) {
					$letrero.=" / $total_concluidos ";
					if ($total_concluidos==1) {
						$letrero.="resuelto";
					} else {
						$letrero.="resueltos";
					}
				}
			}
			echo "<font class=\"alerta\">$letrero &nbsp;</b></font>";
	   		?>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="right">
		<font class="chiquito">Referencia:</font>
	  </td>
	  <td width="40%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="cve_docto" value="<? echo $cve_docto; ?>" size=30 maxlength=50>
	  </td>
	  <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right">
		<font class="chiquito">Elaboración:</font>
	  </td>
	  <td width="35%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="fec_elab" value="<?php echo $fec_elab; ?>" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_elab');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Promotor:</font>
	 </td>
	 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_prom" onChange="despliegaFirmantesFromPromotor(document.plantilla_documento,document.plantilla_documento.cve_prom.options[document.plantilla_documento.cve_prom.selectedIndex].value)">
	   <option value=0 selected>Seleccione el promotor ---------------------------</option>
	   <?php
	   $seleccionado='NO';
	   for($x = 0;$x <= $num_promotor; $x++) {
		  echo "<option value='$promotor_array0[$x]'";
		  if ($promotor_array0[$x]==str_replace(".","_",$cve_prom)) {
				echo " selected";
				$seleccionado='SI';
			}
		  echo ">$promotor_array1[$x]</option>\n";
	   }
	   if ($seleccionado!='SI' and $cve_prom) {
				//print("select nom_prom,cve_prom from promotor where tipo in ('P','Q') and cve_prom='$cve_prom'");
				$sql = new scg_DB;
				$sql->query("select nom_prom,cve_prom from promotor where tipo in ('P','Q') and cve_prom='$cve_prom'");
				$num = $sql->num_rows($sql);
				if ($num > 0) {
					while($sql->next_record()) {
						$nombre_p = $sql->f("nom_prom");
						$clave_p  = $sql->f("cve_prom");
						echo "<option value='$clave_p' selected>$nombre_p</option>\n";
					}
				}
		 }
	   ?>
	  </select>
	 </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Remitente:</font>
	 </td>
	 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_remite" onChange="despliegaFirmantesFromRemitente(document.plantilla_documento,document.plantilla_documento.cve_remite.options[document.plantilla_documento.cve_remite.selectedIndex].value)">
	   <option value=0 selected>Seleccione el Remitente ---------------------------</option>
	   <?php
	   $seleccionado='NO';
	   for($x = 0;$x <= $num_promotor; $x++) {
		  echo "<option value='$promotor_array0[$x]'";
		  if ($promotor_array0[$x]==str_replace(".","_",$cve_remite)) {
				echo " selected";
				$seleccionado='SI';
			}
		  echo ">$promotor_array1[$x]</option>\n";
	   }
	   if ($seleccionado!='SI' and $cve_remite) {
			$sql = new scg_DB;
			$sql->query("select nom_prom,cve_prom from promotor where tipo in ('R','Q') and cve_prom='$cve_remite'");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$nombre_p = $sql->f("nom_prom");
					$clave_p  = $sql->f("cve_prom");
					echo "<option value='$clave_p' selected>$nombre_p</option>\n";
				}
			}
		 }
	   ?>
	  </select>
	 </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Particular:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="nom_suje" value="<? echo $nom_suje; ?>" size=58 maxlength=60><input type="button" name="boton_domicilio" value="<?php if (substr($ok['ctrl_menu_sup'],1,1)=='1') {	echo 'Editar Domicilio'; } else { echo 'Ver Domicilio'; } ?>" onClick="newWindow('domicilio.php?sess=<? echo $sess; ?>',750,300,'CapturaDomicilio');"></td>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Firmado por:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="firmante" onChange='OtroFirmante(document.plantilla_documento,document.plantilla_documento.firmante.options[document.plantilla_documento.firmante.selectedIndex].value)'>
	  <?
	  if ($firmante=="") {
			echo "<option value=0>Seleccione el firmante ---------------------------</option>\n";
		} else {
			echo "<option value='$firmante' selected>$firmante</option>\n";
		}
		?>
		<option value=0>------------------------------------------------------------</option>
		<option value="OTRO">Capturar...</option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
	  </select>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Cargo:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="cargo_fmte" value="<? echo $cargo_fmte; ?>" size=100 maxlength=100>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Dirigido a:</font>
	 </td>
	 <td width="53%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_dirigido">
	   <option value=0 selected>Seleccione el destinatario -----------------------</option>
	   <?php
	   		$sql = new scg_DB;
			$sql->query("select nombre,clave from dirigido order by nombre,clave");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$nom_destinatario = $sql->f("nombre");
					$cve_destinatario = $sql->f("clave");
					echo "<option value='$cve_destinatario'";
				  if ($cve_destinatario==$cve_dirigido) {
						echo " selected";
					}
					echo ">$nom_destinatario</option>";
				}
			}

	   ?>
	  </select>
	 </td>
	 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	  <font class="chiquito">Antecedente:</font>
	 </td>
	 <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="antecedente" value="<? echo $antecedente; ?>" size=12 maxlength=10>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
    <tr>
     <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
      <font class="chiquito"><font class="chiquito">Expediente:</font></a>
     </td>
     <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
      <select name="cve_expe">
        <?php
        if ($cve_expe=='') {
					echo "\t<option value=0>Seleccione el expediente -------------------------</option>\n";
				}
				$sql = new scg_DB;
				$sql->query("select cve_expe,substr(nom_expe,0,90) as nom_expe from expediente order by cve_expe,nom_expe");
				$num = $sql->num_rows($sql);
				if ($num > 0) {
					while($sql->next_record()) {
						$cve_expe_menu = $sql->f("cve_expe");
						$nom_expe_menu = $sql->f("nom_expe");
						echo "\t<option value='$cve_expe_menu'";
						if ($cve_expe_menu==$cve_expe) echo " selected";
						echo ">$cve_expe_menu -> $nom_expe_menu</option>\n";
					}
				}
				?>
      </select>
 	   </td>
 	  </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Tipo:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_tipo">
	   <?php
	    if ($cve_tipo=="") {
		    echo "<option value=0 selected>Seleccione el tipo de documento</option>\n";
		 	}
		 	$sql = new scg_DB;
			$sql->query("select cve_ins,instruccion  from instruccion where tipo='D' order by instruccion");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_tipodocumento = $sql->f("cve_ins");
					$tipodocumento = $sql->f("instruccion");
					echo "<option value=$cve_tipodocumento";
					if ($cve_tipodocumento==$cve_tipo) {
						echo " selected";
					}
					echo ">$tipodocumento</option>";
				}
			}
	   ?>
	  </select>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="30%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquito">Clasificación:</font>&nbsp;&nbsp;<font class="chiquitito">(ctrl + mouse para selección múltiple)</font><br>
	   <select multiple name="cve_tema[]" size="4">
		 <?php
		 	$sql = new scg_DB;
			$sql->query("select cve_tema,topico from tema where tipo='T' order by topico");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_topico = $sql->f("cve_tema");
					$topico = $sql->f("topico");
					echo "<option value=$cve_topico";
					for ($x=0; $x<$total_temas; $x++) {
						if ($cve_topico==$cve_tema[$x]) {
							echo " selected";
						}
					}
					echo ">$topico</option>\n";
				}
			}
		?>
	   </select>
	 </td>
	 <td width="70%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquito">Asunto:</font><font class="chiquitito">&nbsp;&nbsp;(síntesis)</font><br>
	   <textarea name="txt_resum" wrap cols=70 rows=4><? echo $txt_resum; ?></textarea>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="7%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Evento:</font>
	 </td>
	 <td width="43%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_evento">
	  <option value=0>Seleccione el evento ---------------------------</option>
	   <?php
	   		$sql = new scg_DB;
			$sql->query("select cve_tema,topico from tema where tipo='E' order by topico");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_evento = $sql->f("cve_tema");
					$evento = $sql->f("topico");
					echo "<option value='$cve_evento'";
					if ($cve_evento==$cve_eve) {
						echo " selected";
					}
					echo ">$evento</option>\n";
				}
			}
	  ?>
	  <option value=0>Seleccione el evento ---------------------------</option>
	  </select>
	 </td>
	 <td width="13%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	  <font class="chiquito">Fecha del evento:</font>
	 </td>
	 <td width="37%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="fec_eve" value="<? echo $fec_eve; ?>" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_eve');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	  &nbsp;
	  <input type="text" name="hora_evento" value="<? echo $time_eve; ?>" size=5 maxlength=5>
	  &nbsp;
	  <font class="chiquitito">dd/mm/yyyy hh:mm (24hrs.)</font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="1" cellspacing="1" cellpadding="1">
	<tr>
	 <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	  <font class="chiquito">Reg:<br>
		 <?php
			if ($usua_doc=="") {
				echo $id_usuario;
			} else {
				echo $usua_doc;
			}
		 ?>
	 	</font>
	 </td>
	 <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	  <font class="chiquito">Mod:&nbsp;<?php echo $modifica; ?></font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="clasif" value=1 <? if ($clasif==1) {echo "checked"; }?>>&nbsp;
	  <font class="chiquito">Prioritario</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="nacional" value=1 <? if ($nacional==1) {echo "checked"; }?>>&nbsp;
	  <font class="chiquito">Intersecretarial</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="confi" value=1 <? if ($confi==1) {echo "checked"; }?>>&nbsp;
	  <font class="chiquito">Confidencial</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="salida" value=1 <? if ($salida==1) {echo "checked"; }?>>&nbsp;
	  <font class="chiquito">Salida</font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
		<?
		if (substr($ok["ctrl_menu_sup"],1,1)=='1') {
			echo "<input type='submit' name='guardar' value='Guardar Cambios'>";
		}
		?>
  </td>
 </tr>
</table>
</form>