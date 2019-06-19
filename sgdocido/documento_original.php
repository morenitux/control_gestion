<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$alineacion_vertical="top";
$espaciado=1;
?>
<script language="JavaScript" src="lib/isValidDate.js"></script>
<script language="JavaScript" src="lib/date-picker.js"></script>
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
	$sql = new scg_DB;
	$sql->query("select nom_prom,cve_prom from promotor where tipo in ('P','Q') order by nom_prom,cve_prom");
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
			$sql2->query("SELECT cve_prom, siglas, nom_prom, tit_prom, tipo, domicilio, colonia, delegacion, codigo_post, entidad, telefono, car_titu from promotor where cve_prom='$cve_prom'");
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
	$sql->query("select nom_prom,cve_prom from promotor where tipo in ('R','Q') order by nom_prom,cve_prom");
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
			$sql2->query("SELECT cve_prom, siglas, nom_prom, tit_prom, tipo, domicilio, colonia, delegacion, codigo_post, entidad, telefono, car_titu from promotor where cve_prom='$cve_prom'");
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
<form name="plantilla_documento" method="post" action="insertDocumento.php" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<script language="JavaScript">var captura=false;</script>
<input type="hidden" name="control_ventana" value="">
<input type="hidden" name="domicilio" value="">
<input type="hidden" name="colonia" value="">
<input type="hidden" name="codigo_post" value="">
<input type="hidden" name="telefono" value="">
<input type="hidden" name="entidad" value="">
<input type="hidden" name="delegacion" value="">
<input type="hidden" name="comentarios" value="">
<input type="hidden" name="usua_doc" value="<? echo $id_usuario; ?>">
<input type="hidden" name="id_usuario" value="<? echo $id_usuario; ?>">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquito">Folio:</font>
	  </td>
	  <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <input type="text" name="fol_orig" size=10 maxlength=10 onFocus="this.blur();">
	  </td>
	  <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	   <font class="chiquito">Fecha de registro:</font>
	  </td>
	  <td width="17%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <input type="text" name="fec_regi" value="<?php echo $fecha_now; ?>" size=10 maxlength=10 onFocus="this.blur();">
	  </td>
	  <td width="13%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	   <font class="chiquito">Referencia:</font>
	  </td>
	  <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <input type="text" name="referencia" size=10 maxlength=10>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="2" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Acuse:</font>
	  </td>
	  <td width="28%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="fec_recep" value="<?php echo $fecha_now; ?>" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_recep');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
		&nbsp;
		<input type="text" name="hora_recep" value="<?php echo $hora_now; ?>" size=5 maxlength=5>
	  </td>
	  <td width="8%" valign="<?php echo $alineacion_vertical; ?>" align="right">
		<font class="chiquito">Docto.:</font>
	  </td>
	  <td width="23%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="cve_docto" size=10 maxlength=30>
	  </td>
	  <td width="13%" valign="<?php echo $alineacion_vertical; ?>" align="right">
		<font class="chiquito">Elaboración:</font>
	  </td>
	  <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="fec_elab" value="<?php echo $fecha_now; ?>" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_elab');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="77%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
		<tr>
		 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <font class="chiquito">Promotor:</font>
		 </td>
		 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <select name="cve_prom" onChange="despliegaFirmantesFromPromotor(document.plantilla_documento,document.plantilla_documento.cve_prom.options[document.plantilla_documento.cve_prom.selectedIndex].value)">
		   <option value=0 selected>Seleccione el promotor ---------------------------</option>
		   <?php
		   for($x = 1;$x <= $num_promotor; $x++) {
			  echo "<option value='$promotor_array0[$x]'>$promotor_array1[$x]</option>\n";
		   }
		   ?>
		  </select>
		 </td>
		</tr>
		<tr>
		 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <font class="chiquito">Remitente:</font>
		 </td>
		 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <select name="cve_remite" onChange="despliegaFirmantesFromRemitente(document.plantilla_documento,document.plantilla_documento.cve_remite.options[document.plantilla_documento.cve_remite.selectedIndex].value)">
		   <option value=0>Seleccione el remitente -------------------------</option>
		   <?php
		   for($x = 1;$x <= $num_remitente; $x++) {
			   echo "<option value='$remitente_array0[$x]'>$remitente_array1[$x]</option>\n";
		   }
		   ?>
		  </select>
		 </td>
		</tr>
	   </table>
	  </td>
	  <td width="23%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <textarea name="turnos" wrap cols=17 rows=2></textarea>
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
					echo "<option value='$cve_destinatario'>$nom_destinatario</option>";
				}
			}

	   ?>
	  </select>
	 </td>
	 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	  <font class="chiquito">Antecedente:</font>
	 </td>
	 <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="antecedente" size=14 maxlength=14>
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
	  <input type="text" name="particular" onFocus="javascript: if (captura) { this.blur(); }" size=58 maxlength=60><input type="button" name="boton_domicilio" value="Capturar Completo" onClick="javascript: if (!captura) { document.plantilla_documento.particular.value=''; captura=true; this.value='Capturar Abreviado'; newWindow('plantilla_domicilio.php',750,300,'CapturaDomicilio') } else { document.plantilla_documento.particular.value=''; captura=false; this.value='Capturar Completo' }"></td>
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
	  <font class="chiquito">Firmante:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="firmante" onChange='OtroFirmante(document.plantilla_documento,document.plantilla_documento.firmante.options[document.plantilla_documento.firmante.selectedIndex].value)'>
		<option value=0>Seleccione el firmante ---------------------------</option>
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
	  <input type="text" name="cargo_fmte" size=60 maxlength=100>
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
	  <font class="chiquito">Expediente:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_expe">
	   <option value=0>Seleccione el expediente -------------------------</option>
		<?php
			$sql = new scg_DB;
			$sql->query("select cve_expe,nom_expe from expediente order by cve_expe,nom_expe");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_expe = $sql->f("cve_expe");
					$nom_expe = $sql->f("nom_expe");
					echo "<option value='$cve_expe'>$cve_expe -> $nom_expe</option>";
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
	 <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Tipo:</font>
	 </td>
	 <td width="80%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_tipo">
	  <option value=0 selected>Seleccione el tipo de documento</option>
	   <?php


			$sql = new scg_DB;
			$sql->query("select cve_ins,instruccion  from instruccion where tipo='D' order by instruccion");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_tipodocumento = $sql->f("cve_ins");
					$tipodocumento = $sql->f("instruccion");
					echo "<option value=$cve_tipodocumento>$tipodocumento</option>";
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
	 <td width="40%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquito">Temas:</font> <font size=-1>(ctrl + mouse para selección múltiple)</font><br>
	   <select multiple name="cve_tema[]" size="5">
		<?php

			$sql = new scg_DB;
			$sql->query("select cve_tema,topico from tema where tipo='T' order by topico");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_tema = $sql->f("cve_tema");
					$topico = $sql->f("topico");
					echo "<option value=$cve_tema>$topico</option>";
				}
			}
		?>
	   </select>
	 </td>
	 <td width="60%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquito">Asunto:</font><br>
	   <textarea name="txt_resum" wrap cols=50 rows=4></textarea>
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
	  <font class="chiquito">Evento:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_evento">
	  <option value=0 selected>Seleccione el evento ---------------------------</option>
	   <?php
			$sql = new scg_DB;
			$sql->query("select cve_tema,topico from tema where tipo='E' order by topico");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_evento = $sql->f("cve_tema");
					$evento = $sql->f("topico");
					echo "<option value=$cve_evento>$evento</option>";
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
	 <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Fecha del evento:</font>
	 </td>
	 <td width="80%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="fec_eve" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_eve');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	  &nbsp;
	  <input type="text" name="hora_evento" value="" size=5 maxlength=5>
	  &nbsp;
	  <font size=-1>dd/mm/yyyy hh:mm (24hrs.)</font>
	 </td>
	</tr>
   </table>

  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="2" cellspacing="1" cellpadding="1">
	<tr>
	 <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	  <font class="chiquito">Reg:<br><?php echo $id_usuario; ?></font>
	 </td>
	 <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	  <font class="chiquito">Mod:<br></font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="salida" value=1><br>
	  <font class="chiquito">Salida</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="clasif" value=1><br>
	  <font class="chiquito">Relevante</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="nacional" value=1><br>
	  <font class="chiquito">Internacional</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="confi" value=1><br>
	  <font class="chiquito">Confidencial</font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <input type="reset" name="limpiar" value="Limpiar Forma"> <input type="submit" name="guardar" value="Guardar">
  </td>
 </tr>
</table>
</form>