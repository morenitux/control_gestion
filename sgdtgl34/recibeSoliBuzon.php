<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$alineacion_vertical="top";
$espaciado=1;
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
$fol_orig		= "";
$conse			= "";
$fec_salid		= "";
$fec_comp		= "";
$remite			= "";
$cve_urge		= "";
$sintesis		= "";
$cve_docto		= "";
$fec_elab		= "";
$base_datos		= "";
$prop_base		= "";
$dirigido		= "";
$firmante		= "";
$cargo_fmte		= "";
$promotor		= "";
$particular		= "";
$expediente		= "";
$tipo_docto		= "";
$evento			= "";
$fec_eve		= "";
$time_eve		= "";
$nacional		= "";
$domicilio		= "";
$colonia		= "";
$delegacion		= "";
$codigo_post	= "";
$entidad		= "";
$telefono		= "";

$arreglo			= explode("-",$parametro);
$num_cachos			= count($arreglo);
if ($num_cachos>2) {
	$fol_parametro		= $arreglo[0]."-".$arreglo[1];
	$conse_parametro	= $arreglo[2];
} else {
	$fol_parametro		= $arreglo[0];
	$conse_parametro	= $arreglo[1];
}
$sql = new scg_DB;
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
	$sql = new scg_DB;
	$sql->query("select clave from depe_buzon where tipo_reg='P' and base_datos='$base_datos' and prop_base='$prop_base'");
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$cve_remite = $sql->f("clave");
		}
		if ($cve_remite) {
			$sql = new scg_DB;
			$sql->query("select nom_prom from promotor where cve_prom='$cve_remite'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$nom_remitente = $sql->f("nom_prom");
				}
			}
		}
	}
	if ($promotor) {
		$promotor_lower=$promotor;
		$promotor_upper=strtoupper($promotor);
		$sql = new scg_DB;
		$sql->query("select cve_prom from promotor where tipo in ('P','Q') and (upper(nom_prom) like '$promotor_upper' or nom_prom like '$promotor_lower')");
		if ($sql->num_rows($sql) == 1) {
			while($sql->next_record()) {
				$cve_prom_ant = $sql->f("0");
			}
		}
	}
	if ($tipo_docto) {
		$tipo_docto_lower=$tipo_docto;
		$tipo_docto_upper=strtoupper($tipo_docto);
		$sql = new scg_DB;
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
		$sql = new scg_DB;
		$sql->query("select cve_tema from tema where tipo='E' and (upper(topico) like '$evento_upper' or topico like '$evento_lower')");
		if ($sql->num_rows($sql) == 1) {
			while($sql->next_record()) {
				$cve_eve = $sql->f("0");
			}
		}
	}
}

?>
<script language="JavaScript" src="includes/isValidDate.js"></script>
<script language="JavaScript" src="includes/date-picker.js"></script>
<script language="JavaScript" src="includes/newWindow.js"></script>
<script language="JavaScript">
 self.name="CapturaDocumento";
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
			echo "descripcion=prompt('Firmado por:','');";
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
		}
	}

 ?>
 function despliegaFirmantesFromPromotor(inForm,selected) {
	if (selected!=0) {
		var selectedArray = eval("p" + selected + "Array");
		while (selectedArray.length < inForm.firmante.options.length) {
			inForm.firmante.options[(inForm.firmante.options.length - 1)] = null;
		}
		for (var i=0; i < selectedArray.length; i++) {
			eval("inForm.firmante.options[i]=" + "new Option" + selectedArray[i]);
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
<form name="plantilla_documento" method="post" action="insertDocumentoDeBuzon.php?sess=<? echo $sess; ?>&control_botones_superior=7" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<script language="JavaScript">var captura=false;</script>

<? /*este hidden es para la secretaria de salud porque se va a conservar exactamente el número asignado por la oficialia de partes*/ ?>
<input type="hidden" name="folio_en_origen" value="<? echo $fol_orig; ?>">
<input type="hidden" name="conse_en_origen" value="<? echo $conse; ?>">
<? /*fin hidden para la secretaria de salud porque se va a conservar exactamente el número asignado por la oficialia de partes*/ ?>

<? /*estos son para enviar base de datos y propietario*/ ?>
<input type="hidden" name="base_datos" value="<? echo $base_datos; ?>">
<input type="hidden" name="prop_base" value="<? echo $prop_base; ?>">
<? /*fin para enviar base de datos y propietario*/ ?>

<input type="hidden" name="cve_remite" value="<? echo $cve_remite; ?>">
<input type="hidden" name="cve_docto" value="<? echo $cve_docto; ?>">
<input type="hidden" name="fec_elab" value="<? echo $fec_elab; ?>">
<input type="hidden" name="control_ventana" value="">
<input type="hidden" name="domicilio" value="<? echo $domicilio; ?>">
<input type="hidden" name="colonia" value="<? echo $colonia; ?>">
<input type="hidden" name="codigo_post" value="<? echo $codigo_post; ?>">
<input type="hidden" name="telefono" value="<? echo $telefono; ?>">
<input type="hidden" name="entidad" value="">
<input type="hidden" name="control_entidad" value="">
<input type="hidden" name="valor_entidad" value="<? echo $entidad; ?>">
<input type="hidden" name="delegacion" value="">
<input type="hidden" name="control_delegacion" value="">
<input type="hidden" name="valor_delegacion" value="<? echo $delegacion; ?>">
<input type="hidden" name="comentarios" value="">
<input type="hidden" name="usua_doc" value="<? echo $id_usuario; ?>">
<input type="hidden" name="id_usuario" value="<? echo $id_usuario; ?>">
<input type="hidden" name="ventana_auxiliar" value="cerrada">
<table width=100% border=0 cellspacing=2 cellpadding=2>
 <tr>
  <td width=100% align=left>
		<font class='chiquito'>Regresar</font>&nbsp;<a href="javascript: history.go(-1);"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
  </td>
 </tr>
</table>
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Referencia:</font>
	  </td>
	  <td width="35%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="alerta">
		<?php echo $fol_parametro; ?>
		</font>
	  </td>
	  <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Referencia 2:</font>
	  </td>
	  <td width="35%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="alerta">
		<?php echo $cve_docto; ?>
		</font>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	 <tr>
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Remitente:</font>
	  </td>
	  <td width="90%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  	<font class="alerta">
		<?php echo $nom_remitente; ?>
		</font>
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
	  		echo "Promotor:";
			?>
		  </font></a>
		 </td>
		 <td width="85%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <select name="cve_prom" onChange="despliegaFirmantesFromPromotor(document.plantilla_documento,document.plantilla_documento.cve_prom.options[document.plantilla_documento.cve_prom.selectedIndex].value)">
		   <?php
			for($x = 0;$x <= $num_promotor; $x++) {
				echo "<option value='$promotor_array0[$x]'";
				if ($cve_prom_ant!="") {
					if ($promotor_array0[$x]==str_replace(".","_",$cve_prom_ant)) {
						echo " selected";
						$ya_seleccione_algo='SI';
					}
				}
				echo ">$promotor_array1[$x]</option>\n";
			}
			if ($ya_seleccione_algo!='SI') {
				echo "<option value=0 selected>Seleccione el promotor ---------------------------</option>\n";
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
 	  	echo "<font class='chiquito'>Dirigido a:</font>";
		?>
	  </a>
	 </td>
	 <td width="53%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="cve_dirigido">
	   <option value=0 selected>
	   	<?
		echo "Seleccione el destinatario -----------------------";
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
	  <font class="chiquito">Particular:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <input type="text" name="nom_suje" value="<? echo $particular; ?>" size=58 maxlength=60><input type="button" name="boton_domicilio" value="Capturar Domicilio" onClick="javascript: this.value='Editar Domicilio'; newWindow('domicilio.php?sess=<? echo $sess; ?>&origen=capturar',750,300,'CapturaDomicilio');"></td>
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
  		echo "><font class='chiquito'>Firmado por:</font>";
		?>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <select name="firmante" onChange='OtroFirmante(document.plantilla_documento,document.plantilla_documento.firmante.options[document.plantilla_documento.firmante.selectedIndex].value)'>
		<?php
			if ($firmante) {
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
					if ($cve_tipodocumento==$cve_tipo) {
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
	 <td width="60%" valign="<?php echo $alineacion_vertical; ?>" align="left"
	  	<?
  		echo ">";
		?>
	   <font class="chiquito">Asunto:</font><br><font size=-1>(síntesis)</font><br>
	   <textarea name="txt_resum" wrap cols=50 rows=4><?php echo $sintesis; ?></textarea>
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
       <option value=0>- Seleccione el expediente -------------------------</option>
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
					$evento 	= $sql->f("topico");
					echo "<option value='$cve_evento'";
					if ($cve_evento==$cve_eve) {
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
	  <input type="text" name="hora_evento" value="<? echo $time_eve; ?>" size=5 maxlength=5>
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
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <?
	echo "&nbsp;";
   ?>
   <input type="reset" name="limpiar" value="Limpiar Forma">&nbsp;&nbsp;<input type="submit" name="guardar" value="Guardar">
  </td>
 </tr>
</table>
</form>
