<?php
include("./includes/funciones_fechas.inc");
$espaciado = 1;
$alineacion_vertical="top";
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
$sql->query("select ordinario,urgente,extraurge from tbl_mensaje");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$ordinario	= $sql->f("ordinario")+1;
		$urgente 	= $sql->f("urgente")+1;
		$extraurge	= $sql->f("extraurge")+1;
	}
}
$fecha_now 				= date("d/m/Y");
$fecha_extraurgente		= dia_habil_posterior($fecha_now,$extraurge);
$fecha_urgente			= dia_habil_posterior($fecha_now,$urgente);
$fecha_ordinaria		= dia_habil_posterior($fecha_now,$ordinario);
$usua_sal				= "";
$modi_sal				= "";
$num_turnos				= 0;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
if ($fol_parametro!="") {
	$sql->query("select fol_orig from docsal where fol_orig='$fol_parametro'");
	$num_turnos = $sql->num_rows($sql);
	if ($conse_parametro=="" || $conse_parametro=="0") {
		$sql->query("SELECT to_char(fec_recep,'dd/mm/yyyy') as fecha_recepcion,fol_orig,txt_resum from documento where fol_orig='$fol_parametro'");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$fec_recep		= $sql->f("fecha_recepcion");
				$fol_orig		= $sql->f("fol_orig");
				$txt_resum		= $sql->f("txt_resum");
			}
		}
	}
}
?>
  <script language="JavaScript" src="includes/isValidDate.js"></script>
  <script language="JavaScript" src="includes/newWindow.js"></script>
  <script language="javascript">
  function cambia_letrero(valor) {
		switch (valor) {
			case 0:
				document.plantilla_turnaDocumento.prioridad.value='NO REQUIERE RESPUESTA';
				document.plantilla_turnaDocumento.fec_comp.value='';
				document.plantilla_turnaDocumento.chk_especial.checked=false;
				document.plantilla_turnaDocumento.especial.value="0";
			break;
			case 1:
				document.plantilla_turnaDocumento.prioridad.value='REQUIERE RESPUESTA ORDINARIA';
				document.plantilla_turnaDocumento.fec_comp.value='<? echo $fecha_ordinaria; ?>';
			break;

			case 2:
				document.plantilla_turnaDocumento.prioridad.value='REQUIERE RESPUESTA URGENTE';
				document.plantilla_turnaDocumento.fec_comp.value='<? echo $fecha_urgente; ?>';
			break;
			case 3:
				document.plantilla_turnaDocumento.prioridad.value='REQUIERE RESPUESTA EXTRA URGENTE';
				document.plantilla_turnaDocumento.fec_comp.value='<? echo $fecha_extraurgente; ?>';
			break;

		}
  }
  function regform_Validator(f) {
	fechaValida=isValidDate(f.fec_regi.value);
		if (fechaValida) {
			var comparacion=ComparacionEntreFechas(f.fec_regi.value,'<? echo $fecha_now; ?>');
			if (comparacion=='ERRORF1') {
				f.fec_regi.focus();
				return(false);
			}
			if (comparacion=='MAYOR') {
				alert ('La fecha de turno no puede ser mayor a la fecha de hoy: '+'<? echo $fecha_now; ?>');
				f.fec_regi.focus();
				return(false);
			}
			var comparacion=ComparacionEntreFechas(f.fec_regi.value,'<? echo $fec_recep; ?>');
			if (comparacion=='ERRORF1') {
				f.fec_regi.focus();
				return(false);
			}
			if (comparacion=='MENOR') {
				alert ('La fecha de turno no puede ser menor a la fecha de acuse del documento: '+'<? echo $fec_recep; ?>');
				f.fec_regi.focus();
				return(false);
			}
		} else {
			if (!fechaValida) {
				f.fec_regi.focus();
				return(false);
			}
		}


		if (f.cve_depe.options[f.cve_depe.options.selectedIndex].value ==0) {
			alert("Por favor seleccione la dependencia a la que será turnado el documento.");
			f.cve_depe.focus();
			return(false);
		}

		if (f.cve_turn.options[f.cve_turn.options.selectedIndex].value ==0) {
			alert("El nombre de quien turna no debe ser nulo.");
			f.cve_turn.focus();
			return(false);
		}
		<?php
		/*if (f.coment.value.length < 1) {
			alert("Las ínstrucciones adicionales no deben ser nulas.");
			f.coment.focus();
			return(false);
		}*/
		?>
		if (f.fec_comp.value.length>0) {
			valida=isValidDate(f.fec_comp.value);
			if (!valida) {
				f.fec_comp.focus();
				return(false);
			}
			var comparacion=ComparacionEntreFechas(f.fec_comp.value,'<? echo $fec_recep; ?>');
			if (comparacion=='ERRORF1') {
				f.fec_comp.focus();
				return(false);
			}
			if (comparacion=='MENOR') {
				alert ('La fecha compromiso no puede ser menor a la fecha de acuse del documento: '+'<? echo $fec_recep; ?>');
				f.fec_comp.focus();
				return(false);
			}
		}
  }
  </script>
    <table width="700" border="0" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
	   <tr>
	    <td width="50%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		    <?
		    echo "<font class='bigsubtitle'>Turno nuevo</font>&nbsp;&nbsp;&nbsp;&nbsp;";
		    if ($viene_de!="insertar_documento" && $viene_de!="recibir_documento_de_buzon") {
		    	echo "<font class='chiquito'>Regresar</font>&nbsp;";
		    	echo "<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&parametro=$fol_parametro'><img src='$default->scg_graphics_url"."/back.gif' border='0'></a>";
			} else {
				echo "<br>";
			}
		    ?>
			</td>
			<td width="50%" valign="<?php echo $alineacion_vertical; ?>" align="right">
				<?
				if ($num_turnos>0) {
					print("<font class='alerta'>");
					if ($num_turnos==1) {
						print("Ver el turno preexistente</font>");
					} else {
						print("Ver los $num_turnos turnos preexistentes</font>");
					}
					print("&nbsp;<a href='turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=01&control_botones_superior=1'><img src='$default->scg_graphics_url/bot_turnos.gif' border=0></a>");
				}
				?>
	    </td>
	   </tr>
  </table>
  <form name="plantilla_turnaDocumento" method="post" action="insertTurnoDocumento.php?sess=<? echo $sess; ?>&viene_de=<? echo $viene_de; ?>" target="_self" onsubmit="return regform_Validator(this)">
   <table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
    <tr>
     <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
      <font class="chiquito">Folio:</font>
     </td>
     <td width="100">
      <input type="text" name="fol_orig" value="<? echo $fol_parametro ?>" size=12 maxlength=12 onFocus="this.blur();" onSelect="this.blur();">
     </td>
     <td width="84" align="right">
			<font class="chiquito">Fecha:</font>
     </td>
     <td>
			<input type="text" name="fec_regi" value="<? echo $fecha_now; ?>" size=10 maxlength=10 onFocus="this.blur();" onSelect="this.blur();">
     </td>
    </tr>
    <tr>
     <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right" bgcolor="#FFFFCC">
	  <a href="javascript: newWindow('admin/admonCatalogo.php?sess=<? echo $sess; ?>&control_catalogos=5&origen=documento',900,500,'Principal','control_catalogos','ventana_auxiliar');"><font class="chiquito">Turnado a:</font></a>
     </td>
     <td colspan=3>
      <select name='cve_depe'>
       <option value=0 selected> Seleccione la dependencia</option>
				<?php
				$sql->query("select nom_depe,cve_depe from dependencia order by nom_depe,cve_depe");
				if ($sql->num_rows($sql) > 0) {
					while($sql->next_record()) {
						$cve_depe = $sql->f("cve_depe");
						$nom_depe = $sql->f("nom_depe");
						echo "<option value='$cve_depe'>$nom_depe</option>\n";
					}
				}
				?>
      </select>
     </td>
    </tr>
    <tr>
     <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
      <font class="chiquito">c.c.p:</font>
     </td>
    <td colspan=3>
     <select name='nom_ccp[]' multiple size=5 >
			<?php
			$sql->query("select nom_depe,cve_depe from dependencia order by nom_depe,cve_depe");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$cve_depe = $sql->f("cve_depe");
					$nom_depe = $sql->f("nom_depe");
					echo "<option value='$cve_depe'>$nom_depe</option>\n";
				}
			}
			?>
     </select>
    </td>
   </tr>
   <tr>
    <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right" bgcolor="#FFFFCC">
     <font class="chiquito">Turnado por:</font>
    </td>
    <td colspan=3>
     <select name='cve_turn' >
				<?php
				$sql->query("select nom_turn,cve_turn from turnador order by nom_turn,cve_turn");
				if ($sql->num_rows($sql) > 0) {
					if ($sql->num_rows($sql) > 1) {
				        	echo "<option value=0 selected> Seleccione el nombre de quien turna</option>";
					}
					while($sql->next_record()) {
						$cve_turn = $sql->f("cve_turn");
						$nom_turn = $sql->f("nom_turn");
						echo "<option value='$cve_turn'"; //SSDF... si sólo hay un registro en el catálogo de turnadores, entonces será seleccionado por default
						if ($sql->num_rows($sql) == 1) {
							echo " selected";
						}
						echo ">$nom_turn</option>\n";
					}
				}
				?>
     </select>
    </td>
   </tr>
   <tr>
    <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
     <font class="chiquito">Instrucciones<br>adicionales:</font>
    </td>
    <td colspan="3">
     <textarea name="coment" wrap cols=70 rows=3><? if ($conse_parametro=="" || ($txt_resp=='')) { } else { echo $txt_resp; } ?></textarea>
    </td>
   </tr>
   <tr>
    <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
     <font class="chiquito">Instrucci&oacute;n:</font>
    </td>
    <td colspan=3>
     <select name='cve_ins' >
      <option value=0 selected> Seleccione la Instrucci&oacute;n</option>
				<?php
				$sql->query("select instruccion,cve_ins from instruccion where tipo='I' order by instruccion,cve_ins");
				if ($sql->num_rows($sql) > 0) {
					while($sql->next_record()) {
						$cve_instruccion 	= $sql->f("cve_ins");
						$instruccion 			= $sql->f("instruccion");
						echo "<option value='$cve_instruccion'>$instruccion</option>\n";
					}
				}
				?>
     </select>
    </td>
   </tr>
   <tr>
    <td width="100%" colspan=4>
			<table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
			 <tr>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="" checked onClick="if (this.checked) { cambia_letrero(0); }">
				 <br>
				</td>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="O" onClick="if (this.checked) { cambia_letrero(1); }">
				 <br><font face="Arial" color="green"><b>3</b></font>
				</td>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="U" onClick="if (this.checked) { cambia_letrero(2); }">
				 <br><font face="Arial" color="yellow"><b>2</b></font>
				</td>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="E" onClick="if (this.checked) { cambia_letrero(3); }">
				 <br><font face="Arial" color="red"><b>1</b></font>
				</td>
				<td width="320" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="text" name="prioridad" value="NO REQUIERE RESPUESTA" size=40 maxlength=40 onFocus="this.blur();">
				</td>
				<td width="300" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <table border=0 width=100%>
					<tr>
					 <td width=50% align=right>
						<font class="chiquito">Compromiso:</font>
					 </td>
					 <td>
						<input type="text" name="fec_comp" onFocus="if (document.plantilla_turnaDocumento.cve_urge.value=='') { this.blur(); }" size=10 maxlength=10>
					 </td>
					</tr>
					<tr>
					 <td width=50% align="right">
						<input type="hidden" name="especial" value="0">
						<input type="checkbox" name="chk_especial" onFocus="if (document.plantilla_turnaDocumento.cve_urge.value=='') { this.blur(); }" onClick="if (this.checked) { document.plantilla_turnaDocumento.especial.value=1; } else { document.plantilla_turnaDocumento.especial.value=0; }">
					 </td>
					 <td>
						<font class="chiquito">Especial</font>
					 </td>
					</tr>
				 </table>
				</td>
			 </tr>
			</table>
    </td>
   </tr>
   <tr>
    <td width="100%" colspan=4>
	    <table width="100%" border="1" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 	     <tr>
   	    <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <font class="chiquito">Reg:<br><?php if ($usua_sal=="") { echo $id_usuario; } else { echo $usua_sal; } ?></font>
	 	    </td>
	 	    <td width="14%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <font class="chiquito">Mod:<br><?php if ($modi_sal=="") { echo "&nbsp;"; } else { echo $modi_sal; } ?></font>
	 	    </td>
	 	    <td width="72%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <br>
	 	    </td>
 		   </tr>
 		  </table>
    </td>
   </tr>
  </table>
  <input type="submit" name="guardar" value="Turnar ahora">
 </form>
<?
//$sql->disconnect($sql->Link_ID);
?>
