<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$alineacion_vertical="top";
$espaciado=1;
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
self.name="ConsolaImpresion";
function regform_Validator(f) {

}
function limpia_filtro() {
	document.consola_impresion.clasif.checked=false;
	document.consola_impresion.nacional.checked=false;
	document.consola_impresion.confi.checked=false;
	document.consola_impresion.salida.checked=false;
}
function checa_si_se_puede() {
	if (document.consola_impresion.grueso.value!=1) {
		limpia_filtro();
	}
}
//  End -->
</script>
<?
if ($tipo_reporte!="" && $fechas!="") {
	print("<body onLoad=\"newWindow('genera_reporte.php?sess=$sess&control_botones_superior=7&tipo_reporte=$tipo_reporte&fechas=$fechas&fecha1=$fecha1&fecha2=$fecha2&grueso=$grueso&clasif=$clasif&nacional=$nacional&confi=$confi&salida=$salida',800,600,'ReportePDF');\">");
}
?>
<form name="consola_impresion" method="post" action="principal.php?sess=<? echo $sess; ?>&control_botones_superior=7" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.consola_impresion.fec_recep.focus(); document.consola_impresion.fec_recep.select();">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="30%" valign="top" align="right">
   <font class='chiquito'>Tipo de reporte:</font>
  </td>
  <td width="70%" valign="top" align="left">
   <select name="tipo_reporte">
    <option value="1" selected>Documentos recibidos</option>
    <option value="2">Documentos turnados</option>
    <!--<option value="3">Turnos concluidos</option>-->
    <!--<option value="4">Turnos pendientes</option>-->
   </select>
  </td>
 </tr>
 <tr>
  <td width="30%" valign="top" align="right">
   <font class='chiquito'>Fecha(s):</font>
  </td>
  <td width="70%" valign="top" align="left">
   <select name="fechas" onChange="if (document.consola_impresion.fechas[document.consola_impresion.fechas.selectedIndex].value!='4') { document.consola_impresion.fecha1.value=''; document.consola_impresion.fecha2.value=''; } else { if (document.consola_impresion.fecha1.value=='') { document.consola_impresion.fecha1.value='<? echo $fecha_now; ?>'; } if (document.consola_impresion.fecha2.value=='') { document.consola_impresion.fecha2.value='<? echo $fecha_now; ?>'; }}">
    <option value="1" selected>Hoy</option>
    <option value="2">Esta semana</option>
    <option value="3">Este mes</option>
    <option value="4">Periodo determinado</option>
   </select>
   &nbsp;
   <font class='chiquito'>De:</font>
   <input type="text" name="fecha1" value="" onFocus="if (document.consola_impresion.fechas[document.consola_impresion.fechas.selectedIndex].value!='4') { this.blur(); }" size=10 maxlength=10><a href="javascript:show_calendar('consola_impresion.fecha1');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
   &nbsp;
   <font class='chiquito'>a:</font>
   <input type="text" name="fecha2" value="" onFocus="if (document.consola_impresion.fechas[document.consola_impresion.fechas.selectedIndex].value!='4') { this.blur(); }" size=10 maxlength=10><a href="javascript:show_calendar('consola_impresion.fecha2');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
   &nbsp;
   &nbsp;
  </td>
 </tr>
 <tr valign="top">
  <td align=right>
   <font class='chiquito'>A partir del folio No.:</font>
  </td>
  <td>
   <input type="text" name="apartir" value="" size=10 maxlength=10>
  </td>
 </tr>
 <tr>
  <td width="30%" valign="top" align="right">
   <font class='chiquito'>Filtro:</font>
  </td>
  <td width="70%" valign="top" align="left">
   <table width="100%" border=0 cellpadding="0" cellspacing="0">
    <tr valign="top">
     <td>
       <input type ="radio" name="grueso" value="0" checked onClick="if (document.consola_impresion.grueso[0].checked) { document.consola_impresion.grueso.value=0; limpia_filtro(); }">Todos los registros
	   </td>
	   <td>
	    <input type ="radio" name="grueso" value="1" onClick="if (document.consola_impresion.grueso[1].checked) { document.consola_impresion.grueso.value=1; }">Sólo:<br>
	    <input type="checkbox" name="clasif" value=1 onFocus="checa_si_se_puede();" onChange="checa_si_se_puede();" onSelect="checa_si_se_puede();">&nbsp;
	    <font class="chiquito">Prioritarios</font><br>
	    <input type="checkbox" name="nacional" value=1 onFocus="checa_si_se_puede();" onChange="checa_si_se_puede();" onSelect="checa_si_se_puede();">&nbsp;
	    <font class="chiquito">Intersecretariales</font><br>
	    <input type="checkbox" name="confi" value=1 onFocus="checa_si_se_puede();" onChange="checa_si_se_puede();" onSelect="checa_si_se_puede();">&nbsp;
	    <font class="chiquito">Confidenciales</font><br>
	    <input type="checkbox" name="salida" value=1 onFocus="checa_si_se_puede();" onChange="checa_si_se_puede();" onSelect="checa_si_se_puede();">&nbsp;
	    <font class="chiquito">Salidas</font>
	   </td>
	  </tr>
	 </table>
  </td>
 </tr>
</table>
<br>
<input type="submit" name="guardar" value="Generar Reporte">
</form>
