<?php
include("./includes/funciones_fechas.inc");
$espaciado = 1;
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
		$urgente 		= $sql->f("urgente")+1;
		$extraurge	= $sql->f("extraurge")+1;
	}
}
$alineacion_vertical="top";
$fecha_now 					= date("d/m/Y");
$fecha_extraurgente	= dia_habil_posterior($fecha_now,$extraurge);
$fecha_urgente			= dia_habil_posterior($fecha_now,$urgente);
$fecha_ordinaria		= dia_habil_posterior($fecha_now,$ordinario);
$num_turnos					= 0;
$fol_orig			= "";
$conse				= "";
$fec_salid		= "";
$cve_depe			=	"";
$coment				=	"";
$cve_ins1			=	"";
$fec_comp			= "";
$fec_recdp		= "";
$cve_docto		= "";
$fec_elab			= "";
$txt_resp			= "";
$fec_notifica	= "";
$viable				= "";
$fec_conclu		= "";
$cve_urge			= "";
$califresp		= "";
$usua_sal			= "";
$modi_sal			= "";
$usua_resp		= "";
$modi_resp		= "";
$cve_resp			= "";
$cve_turn			= "";
$especial			= "";
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
if ($fol_parametro!="") {
	$sql->query("select fol_orig from docsal where fol_orig='$fol_parametro'");
	$num_turnos = $sql->num_rows($sql);
	if ($num_turnos > 0) {
		$query="select fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid,cve_depe,coment,cve_ins,to_char(fec_comp,'dd/mm/yyyy') as fec_comp,to_char(fec_recdp,'dd/mm/yyyy') as fec_recdp,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,txt_resp,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,viable,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,cve_urge,califresp,usua_sal,modi_sal,usua_resp,modi_resp,cve_resp,cve_turn,especial from docsal where fol_orig='$fol_parametro'";
		if ($conse_parametro!="") {
			$query.= " and conse='$conse_parametro'";
		}
		$query.=" order by fol_orig,conse";
		$sql->query($query);
		while ($sql->next_record()) {
			$fol_orig			= $sql->f("fol_orig");
			$conse				= $sql->f("conse");
			$fec_salid		= $sql->f("fec_salid");
			$cve_depe			=	$sql->f("cve_depe");
			$coment				=	$sql->f("coment");
			$cve_ins1			=	$sql->f("cve_ins");
			$fec_comp			= $sql->f("fec_comp");
			$fec_recdp		= $sql->f("fec_recdp");
			$cve_docto		= $sql->f("cve_docto");
			$fec_elab			= $sql->f("fec_elab");
			$txt_resp			= $sql->f("txt_resp");
			$fec_notifica	= $sql->f("fec_notifica");
			$viable				= $sql->f("viable");
			$fec_conclu		= $sql->f("fec_conclu");
			$cve_urge			= $sql->f("cve_urge");
			$califresp		= $sql->f("califresp");
			$usua_sal			= $sql->f("usua_sal");
			$modi_sal			= $sql->f("modi_sal");
			$usua_resp		= $sql->f("usua_resp");
			$modi_resp		= $sql->f("modi_resp");
			$cve_resp			= $sql->f("cve_resp");
			$cve_turn			= $sql->f("cve_turn");
			$especial			= $sql->f("especial");
		}
	}
	if ($conse_parametro=="" || $conse_parametro=="0") {
		$sql->query("SELECT to_char(fec_recep,'dd/mm/yyyy') as fecha_recepcion,fol_orig,txt_resum from documento where fol_orig='$fol_parametro'");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$fec_recep		= $sql->f("fecha_recepcion");
				$fol_orig			= $sql->f("fol_orig");
				$txt_resum		= $sql->f("txt_resum");
			}
		}
	}
}
?>
  <script language="JavaScript" src="includes/date-picker.js"></script>
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
				document.plantilla_turnaDocumento.prioridad.value='REQUIERE RESPUESTA EXTRAURGENTE';
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
		<?
		/*
		if (f.cve_depe.options[f.cve_depe.options.selectedIndex].value ==0) {
			alert("Por favor seleccione la dependencia a la que será turnado el documento.");
			f.cve_depe.focus();
			return(false);
		}
		*/
		?>
		if (f.cve_turn.options[f.cve_turn.options.selectedIndex].value ==0) {
			alert("El turnador no debe ser nulo.");
			f.cve_turn.focus();
			return(false);
		}
		if (f.coment.value.length < 1) {
			alert("La síntesis del asunto no debe ser nula.");
			f.coment.focus();
			return(false);
		}
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
	    <a href="javascript: history.go(-1);"><?php echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>&nbsp;&nbsp;<font class="chiquito">Turno:</font>
			&nbsp;
	    <input type="text" name="conse_parametro" value="<? echo $conse_parametro; ?>" size=3 maxlength=3>
	   	<?
	   	if ($fol_parametro!="" && $num_turnos>0) {
				if ($conse_parametro=="") $conse_parametro=$num_turnos;
				if (strlen($conse_parametro)==1) $conse_parametro="0".$conse_parametro;
				$antes		=$conse_parametro-1;
				$despues	=$conse_parametro+1;
				if (strlen($antes)==1) $antes="0".$antes;
				if (strlen($despues)==1) $despues="0".$despues;
				if (strlen($num_turnos)==1) { $num_turnos_txt="0".$num_turnos; } else { $num_turnos_txt=$num_turnos; };
				if ($conse_parametro!="01") {
					print("<a href='turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=01&control_botones_superior=1'><img src='$default->scg_graphics_url"."/bot2e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot1d.gif' border=0>");
				}
				if ($conse_parametro!="01") {
					print("<a href='turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$antes&control_botones_superior=1'><img src='$default->scg_graphics_url"."/bot1e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot2d.gif' border=0>");
				}
				if ($conse_parametro!=$num_turnos_txt) {
				print("<a href='turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$despues&control_botones_superior=1'><img src='$default->scg_graphics_url"."/bot3e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot3d.gif' border=0>");
				}
				if ($conse_parametro!=$num_turnos_txt) {
				print("<a href='turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$num_turnos_txt&control_botones_superior=1'><img src='$default->scg_graphics_url"."/bot4e.gif' border=0></a>");
				} else {
					print("<img src='$default->scg_graphics_url"."/bot4d.gif' border=0>");
				}
			} else {
				print("&nbsp;");
			}
			?>
		</td>
		<td width="50%" valign="<?php echo $alineacion_vertical; ?>" align="right">
			<?
			print("<font class='alerta'>Crear un nuevo turno</font>&nbsp;<a href='turnoDocumento.php?accion=&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=01&control_botones_superior=1'><img src='$default->scg_graphics_url/turnador.gif' border=0></a>");
	    ?>
    </td>
   </tr>
  </table>
  <form name="plantilla_turnaDocumento" method="post" action="updateTurnoDocumento.php?sess=<? echo $sess; ?>" target="_self" onsubmit="return regform_Validator(this)">
  <input type="hidden" name="conse_fijo" value="<? if ($conse) { echo $conse; } else { if ($conse_parametro) { echo $conse_parametro; }} ?>">
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
			<input type="text" name="fec_regi" value="<? if ($fec_regi=="") { echo $fecha_now;} else { echo $fec_regi; } ?>" size=10 maxlength=10
			<?php
			if (substr($ok["ctrl_menu_sup"],1,1)!='1') {
				echo " onFocus='this.blur();' onSelect='this.blur();'";
			}
			echo ">\n";
			?>
     </td>
    </tr>
    <tr>
     <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
      <font class="chiquito">Turnado a:</font>
     </td>
     <td colspan=3>
     	<select name='cve_depe'
 				<?php
				if (substr($ok["ctrl_menu_sup"],1,1)!='1') {
					echo " onFocus='this.blur();' onSelect='this.blur();'";
				}
				echo ">\n";
				if ($cve_depe=="" || $cve_depe=='0' ) {
					echo "<option value=0 selected> -------------------------</option>\n";
				} else {
					echo "<option value=0> -------------------------</option>\n";
					//ccedillo 24/01/2003
				}
				$sql->query("select nom_depe,cve_depe from dependencia order by nom_depe,cve_depe");
				if ($sql->num_rows($sql) > 0) {
					while($sql->next_record()) {
						$menu_cve_depe = $sql->f("cve_depe");
						$menu_nom_depe = $sql->f("nom_depe");
						echo "<option value='$menu_cve_depe'";
						if ($cve_depe==$menu_cve_depe) { echo " selected"; }
						echo ">$menu_nom_depe</option>\n";
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
     <select name='nom_ccp[]' multiple size=5
			<?php
			if (substr($ok["ctrl_menu_sup"],1,1)!='1') {
				echo " onFocus='this.blur();' onSelect='this.blur();'";
			}
			echo ">\n";
			$sql->query("select * from salccp where fol_orig='$fol_orig' and conse='$conse'");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$nom_ccp = $sql->f("nom_ccp");
				}
			}
			$nom_ccp=substr($nom_ccp,0,(strlen($nom_ccp)-1));
			$nom_ccp=substr($nom_ccp,1,(strlen($nom_ccp)-1));
			$arreglo_copias=explode("][",$nom_ccp);
			$num_cachos=count($arreglo_copias);
			$controlador=0;
			for ($y=0; $y<$num_cachos; $y++) {

				$a1	= $y/2;
				$a2	= intval($y/2);
				//$impares = bcmod($y,2);
				//if ($impares!=0) {
				if ($a1!=$a2) {
					$copia[$controlador]=$arreglo_copias[$y];
					$controlador++;
				}
			}
			$total_de_copias=count($copia);
			$sql->query("select nom_depe,cve_depe from dependencia order by nom_depe,cve_depe");
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$menu_cve_depe = $sql->f("cve_depe");
					$menu_nom_depe = $sql->f("nom_depe");
					echo "<option value='$menu_cve_depe'";
					for ($y=0; $y<$total_de_copias; $y++) {
						if ($menu_cve_depe==$copia[$y]) echo " selected";
					}
					echo ">$menu_nom_depe</option>\n";
				}
			}
			?>
     </select>
    </td>
   </tr>
   <tr>
    <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
     <font class="chiquito">Turnador:</font>
    </td>
    <td colspan=3>
     <select name='cve_turn'
 				<?php
				if (substr($ok["ctrl_menu_sup"],1,1)!='1') {
					echo " onFocus='this.blur();' onSelect='this.blur();'";
				}
				echo ">\n";
				if ($cve_turn=="") echo "<option value=0 selected> Seleccione el Turnador</option>\n";
				$sql->query("select nom_turn,cve_turn from turnador order by nom_turn,cve_turn");
				if ($sql->num_rows($sql) > 0) {
					while($sql->next_record()) {
						$menu_cve_turn = $sql->f("cve_turn");
						$menu_nom_turn = $sql->f("nom_turn");
						echo "<option value='$menu_cve_turn'";
						if ($cve_turn==$menu_cve_turn) echo " selected";
						echo ">$menu_nom_turn</option>\n";
					}
				}
				?>
     </select>
    </td>
   </tr>
   <tr>
    <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
     <font class="chiquito">S&iacute;ntesis:</font>
    </td>
    <td colspan="3">
     <textarea name="coment" wrap cols=70 rows=3 <?php if (substr($ok["ctrl_menu_sup"],1,1)!='1') {	echo "onFocus='this.blur();' onSelect='this.blur();'"; } echo ">\n"; ?><? if ($conse_parametro=="") { echo $txt_resum; } else { echo $coment; } ?></textarea>
    </td>
   </tr>
   <tr>
    <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
     <font class="chiquito">Instrucci&oacute;n:</font>
    </td>
    <td colspan=3>
     <select name='cve_ins'
				<?php
				if (substr($ok["ctrl_menu_sup"],1,1)!='1') {
					echo " onFocus='this.blur();' onSelect='this.blur();'";
				}
				echo ">\n";
      	if ($cve_ins1=="") {
					echo "<option value=0 selected> Seleccione la Instrucci&oacute;n</option>\n";
				}
				$sql->query("select instruccion,cve_ins from instruccion where tipo='I' order by instruccion,cve_ins");
				if ($sql->num_rows($sql) > 0) {
					while($sql->next_record()) {
						$menu_cve_instruccion 	= $sql->f("cve_ins");
						$menu_instruccion 			= $sql->f("instruccion");
						if (chop($cve_ins1)==chop($menu_cve_instruccion)) {
				  		   ?>
						   <option value='<? echo $menu_cve_instruccion ?>' selected>
						   <?
						  }else{
				  		   ?>
						   <option value='<? echo $menu_cve_instruccion ?>'>
						   <?
						}
						echo "$menu_instruccion</option>\n";
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
				 <input type="radio" name="cve_urge" value="" <? if (chop($cve_urge)=="") echo " checked ";  if (substr($ok["ctrl_menu_sup"],1,1)!='1') { echo "onFocus='this.blur();'"; } else { echo "onClick='if (this.checked) { cambia_letrero(0); }'"; } ?>>
				 <br>
				</td>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="O" <? if (chop($cve_urge)=="O") echo " checked "; if (substr($ok["ctrl_menu_sup"],1,1)!='1') { echo "onFocus='this.blur();'"; } else { echo "onClick='if (this.checked) { cambia_letrero(1); }'"; }  ?>>
				 <br><font face="Arial" color="green"><b>3</b></font>
				</td>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="U" <? if (chop($cve_urge)=="U") echo " checked "; if (substr($ok["ctrl_menu_sup"],1,1)!='1') { echo "onFocus='this.blur();'"; } else { echo "onClick='if (this.checked) { cambia_letrero(2); }'"; }  ?>>
				 <br><font face="Arial" color="yellow"><b>2</b></font>
				</td>
				<td width="20" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="radio" name="cve_urge" value="E" <? if (chop($cve_urge)=="E") echo " checked "; if (substr($ok["ctrl_menu_sup"],1,1)!='1') { echo "onFocus='this.blur();'"; } else { echo "onClick='if (this.checked) { cambia_letrero(3); }'"; }  ?>>
				 <br><font face="Arial" color="red"><b>1</b></font>
				</td>
				<td width="320" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <input type="text" name="prioridad"
				 <?
					switch ($cve_urge) {
						case '':
							echo 'value="NO REQUIERE RESPUESTA"';
						break;
						case 'O':
							echo 'value="REQUIERE RESPUESTA ORDINARIA"';
						break;

						case 'U':
							echo 'value="REQUIERE RESPUESTA URGENTE"';
						break;
						case 'E':
							echo 'value="REQUIERE RESPUESTA EXTRAURGENTE"';
						break;
					}
				 ?>
				 size=40 maxlength=40 onFocus="this.blur();">
				</td>
				<td width="300" valign="<?php echo $alineacion_vertical; ?>" align="center">
				 <table border=0 width=100%>
					<tr>
					 <td width=50% align=right>
						<font class="chiquito">Compromiso:</font>
					 </td>
					 <td>
						<input type="text" value="<? echo $fec_comp; ?>" name="fec_comp" onFocus="this.blur();" size=10 maxlength=10>
                        <a href="javascript:show_calendar('plantilla_turnaDocumento.fec_comp');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;">
                           <img src="<? echo $default->scg_graphics_url; ?>/show-calendar.gif" width=18 height=18 border=0>
					 </td>
					</tr>
					<tr>
					 <td width=50% align="right">
						<input type="hidden" name="especial" value="0">
						<input type="checkbox" name="chk_especial" <? if ($especial==1) { echo "checked"; } ?> onFocus="this.blur();" onClick="if (this.checked) { document.plantilla_turnaDocumento.especial.value=1; } else { document.plantilla_turnaDocumento.especial.value=0; }">
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
		<?
		if (substr($ok["ctrl_menu_sup"],1,1)=='1') {
			echo "<input type='submit' name='guardar' value='Guardar Cambios'>";
		}
		?>
 </form>
<?
//$sql->disconnect($sql->Link_ID);
?>