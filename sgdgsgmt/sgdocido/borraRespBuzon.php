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
$sql->query("select fol_orig, conse, to_char(fec_salid,'dd/mm/yyyy') as fec_salid, remite, sintesis, cve_docto, to_char(fec_elab,'dd/mm/yyyy') as fec_elab, base_datos, prop_base, folio_remite, conse_remite, plazo, viable, to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica, cve_resp, etapas, to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu, califresp, to_char(fec_compro,'dd/mm/yyyy') as fec_compro from resp_buzon where fol_orig='$fol_parametro' and conse='$conse_parametro'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$fol_orig		= $sql->f("fol_orig");
		$conse			= $sql->f("conse");
		$fec_salid		= $sql->f("fec_salid");
		$remite			= $sql->f("remite");
		$sintesis		= $sql->f("sintesis");
		$cve_docto		= $sql->f("cve_docto");
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
		$sintesis			= ereg_replace("\n","<br>",$sintesis);
	}
	$sql->query("select clave from depe_buzon where tipo_reg='D' and base_datos='$base_datos' and prop_base='$prop_base'");
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$cve_remite = $sql->f("clave");
		}
		if ($cve_remite) {
			$sql->query("select nom_depe from dependencia where cve_depe='$cve_remite'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$nom_remitente = $sql->f("nom_depe");
				}
			}
		}
	}
}
//$sql->disconnect($sql->Link_ID);
?>
<script language="JavaScript">
 self.name="CapturaDocumento";
function regform_Validator(f) {

}
 //  End -->
</script>
<form name="borra_documento_buzon" method="post" action="insertRechazoDeBuzonRespuesta.php?sess=<? echo $sess; ?>&control_botones_superior=1&accion=borrar&control=<? echo $control; ?>&parametro=<? echo $parametro; ?>" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
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
		<font class="chiquito">Dependencia:</font>
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
		<font class="chiquito">Respuesta:</font><br><font size=-1>(síntesis)</font><br>
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
   <?
	echo "&nbsp;";
   ?>
   <input type="submit" name="guardar" value="Eliminar">
  </td>
 </tr>
</table>
</form>