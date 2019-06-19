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
//$sql->disconnect($sql->Link_ID);
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
	print("<body onLoad=\"newWindow('genera_reporte.php?sess=$sess&control_botones_superior=9&tipo_reporte=$tipo_reporte&fechas=$fechas&fecha1=$fecha1&fecha2=$fecha2&grueso=$grueso&clasif=$clasif&nacional=$nacional&confi=$confi&apartir=$apartir',800,600,'ReportePDF');\">");
}
?>
<form name="consola_impresion" method="post" action="principal.php?sess=<? echo $sess; ?>&control_botones_superior=9" target="_self" onsubmit="return regform_Validator(this);" onLoad="javascript: document.consola_impresion.fec_recep.focus(); document.consola_impresion.fec_recep.select();">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="30%" valign="top" align="right">
   <font class='chiquito'>Tipo de reporte:</font>
  </td>
  <td width="70%" valign="top" align="left">
   <select name="tipo_reporte">
    <option value="2" <? if ($tipo_reporte==2 || $tipo_reporte=='') { echo ' selected'; } ?>>ENTRADAS: Control de entrega (originales)</option>
    <option value="3" <? if ($tipo_reporte==3) echo ' selected'; ?>>ENTRADAS: Control de entrega (copias)</option>
    <option value="1" <? if ($tipo_reporte==1) echo ' Selected'; ?>>ENTRADAS: Documentos recibidos</option>
    <option value="4" <? if ($tipo_reporte==4) echo ' Selected'; ?>>SALIDAS: Relación de salidas</option>
   </select>
  </td>
 </tr>
 <tr>
  <td width="30%" valign="top" align="right">
   <font class='chiquito'>Fecha(s):</font>
  </td>
  <td width="70%" valign="top" align="left">
   <select name="fechas" onChange="if (document.consola_impresion.fechas[document.consola_impresion.fechas.selectedIndex].value!='4') { document.consola_impresion.fecha1.value=''; document.consola_impresion.fecha2.value=''; } else { if (document.consola_impresion.fecha1.value=='') { document.consola_impresion.fecha1.value='<? echo $fecha_now; ?>'; } if (document.consola_impresion.fecha2.value=='') { document.consola_impresion.fecha2.value='<? echo $fecha_now; ?>'; }}">
    <option value="1" <? if ($fechas=='' || $fechas==1) echo ' selected'; ?>>Hoy</option>
    <option value="2" <? if ($fechas==2) echo ' selected'; ?>>Esta semana</option>
    <option value="3" <? if ($fechas==3) echo ' selected'; ?>>Este mes</option>
    <option value="4" <? if ($fechas==4) echo ' selected'; ?>>Periodo determinado</option>
   </select>
   &nbsp;
   <font class='chiquito'>De:</font>
   <input type="text" name="fecha1" value="<? if ($fechas==4 && $fecha1!='') { echo $fecha1; } else { echo ''; } ?>" onFocus="if (document.consola_impresion.fechas[document.consola_impresion.fechas.selectedIndex].value!='4') { this.blur(); }" size=10 maxlength=10><a href="javascript:show_calendar('consola_impresion.fecha1');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
   &nbsp;
   <font class='chiquito'>a:</font>
   <input type="text" name="fecha2" value="<? if ($fechas==4 && $fecha2!='') { echo $fecha2; } else { echo ''; } ?>" onFocus="if (document.consola_impresion.fechas[document.consola_impresion.fechas.selectedIndex].value!='4') { this.blur(); }" size=10 maxlength=10><a href="javascript:show_calendar('consola_impresion.fecha2');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
   &nbsp;
   &nbsp;
  </td>
 </tr>
 <tr valign="top">
  <td align=right>
   <font class='chiquito'>A partir del folio No.:</font>
  </td>
  <td>
   <input type="text" name="apartir" value="<? if ($apartir!='') echo $apartir; ?>" size=10 maxlength=10>
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
	   </td>
	  </tr>
	 </table>
  </td>
 </tr>
</table>
<br>
<input type="submit" name="guardar" value="Generar Reporte">
</form>
