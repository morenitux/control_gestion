<?php
$arreglo				= explode("-",$parametro);
$num_cachos				= count($arreglo);
if ($num_cachos>2) {
	$fol_parametro		= $arreglo[0]."-".$arreglo[1];
	$conse_parametro	= $arreglo[2];
} else {
	$fol_parametro		= $arreglo[0];
	$conse_parametro	= $arreglo[1];
}
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$horalarga_now  =date("H:i:s");
$alineacion_vertical="top";
$espaciado=1;
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";
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
		f = document.plantilla_salida;
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
				var comparacion=ComparacionEntreFechas(f.fec_elab.value,"<? echo $fec_salid; ?>");
				if (comparacion=='ERRORF1') {
					f.fec_elab.focus();
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha de elaboración no puede ser menor a la fecha del turno: '+'<? echo $fec_salid; ?>');
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
				var comparacion=ComparacionEntreFechas(f.fec_notifica.value,"<? echo $fec_salid; ?>");
				if (comparacion=='ERRORF1') {
					f.fec_notifica.focus();
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha de notificación no puede ser menor a la fecha del turno: '+'<? echo $fec_salid; ?>');
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
					var comparacion=ComparacionEntreFechas(f.fec_conclu.value,"<? echo $fec_salid; ?>");
					if (comparacion=='ERRORF1') {
						f.fec_conclu.focus();
						return(false);
					}
					if (comparacion=='MENOR') {
						alert ('La fecha de conclusión no puede ser menor a la fecha del turno: '+'<? echo $fec_salid; ?>');
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
$fec_notifica	="";
$coment			="";
$cve_depe		="";
$nom_depe		="";
$cve_ins		="";
$instruccion	="";
if ($fol_parametro!="") {
	$sql = new scg_DB;
	$sql->query("select fol_orig from docsal where fol_orig='$fol_parametro'");
	$num_turnos = $sql->num_rows($sql);
	if ($num_turnos > 0) {
		$query="select fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid,cve_depe,coment,cve_ins,to_char(fec_comp,'dd/mm/yyyy') as fec_comp from docsal where fol_orig='$fol_parametro' and conse='$conse_parametro' order by fol_orig,conse";
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
			if ($cve_depe!="") {
				$sql2 = new scg_DB;
				$sql2->query("select nom_depe from dependencia where cve_depe='$cve_depe'");
				if ($sql2->num_rows($sql2) == 1) {
					if ($sql2->next_record()) {
						$nom_depe	= $sql2->f("nom_depe");
					}
				}
			}
			if ($cve_ins!="") {
				$sql2 = new scg_DB;
				$sql2->query("select instruccion from instruccion where cve_ins='$cve_ins'");
				if ($sql2->num_rows($sql2) == 1) {
					if ($sql2->next_record()) {
						$instruccion = $sql2->f("instruccion");
					}
				}

			}
		}
		$query="SELECT cve_remite,cve_refe from documento where fol_orig='$fol_parametro'";
		$sql = new scg_DB;
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
			$sql = new scg_DB;
			$sql->query($query);
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$base_datos_padre	= $sql->f("base_datos");
				}
			}
		}
		$query="SELECT fol_orig,conse,remite,sintesis,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,base_datos,prop_base,folio_remite,conse_remite,plazo,viable,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,cve_resp,etapas,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,califresp,to_char(fec_compro,'dd/mm/yyyy') as fec_compro from resp_buzon where fol_orig is not null and fol_orig='$fol_parametro' and conse='$conse_parametro'";
		$sql = new scg_DB;
		$sql->query($query);
		$numero_renglones = $sql->num_rows($sql);
		if ($numero_renglones > 0) {
			while($sql->next_record()) {
				$folio_en_documentos = "";
				$fol_orig		= "";
				$conse			= "";
				$remite			= "";
				$sintesis		= "";
				$cve_docto_resp	= "";
				$fec_elab		= "";
				$base_datos		= "";
				$prop_base		= "";
				$folio_remite	= "";
				$conse_remite	= "";
				$plazo			= "";
				$viable			= "";
				$fec_notifica	= "";
				$cve_resp		= "";
				$etapas			= "";
				$fec_conclu		= "";
				$califresp		= "";
				$fec_compro		= "";
				$parametro		= "";

				$fol_orig		= $sql->f("fol_orig");
				$conse			= $sql->f("conse");
				$remite			= $sql->f("remite");
				$sintesis		= $sql->f("sintesis");
				$cve_docto_resp	= $sql->f("cve_docto");
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
				$parametro		= "$fol_orig-$conse";
			}
		}
		echo "XXX FECHA DE ELABORACION: $fec_elab --------------";
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
  	<? if ($base_datos_padre) { ?>
	function verifica_transmision() {
		if (document.plantilla_salida.transmitir.checked) {
			document.plantilla_salida.transmitir.value=1;
		} else {
			document.plantilla_salida.transmitir.value=1;
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
				alert('Verifique que el porcentaje de avance sólo contenga números enteros');
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
				var comparacion=eval("ComparacionEntreFechas(document.plantilla_salida.fecha"+numero+".value,"+'<? echo $fec_salid; ?>'+");");
				if (comparacion=='ERRORF1') {
					eval('document.plantilla_salida.fecha'+numero+'.focus();');
					return(false);
				}
				if (comparacion=='MENOR') {
					alert ('La fecha no puede ser menor a la fecha del turno: '+'<? echo $fec_salid; ?>');
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
	 <table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	  <tr>
	   <td valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Turno:</font>
	   </td>
	   <td valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class='alerta'><? echo $fol_orig; ?>-<? echo $conse; ?>&nbsp;</font>
	   </td>
	   <td valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Turnado el:</font>
	   </td>
	   <td valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class='alerta'><? echo $fec_salid; ?>&nbsp;</font>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Turnado a:</font>
	   </td>
	   <td colspan=7>
	    <font class='alerta'><? echo $nom_depe; ?>&nbsp;</font>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Síntesis:</font>
	   </td>
	   <td colspan=7>
	    <font class='alerta'><? echo $coment; ?>&nbsp;</font>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Instrucción:</font>
	   </td>
	   <td colspan=7>
	    <font class='alerta'><? echo $instruccion; ?>&nbsp;</font>
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
<form name="plantilla_salida" method="post" action="updateSalida.php?sess=<? echo $sess; ?>&control_botones_superior=1" target="_self" onsubmit="return regform_Validator();" onLoad="javascript: document.plantilla_documento.fec_recep.focus(); document.plantilla_documento.fec_recep.select();">
<input type="hidden" name="fol_parametro" value="<? echo $fol_parametro; ?>">
<input type="hidden" name="conse_parametro" value="<? echo $conse_parametro; ?>">
<input type="hidden" name="viene_de" value="buzon_respuestas">
<input type="hidden" name="borrar_buzon_directo" value="SI">
<table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
  <td width="100%" valign="top" align="center">
	 <table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>" bgcolor='#CBE4C0'>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Documento:</font>
	   </td>
	   <td>
	    <input type="text" name="cve_docto" value="<? echo $cve_docto_resp; ?>" size=27 maxlength=50 onFocus="document.plantilla_salida.cve_docto.blur();">
	   </td>
	   <td>
	    <font class="chiquito">Elaboración:</font><input type="text" name="fec_elab" value="<? echo $fec_elab; ?>" size=10 maxlength=10  onFocus="document.plantilla_salida.fec_elab.blur();">
	   </td>
	   <td>
	    <font class="chiquito">Notificación:</font><input type="text" name="fec_notifica" value="<? echo $fec_notifica; ?>" size=10 maxlength=10>
	    <a href="javascript:show_calendar('plantilla_salida.fec_notifica');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0></a>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Respuesta:</font>
	   </td>
	   <td colspan=3>
	    <textarea name="txt_resp" wrap cols=68 rows=4><? echo $sintesis; ?></textarea>
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
    		 &nbsp;
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
				/*EJEMPLO ETAPAS
				PRIMERA ETAPA[25[2003-03-31[]SEGUNDA ETAPA[25[2003-03-31[]PRIMERA ETAPA[15[2003-03-31[]SEGUNDA ETAPA[10[2003-03-31[]
				*/
				$etapas_array = explode("[]",$etapas);
				$num_etapas	= count($etapas_array);
				if ($num_etapas>0) {
					for($x = 0;$x < $num_etapas; $x++) {
						$etapa_fuente = $etapas_array[$x];
						$valores_etapa_fuente = explode("[",$etapa_fuente);
						$etapa		= $valores_etapa_fuente[0];
						$porciento	= $valores_etapa_fuente[1];
						$fecha		= $valores_etapa_fuente[2];
						if ($porciento!="") {
							$cadena_porciento="$porciento%";
						} else {
							$cadena_porciento="";
						}
						print("<tr>\n<td>\n");
						print("\n</td>\n<td>");
						print("<input type='text' name='etapa$x' value='$etapa' size=50 maxlength=100 onFocus='document.plantilla_salida.etapa$x.blur();'>\n");
						print("\n</td>\n<td>\n");
						print("<input type='text' name='porciento$x' value='$cadena_porciento' size=4 maxlength=4 onFocus='document.plantilla_salida.porciento$x.blur();'>\n");
						print("\n</td>\n<td>");
						print("<input type='text' name='fecha$x' value='$fecha' size=10 maxlength=10 onFocus='document.plantilla_salida.fecha$x.blur();'>\n");
						print("\n</td>\n</tr>\n");
						print("<input type='hidden' name='oid$x' value='$oid'>\n");
					}
				}
				$cuantas_son=$num_etapas;
				print("<input type='hidden' name='numero_total_de_etapas' value=$cuantas_son>");
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
	     <option value="" <? if ($cve_resp=="") { echo "selected"; } ?>>NO REQUIERE RESPUESTA</option>
	     <option value="N" <? if ($cve_resp=="N") { echo "selected"; } ?>>PENDIENTE</option>
	     <option value="A" <? if ($cve_resp=="A") { echo "selected"; } ?>>EN TRÁMITE</option>
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
	    <font class="chiquito">Compromiso:</font><input type="text" name="fec_comp" value="<? echo $fec_compro; ?>" size=10 maxlength=10>
	   </td>
	  </tr>
   </table>
  </td>
 </tr>
</table>
<? if ($base_datos_padre) echo "&nbsp;<font class=chiquito>Transmitir:</font><input name='transmitir' type='checkbox' value='0' onClick='verifica_transmision();' onFocus='verifica_transmision();' onChange='verifica_transmision();' onSelect='verifica_transmision();'>&nbsp;"; ?><input type="submit" name="guardar" value="Guardar">
</form>