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

$arreglo				= explode("-",$parametro);
$num_cachos				= count($arreglo);
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
		$sintesis			= $sql->f("sintesis");
		$base_datos			= $sql->f("base_datos");
		$prop_base			= $sql->f("prop_base");
		$sintesis			= ereg_replace("\n","<br>",$sintesis);
	}
	$sql->query("select clave from depe_buzon where tipo_reg='P' and base_datos='$base_datos' and prop_base='$prop_base'");
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
}
?>
<script language="JavaScript" src="includes/isValidDate.js"></script>
<script language="JavaScript" src="includes/date-picker.js"></script>
<script language="JavaScript" src="includes/newWindow.js"></script>
<script language="JavaScript">
 self.name="CapturaDocumento";
function regform_Validator(f) {
	var largo_maximo=2000;
	if (f.rechazo.value.length > largo_maximo) {
		alert("El tamaño máximo de este campo es de "+largo_maximo+" caracteres. Por favor reduzca su texto.");
		f.rechazo.focus();
		return(false);
	}
	if (f.rechazo.value.length<1) {
		alert("Introduzca el texto que justifique el rechazo del envío");
		f.rechazo.focus();
		return(false);
	}
}
 //  End -->
</script>
<form name="rechaza_documento" method="post" action="insertRechazoDeBuzonDocumento.php?sess=<? echo $sess; ?>&control_botones_superior=1" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<input type="hidden" name="folio_en_origen" value="<? echo $fol_orig; ?>">
<input type="hidden" name="conse_en_origen" value="<? echo $conse; ?>">
<input type="hidden" name="base_datos" value="<? echo $base_datos; ?>">
<input type="hidden" name="prop_base" value="<? echo $prop_base; ?>">
<script language="JavaScript">var captura=false;</script>
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
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Referencia:</font>
	  </td>
	  <td width="90%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="alerta">
		<?php echo $fol_parametro; ?>
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
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Asunto:</font><br><font size=-1>(síntesis)</font><br>
	  </td>
	  <td width="90%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="alerta">
		<?php echo $sintesis; ?>
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
		<font class="chiquito">Rechazo:</font>
	  </td>
	  <td width="90%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="alerta">
		<textarea name="rechazo" wrap cols=50 rows=4>El asunto no compete a esta dependencia.</textarea>
		</font>
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