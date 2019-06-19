<?
//INICIALIZACION DE VARIABLES
if (!$jaladatos) $jaladatos='nop';
$fecha_now=date("d/m/Y");
$hora_now =date("H:i");
$anio_now =date("Y");
$anio_origen=2000;
$alineacion_vertical="top";
$espaciado=1;
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
$fol_orig			= "";
$fec_regi			= "";
$fec_recep			= "";
$cve_docto			= "";
$fec_elab			= "";
$firmante			= "";
$cve_prom_ant		= "";
$cve_remit_ant		= "";
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
$si_hubo			= 'nop';
if ($jaladatos=='sip') {
	$sql = new scg_DB;
	$sql->query("select ultimo_folio from sesion_activa where sess_id='$sess'");
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$folio_jalado = $sql->f("0");
		}
	}
	if ($folio_jalado!="") {
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
		where fol_orig='$folio_jalado'";
		$sql = new scg_DB;
		$sql->query($query);
		if ($sql->next_record()) {
			$fol_orig			= $sql->f("0");
			$fec_regi			= $sql->f("1");
			$fec_recep			= $sql->f("2");
			$cve_docto			= $sql->f("3");
			$fec_elab			= $sql->f("4");
			$firmante			= $sql->f("5");
			$cve_prom_ant		= $sql->f("6");
			$cve_remit_ant		= $sql->f("7");
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
			$si_hubo			= 'sip';
		}
		if ($default->scg_tipo_folios=="1") { //folios manuales
			//modificación a la captura de folios manuales enero2003
			$anio_pal_folio =chop(substr(date("Y"),2,2));
			$particula=$anio_pal_folio."-";
			if (substr($fol_orig,0,3)==$particula) {
				$fol_orig=substr($fol_orig,3,(strlen($fol_orig)-3));
			}
		}
		$sql = new scg_DB;
		$sql->query("SELECT * from doctem where fol_orig='$folio_jalado'");
		$x=0;
		$total_temas=$sql->num_rows($sql);
		while ($sql->next_record()) {
			$cve_tema[$x] = $sql->f("cve_tema");
			$x++;
		}
	} else {
		$si_hubo='nop';
	}
}
if ($si_hubo!= 'sip') $jaladatos=='nop';
if (!$iovar) $iovar=1;
if ($jaladatos=='sip' && $salida==1) {
	$iovar=2;
} else {
	if ($jaladatos=='sip') {
		$iovar=1;
	}
}
?>
<script language="JavaScript" src="includes/isValidDate.js"></script>
<script language="JavaScript" src="includes/date-picker.js"></script>
<script language="JavaScript" src="includes/newWindow.js"></script>
<script language="JavaScript">
 self.name="CapturaDocumento";
function checa_si_se_puede() {
	<?
	switch ($iovar) {
		case 1:
			echo "document.plantilla_documento.salida.checked=false;";
		break;
		case 2:
			echo "document.plantilla_documento.salida.checked=true;";
		break;
	}
	?>
}
<?php
echo "\n\n";
echo "//-----------------------------------------------------------------------\n";
echo "//AQUI INICIA LA GENERACION DEL ARREGLO DE CARGOS\n";
echo "//-----------------------------------------------------------------------\n";
$x=0;
$sql = new scg_DB;
$sql->query("select distinct tit_prom,car_titu from promotor where tit_prom is not null and car_titu is not null group by tit_prom,car_titu order by tit_prom,car_titu");
$num_cargos = $sql->num_rows($sql);
echo "var num_titulares=$num_cargos;\n";
if ($num_cargos > 0) {
	while($sql->next_record()) {
		$x++;
		$tit_prom = $sql->f("tit_prom");
		$car_titu = $sql->f("car_titu");
		echo "titular$x= new titular('$tit_prom','$car_titu');\n";
	}
}
echo "//-----------------------------------------------------------------------\n";
echo "//FIN DE GENERACION DEL ARREGLO DE CARGOS\n";
echo "//-----------------------------------------------------------------------\n";
?>
function regform_Validator(f) {
	if (f.cual_submit.value=="GUARDAR") {
		<? if ($default->scg_tipo_folios=="1") { //manuales ?>
		if (f.fol_orig.value.length < 1) {
			alert("El folio del documento no debe ser nulo");
			f.fol_orig.focus();
			return(false);
		}
		<? } ?>
		fechaRecValida=isValidDate(f.fec_recep.value);
		if (f.hora_recep.value.length>0) {
			horaRecValida=isValidHour(f.hora_recep.value);
		}
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
		if (f.cve_prom.value==' ') {
			alert("Seleccione un promotor");
			f.cve_docto.focus();
			return(false);
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
			f.fec_elab.focus();
			return(false);
		}
		if (f.firmante.options[f.firmante.selectedIndex].value==0 || f.firmante.options[f.firmante.selectedIndex].value=="OTRO") {
			alert("El nombre de quien firma no debe ser nulo.\nPor favor selecione o introduzca el dato.");
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
}

function OtroFirmante(inForm,selected) {
	inForm.cargo_fmte.value="";
	for (var i=1; i <= num_titulares; i++) {
		cierto=eval("if (titular"+i+".titular=='"+selected+"') { true; } else { false; }");
		if (cierto) {
			inForm.cargo_fmte.value=eval("titular"+i+".cargo");
		}
	}
	if (selected=='OTRO') {
		descripcion='';
		while (descripcion=='') {
			<?
			switch ($iovar) {
				case 1:
					echo "descripcion=prompt('Firmado por:','');";
				break;
				case 2:
					echo "descripcion=prompt('Detinatario:','');";
				break;
			}
			?>
		}
		if (descripcion != null && descripcion != "") {
			inForm.firmante.options[(inForm.firmante.options.length-1)]=new Option(descripcion,descripcion,true,true);
		}
	}
}

function titular(titular,cargo) {
	this.titular=titular;
	this.cargo=cargo;
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
			$cve_prom_js	= str_replace(")","xx",$cve_prom_js);
			$promotor_array0[$i+1]=$cve_prom_js;
			$promotor_array1[$i+1]=$nom_prom;
			echo "var p".$cve_prom_js."Array =  new Array(\"('Seleccione el nombre -----------------------------','',true,true)\",\n";
			$i++;
			$sql2 = new scg_DB;
			$sql2->query("SELECT cve_prom,nom_prom,tit_prom from promotor where cve_prom='$cve_prom'");
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
			//$sql2->disconnect($sql2->Link_ID);
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
			$cve_prom_js	= str_replace(")","xx",$cve_prom_js);
			$remitente_array0[$i+1]=$cve_prom_js;
			$remitente_array1[$i+1]=$nom_prom;
			echo "var r".$cve_prom_js."Array =  new Array(\"('Seleccione el nombre -----------------------------','',true,true)\",\n";
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
			//$sql2->disconnect($sql2->Link_ID);
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
<form name="plantilla_documento" method="post" action="documentoBuscaGuarda.php?sess=<? echo $sess; ?>&control_botones_superior=1" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<script language="JavaScript">var captura=false;</script>
<?php
//ccedillo: INICIO agregado para controlar fechas y horas en la busqueda multiple
// TAMBIEN se agrego un evento javascript al ser modificados los valores
?>
<input type="hidden" name="control_fec_recep" value="">
<input type="hidden" name="control_hora_recep" value="">
<input type="hidden" name="control_fec_elab" value="">
<input type="hidden" name="fecha_now" value="<?php echo $fecha_now; ?>">
<input type="hidden" name="hora_now" value="<?php echo $hora_now; ?>">
<?php
//ccedillo: FIN agregado para controlar fechas y horas en la busqueda multiple
?>
<input type="hidden" name="cual_submit" value="">
<input type="hidden" name="control_ventana" value="">
<input type="hidden" name="domicilio" value="">
<input type="hidden" name="colonia" value="">
<input type="hidden" name="codigo_post" value="">
<input type="hidden" name="telefono" value="">
<input type="hidden" name="entidad" value="">
<input type="hidden" name="control_entidad" value="">
<input type="hidden" name="valor_entidad" value="">
<input type="hidden" name="delegacion" value="">
<input type="hidden" name="control_delegacion" value="">
<input type="hidden" name="valor_delegacion" value="">
<input type="hidden" name="comentarios" value="">
<input type="hidden" name="usua_doc" value="<? echo $id_usuario; ?>">
<input type="hidden" name="id_usuario" value="<? echo $id_usuario; ?>">
<input type="hidden" name="ventana_auxiliar" value="cerrada">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="25%" valign="<?php echo $alineacion_vertical; ?>" align="right"
	   <?
		if ($iovar==1) {
			if ($default->scg_tipo_folios=="1" && substr($control_menu_superior,1,1)=="1") { echo "bgcolor='#FFFFCC'>"; } else  { echo ">"; }
			echo "<a href='principal.php?sess=$sess&control_botones_superior=1&iovar=2'><img src='$default->scg_graphics_url/io.gif' border=0></a>&nbsp;";
			echo "<font class='chiquito'>Número de Entrada:</font>";
		} else {
			if ($default->scg_tipo_folios=="1"  && substr($control_menu_superior,1,1)=="1") { echo "bgcolor='#C6FFFF'>"; } else  { echo ">"; }
			echo "<a href='principal.php?sess=$sess&control_botones_superior=1&iovar=1'><img src='$default->scg_graphics_url/io.gif' border=0></a>&nbsp;";
			echo "<font class='chiquito'>Número de Salida:</font>";
		}
	   ?>
	  </td>
	  <td width="25%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<?
		if ($default->scg_tipo_folios=="1") { //manuales
		?>
	   		<input type="text" name="fol_orig" value="<? echo $fol_orig; ?>" size=12 maxlength=10 onChange="this.value=this.value.toUpperCase();">
		<?
		} else { //automaticos
			if (substr($control_menu_superior,1,1)=="1") {
				?>
				<input type="text" name="fol_orig" value="AUTOMATICO" size=12 maxlength=10 onFocus="if (this.value=='AUTOMATICO') { this.value=''; }"; onChange="this.value=this.value.toUpperCase();">
				<?
			} else {
				?>
				<input type="text" name="fol_orig" value="" size=12 maxlength=10 onChange="this.value=this.value.toUpperCase();">
				<?
			}
		}
		echo "&nbsp;";
		if (substr($control_menu_superior,1,1)=="1") {
		echo "<input type=\"button\" value=\"Buscar\" onClick=\"if (document.plantilla_documento.fol_orig.value!='' && document.plantilla_documento.fol_orig.value!='AUTOMATICO') { eval(window.location='buscar_documento.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&parametro='+document.plantilla_documento.fol_orig.value+'&anio_busqueda='+document.plantilla_documento.anio_busqueda.options[document.plantilla_documento.anio_busqueda.selectedIndex].value); };\">";
		}
		?>
	  </td>
	  <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	   <font class="chiquito">Acuse:</font>
	  </td>
	  <td width="35%" valign="<?php echo $alineacion_vertical; ?>" align="left">
			<input type="text" name="fec_recep" value="<?php echo $fecha_now; ?>" size=10 maxlength=10 onChange="document.plantilla_documento.control_fec_recep.value='modificado';"><a href="javascript:show_calendar('plantilla_documento.fec_recep');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
			&nbsp;
			<input type="text" name="hora_recep" value="<? echo $hora_now; ?>" size=5 maxlength=5 onChange="document.plantilla_documento.control_hora_recep.value='modificado';">
			<?
			if ($jaladatos=='sip') {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=1&iovar=$iovar&jaladatos=nop'><img src='$default->scg_graphics_url/copia.gif' border=0></a>";
			} else {
				echo "<a href='principal.php?sess=$sess&control_botones_superior=1&iovar=$iovar&jaladatos=sip'><img src='$default->scg_graphics_url/copia.gif' border=0></a>";
			}
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
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="right"
	  	<?
	  	if (substr($control_menu_superior,1,1)=="1") {
		switch ($iovar) {
		  	case 1:

		  		echo "bgcolor='#FFFFCC'>";
		  	break;
		  	case 2:
		  		echo "bgcolor='#C6FFFF'>";
		  	break;
		}
		} else {
			echo ">";
		}
		?>
		<font class="chiquito">Referencia:</font>
	  </td>
	  <td width="40%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="cve_docto" value="<?php echo $cve_docto; ?>" size=30 maxlength=50>
	  </td>
	  <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right"
	  	<?
	  	if (substr($control_menu_superior,1,1)=="1") {
		switch ($iovar) {
		  	case 1:
		  		echo "bgcolor='#FFFFCC'>";
		  	break;
		  	case 2:
		  		echo "bgcolor='#C6FFFF'>";
		  	break;
		}
		} else {
			echo ">";
		}
		?>
		<font class="chiquito">Elaboración:</font>
	  </td>
	  <td width="35%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<input type="text" name="fec_elab" value="<?php if ($jaladatos=='sip' && $si_hubo=='sip') { echo $fec_elab; } else { echo $fecha_now; } ?>" size=10 maxlength=10 onChange="document.plantilla_documento.control_fec_elab.value='modificado';"><a href="javascript:show_calendar('plantilla_documento.fec_elab');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
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
		  <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=1&origen=documento',900,500,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito">
		  	<?
			switch ($iovar) {
			  	case 1:
			  		echo "Promotor:";
			  	break;
			  	case 2:
			  		echo "Destinatario:";
			  	break;
			}
			?>
		  </font></a>
		 </td>
		 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <select name="cve_prom" onChange="despliegaFirmantesFromPromotor(document.plantilla_documento,document.plantilla_documento.cve_prom.options[document.plantilla_documento.cve_prom.selectedIndex].value)">
		   <option value=0 selected>
		   <?
		    switch ($iovar) {
		   	  	case 1:
		   	  		echo "Seleccione el promotor ---------------------------";
		   	  	break;
		   	  	case 2:
		   	  		echo "Seleccione la instancia destinataria -------------";
		   	  	break;
			}
			?>
		   </option>
		   <?php
		   for($x = 0;$x <= $num_promotor; $x++) {
			 	echo "<option value='$promotor_array0[$x]'";
			  if ($jaladatos=='sip' && $cve_prom_ant!="") {
			  	if ($promotor_array0[$x]==str_replace(")","xx",(str_replace(".","_",$cve_prom_ant)))) {
						echo " selected";
					}
				}
			 	echo ">$promotor_array1[$x]</option>\n";
		   }
		   ?>
		  </select>
		 </td>
		</tr>
		<tr>
		 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=1&origen=documento',900,500,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito">
		  	<?
			switch ($iovar) {
			  	case 1:
			  		echo "Remitente:";
			  	break;
			  	case 2:
			  		echo "";
			  	break;
			}
			?>
		  </font></a>
		 </td>
		 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <select name="cve_remite" onChange="despliegaFirmantesFromRemitente(document.plantilla_documento,document.plantilla_documento.cve_remite.options[document.plantilla_documento.cve_remite.selectedIndex].value)">
		   <option value=0>
		  	<?
			switch ($iovar) {
			  	case 1:
			  		echo "Seleccione el remitente -------------------------";
			  	break;
			  	case 2:
			  		echo "Seleccione la instancia destinataria ------------";
			  	break;
			}
			?>
		   </option>
		   <?php
		   for($x = 1;$x <= $num_remitente; $x++) {
					echo "<option value='$remitente_array0[$x]'";
					if ($jaladatos=='sip' && $cve_remit_ant!="") {
						if ($remitente_array0[$x]==str_replace(")","xx",(str_replace(".","_",$cve_prom_ant)))) {
							echo " selected";
						}
					}
					echo ">$remitente_array1[$x]</option>\n";
		   }
		   ?>
		  </select>
		 </td>
		</tr>
	   </table>
	  </td>
	  <td width="23%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <!--<textarea name="turnos" wrap cols=17 rows=2></textarea>-->
	   <br>
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
	  <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=9&origen=documento',600,500,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito">
	   	<?
	   	switch ($iovar) {
	   	  	case 1:
	   	  		echo "<font class='chiquito'>Dirigido a:</font>";
	   	  	break;
	   	  	case 2:
				echo "<font class='chiquito'>Remitente:</font>";
	   	  	break;
	   	}
		?>
	  </a>
	 </td>
	 <td width="53%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_dirigido">
	   <option value=0 selected>
	   	<?
	   	switch ($iovar) {
	   	  	case 1:
	   	  		echo "Seleccione el destinatario -----------------------";
	   	  	break;
	   	  	case 2:
				echo "Seleccione el área remitente ---------------------";
	   	  	break;
	   	}
		?>
	   </option>
	   <?php
	   		$sql = new scg_DB;
			$sql->query("select nombre,clave from dirigido order by nombre,clave");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$nom_destinatario = $sql->f("nombre");
					$cve_destinatario = $sql->f("clave");
					echo "<option value='$cve_destinatario'";
				  if ($jaladatos=='sip' && $cve_destinatario==$cve_dirigido) {
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
	  <font class="chiquito">Particular:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="nom_suje" size=58 maxlength=60><input type="button" name="boton_domicilio" value="Capturar Domicilio" onClick="javascript: this.value='Editar Domicilio'; newWindow('domicilio.php?sess=<? echo $sess; ?>&origen=capturar',750,300,'CapturaDomicilio');"></td>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left"
	  	<?
	  	if (substr($control_menu_superior,1,1)=="1") {
			switch ($iovar) {
				case 1:
					echo "bgcolor='#FFFFCC'><font class='chiquito'>Firmado por:</font>";
				break;
				case 2:
					echo "bgcolor='#C6FFFF'><font class='chiquito'>Dirigido a:</font>";
				break;
			}
		} else {
			switch ($iovar) {
				case 1:
					echo "><font class='chiquito'>Firmado por:</font>";
				break;
				case 2:
					echo "><font class='chiquito'>Dirigido a:</font>";
				break;
			}
		}
		?>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="firmante" onChange='OtroFirmante(document.plantilla_documento,document.plantilla_documento.firmante.options[document.plantilla_documento.firmante.selectedIndex].value)'>
		<?php
			if ($jaladatos=='sip' && $si_hubo=='sip') {
				echo "<option value='$firmante'>$firmante</option>\n";
			} else {
				echo "<option value=0>Seleccione el nombre -----------------------------</option>\n";
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
	  <input type="text" name="cargo_fmte" value="<? echo $cargo_fmte; ?>" size=60 maxlength=100>
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
	  <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=8&origen=documento',600,400,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito">Tipo:</font></a>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_tipo">
	   <?php
			echo "<option value=0>Seleccione el tipo de documento</option>";
			$sql = new scg_DB;
			$sql->query("select cve_ins,instruccion  from instruccion where tipo='D' order by instruccion");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_tipodocumento = $sql->f("cve_ins");
					$tipodocumento = $sql->f("instruccion");
					echo "<option value=$cve_tipodocumento";
					if ($jaladatos=='sip' && $cve_tipodocumento==$cve_tipo) {
						echo " selected";
					} else {
						if (strtoupper($tipodocumento)=="OFICIO") { //SSDF ... por default quieren que aparezca el OFICIO.
							echo "  selected";
						}
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
     <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
      <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=2&origen=documento',700,400,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito"><font class="chiquito">Expediente:</font></a>
     </td>
     <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
      <select name="cve_expe">
       <option value='999'>- Seleccione el expediente -------------------------</option>
        <?php
				$sql = new scg_DB;
				$sql->query("select cve_expe,substr(nom_expe,0,90) as nom_expe from expediente order by cve_expe,nom_expe");
				$num = $sql->num_rows($sql);
				if ($num > 0) {
					while($sql->next_record()) {
						$cve_expe = $sql->f("cve_expe");
						$nom_expe = $sql->f("nom_expe");
						echo "\t<option value='$cve_expe'>$cve_expe -> $nom_expe</option>\n";
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
	   <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=3&origen=documento',600,400,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito">Clasificación:</font></a><br><font size=-1>(ctrl + mouse para selección múltiple)</font><br>
	   <select multiple name="cve_tema[]" size="5">
		<?php
			$sql = new scg_DB;
			$sql->query("select cve_tema,topico from tema where tipo='T' order by topico");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$cve_topico = $sql->f("cve_tema");
					$topico = $sql->f("topico");
					echo "<option value=$cve_topico";
					if ($jaladatos=='sip') {
						for ($x=0; $x<$total_temas; $x++) {
							if ($cve_topico==$cve_tema[$x]) {
								echo " selected";
							}
						}
					}
					echo ">$topico</option>\n";
				}
			}
		?>
	   </select>
	 </td>
	 <td width="60%" valign="<?php echo $alineacion_vertical; ?>" align="left"
	  	<?
	  	if (substr($control_menu_superior,1,1)=="1") {
			switch ($iovar) {
				case 1:
					echo "bgcolor='#FFFFCC'>";
				break;
				case 2:
					echo "bgcolor='#C6FFFF'>";
				break;
			}
		} else {
			echo ">";
		}
		?>
	   <font class="chiquito">Asunto:</font><br><font size=-1>(síntesis)</font><br>
	   <textarea name="txt_resum" wrap cols=50 rows=4><?php echo $txt_resum; ?></textarea>
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
					echo "<option value='$cve_evento'";
					if ($jaladatos=='sip' && $cve_evento==$cve_eve) {
						echo " selected";
					}
					echo ">$evento</option>\n";
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
	  <input type="text" name="fec_eve" value="<? echo $fec_eve; ?>" size=10 maxlength=10><a href="javascript:show_calendar('plantilla_documento.fec_eve');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
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
   <table width="100%" border="1" cellspacing="1" cellpadding="1">
	<tr>
	 <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	  <font class="chiquito">Reg:<br><?php echo $id_usuario; ?></font>
	 </td>
	 <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	  <font class="chiquito">Mod:<br></font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="clasif" value=1 <? if ($clasif==1) {echo "checked"; }?>><br>
	  <font class="chiquito">Prioritario</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="nacional" value=1 <? if ($nacional==1) {echo "checked"; }?>><br>
	  <font class="chiquito">Intersecretarial</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="confi" value=1 <? if ($confi==1) {echo "checked"; }?>><br>
	  <font class="chiquito">Confidencial</font>
	 </td>
	 <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="center">
	  <input type="checkbox" name="salida" value=1 <? if ($iovar==2) echo "checked";?> onFocus="checa_si_se_puede();" onChange="checa_si_se_puede();" onSelect="checa_si_se_puede();"><br>
	  <font class="chiquito">Salida</font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
  <?
  if (substr($control_menu_superior,1,1)=="2") {
		echo "<input type='reset' name='limpiar' value='Limpiar Forma'>&nbsp;&nbsp;";
	}
	echo "<select name='anio_busqueda'>\n";
	$x=$anio_now;
	while ($x>=$anio_origen) {
		echo "<option value='$x'>$x</option>\n";
		$x--;
	}
	echo "<option value='9999'>TODOS</option>\n";
	echo "</select>\n";
	echo "<input type=\"submit\" name=\"buscar2\" value=\"Buscar\" onClick=\"document.plantilla_documento.cual_submit.value='BUSCAR'\">";
	//	echo "<input type=\"button\" name=\"buscar2\" value=\"Buscar\" onClick=\"eval(window.location='buscar_documento_complex.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&fol_orig='+document.plantilla_documento.fol_orig.value+'&domicilio='+document.plantilla_documento.domicilio.value+'&colonia='+document.plantilla_documento.colonia.value+'&codigo_post='+document.plantilla_documento.codigo_post.value+'&telefono='+document.plantilla_documento.telefono.value+'&entidad='+document.plantilla_documento.entidad.value+'&delegacion='+document.plantilla_documento.delegacion.value+'&comentarios='+document.plantilla_documento.comentarios.value+'&fec_recep='+document.plantilla_documento.fec_recep.value+'&hora_recep='+document.plantilla_documento.hora_recep.value+'&cve_docto='+document.plantilla_documento.cve_docto.value+'&fec_elab='+document.plantilla_documento.fec_elab.value+'&cve_prom='+document.plantilla_documento.cve_prom.value+'&cve_remite=&cve_dirigido='+document.plantilla_documento.cve_dirigido.value+'&antecedente='+document.plantilla_documento.antecedente.value+'&nom_suje='+document.plantilla_documento.nom_suje.value+'&firmante='+document.plantilla_documento.firmante.value+'&cargo_fmte='+document.plantilla_documento.cargo_fmte.value+'&cve_tipo='+document.plantilla_documento.cve_tipo.value+'&cve_tema='+document.plantilla_documento.cve_tema.options.length+'&txt_resum='+document.plantilla_documento.txt_resum.value+'&cve_evento='+document.plantilla_documento.cve_evento.value+'&cve_expe='+document.plantilla_documento.cve_expe.value+'&fec_eve='+document.plantilla_documento.fec_eve.value+'&hora_evento='+document.plantilla_documento.hora_evento.value+'&clasif='+document.plantilla_documento.clasif.checked+'&nacional='+document.plantilla_documento.nacional.checked+'&confi='+document.plantilla_documento.confi.checked+'&salida='+document.plantilla_documento.salida.checked+'&control_fec_recep='+document.plantilla_documento.control_fec_recep.value+'&control_hora_recep='+document.plantilla_documento.control_hora_recep.value+'&control_fec_elab='+document.plantilla_documento.control_fec_elab.value+'&fecha_now='+document.plantilla_documento.fecha_now.value+'&hora_now='+document.plantilla_documento.hora_now.value);\">";
	echo "&nbsp;";
	echo "&nbsp;";
  if (substr($control_menu_superior,1,1)=="1") { ?><input type="reset" name="limpiar" value="Limpiar Forma">&nbsp;&nbsp;<input type="submit" name="guardar" value="Guardar" onClick="document.plantilla_documento.cual_submit.value='GUARDAR'"><? }
  ?>
  </td>
 </tr>
</table>
</form>