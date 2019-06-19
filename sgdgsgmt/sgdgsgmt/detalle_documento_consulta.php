<?php
//INICIALIZACION DE VARIABLES
$sql = new scg_DB;
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$alineacion_vertical="top";
$espaciado=0;

$fol_orig		= "";
$fec_regi		= "";
$fec_recep		= "";
$cve_docto		= "";
$fec_elab		= "";
$firmante		= "";
$cve_prom		= "";
$cve_remite		= "";
$txt_resum		= "";
$cve_expe		= "";
$nom_suje		= "";
$notas			= "";
$cve_segui		= "";
$cve_refe		= "";
$cve_recep		= "";
$usua_doc		= "";
$cve_eve		= "";
$fec_eve		= "";
$time_eve		= "";
$cve_tipo		= "";
$confi			= "";
$modifica		= "";
$cve_dirigido	= "";
$cargo_fmte  	= "";
$nacional		= "";
$domicilio		= "";
$colonia		= "";
$delegacion		= "";
$codigo_post	= "";
$entidad		= "";
$telefono		= "";
$clasif			= "";
$antecedente	= "";
$fec_comp		= "";
$salida			= "";
$hora_recep		= "";
$ctr_entidad	= "";

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
where fol_orig='$parametro'";
$sql->query($query);
if ($sql->next_record()) {
	$fol_orig		= $sql->f("0");
	$fec_regi		= $sql->f("1");
	$fec_recep		= $sql->f("2");
	$cve_docto		= $sql->f("3");
	$fec_elab		= $sql->f("4");
	$firmante		= $sql->f("5");
	$cve_prom		= $sql->f("6");
	$cve_remite		= $sql->f("7");
	$txt_resum		= $sql->f("8");
	$cve_expe		= $sql->f("9");
	$nom_suje		= $sql->f("10");
	$notas			= $sql->f("11");
	$cve_segui		= $sql->f("12");
	$cve_refe		= $sql->f("13");
	$cve_recep		= $sql->f("14");
	$usua_doc		= $sql->f("15");
	$cve_eve		= $sql->f("16");
	$fec_eve		= $sql->f("17");
	$time_eve		= $sql->f("18");
	$cve_tipo		= $sql->f("19");
	$confi			= $sql->f("20");
	$modifica		= $sql->f("21");
	$cve_dirigido	= $sql->f("22");
	$cargo_fmte  	= $sql->f("23");
	$nacional		= $sql->f("24");
	$domicilio		= $sql->f("25");
	$colonia		= $sql->f("26");
	$delegacion		= $sql->f("27");
	$codigo_post	= $sql->f("28");
	$entidad		= $sql->f("29");
	$telefono		= $sql->f("30");
	$clasif			= $sql->f("31");
	$antecedente	= $sql->f("32");
	$fec_comp		= $sql->f("33");
	$salida			= $sql->f("34");
	$hora_recep		= $sql->f("35");
	$ctr_entidad	= $entidad*1;
}
$sql->query("SELECT * from doctem where fol_orig='$parametro'");
$x=0;
$total_temas=$sql->num_rows($sql);
while ($sql->next_record()) {
	$cve_tema[$x] = $sql->f("cve_tema");
	$x++;
}
if ($entidad!="") {
	$sql->query("select id_entidad_federativa,entidad_federativa from cat_entidad_federativa where id_entidad_federativa='$entidad'");
	if ($sql->next_record()) {
		$numero_entidad	= $sql->f("id_entidad_federativa")*1;
		$nombre_entidad = $sql->f("entidad_federativa");
	}
}
if ($delegacion!="") {
	$sql->query("select id_delegacion_municipio,delegacion_municipio from cat_delegacion_municipio where id_delegacion_municipio='$delegacion'");
	if ($sql->next_record()) {
		$numero_delegacion	= $sql->f("id_delegacion_municipio")*1;
		$nombre_delegacion 	= $sql->f("delegacion_municipio");
	}
}
?>
<script language='JavaScript' src='includes/newWindow.js'></script>
<table width=100% border=0 cellspacing=2 cellpadding=2>
 <tr>
  <td width=100% align=left>
	<a href="javascript: history.go(-1);"><?php echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
  </td>
 </tr>
</table>
<table width="800" border="2" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>" bgcolor="#EAEAEA">
 <tr>
  <td width="40%" valign="center" align="left">
   <font class="alerta">DOCUMENTO</font>
   <?php
	if (substr($control_menu_superior,1,1)!="2") {
  		echo "&nbsp;&nbsp;<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'><img src='$default->scg_graphics_url/bot_cambio.gif' border='0' alt='Edición'></a>";
  		echo "&nbsp;&nbsp;<a href='copia_clip.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&parametro=$parametro'><img src='$default->scg_graphics_url/bot_copiar.gif' border='0' alt='Copiar patrón de documento'></a>";
	}
	?>
  </td>
  <td width="60%" valign="center" align="right">
	<?php
		$letrero="";
		$sql->query("select count(*) from docsal where fol_orig='$parametro'");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$total_turnos = $sql->f("0");
			}
		}
		// NO REQUIEREN RESPUESTA SI cve_resp=''
		$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp=''");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$total_no_requiere = $sql->f("0");
			}
		}
		// SI REQUIEREN RESPUESTA SI (CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S')
		// PENDIENTES SI CVE_RESP='N'
		$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp='N'");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$total_pendientes = $sql->f("0");
			}
		}
		// EN SEGUIMIENTO O TRAMITE SI cve_resp='A'
		$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp='A'");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$total_seguimiento = $sql->f("0");
			}
		}
		// RESUELTOS O CONCLUIDOS SI cve_resp='S'
		$sql->query("select count(*) from docsal where fol_orig='$parametro' and cve_resp='S'");
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$total_concluidos = $sql->f("0");
			}
		}
		if ($total_turnos>0) {
			$letrero.="$total_turnos ";
			if ($total_turnos==1) {
				$letrero.="turno";
			} else {
				$letrero.="turnos";
			}
			if ($total_no_requiere>0) {
				$letrero.=" / $total_no_requiere ";
				if ($total_no_requiere==1) {
					$letrero.="no requiere respuesta";
				} else {
					$letrero.="no requieren respuesta";
				}
			}
			if ($total_pendientes>0) {
				$letrero.=" / $total_pendientes ";
				if ($total_pendientes==1) {
					$letrero.="pendiente";
				} else {
					$letrero.="pendientes";
				}
			}
			if ($total_seguimiento>0) {
				$letrero.=" / $total_seguimiento ";
				if ($total_seguimiento==1) {
					$letrero.="seguimiento";
				} else {
					$letrero.="seguimientos";
				}
			}
			if ($total_concluidos>0) {
				$letrero.=" / $total_concluidos ";
				if ($total_concluidos==1) {
					$letrero.="resuelto";
				} else {
					$letrero.="resueltos";
				}
			}
		}
		echo "<font class=\"alerta\">$letrero &nbsp;</b></font>";
   ?>

  </td>
 </tr>
</table>
<table width="800" border="3" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>" bgcolor="#EAEAEA">
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	 <tr>
	  <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquito">Número de Entrada:</font>
	  </td>
	  <td width="18%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquitoazul"><b>
	   <?php
	   echo "$fol_orig &nbsp;";
	   //echo "&nbsp;";
		 //echo "<input type=\"button\" value=\"Buscar\" onClick=\"if (document.plantilla_documento.fol_orig.value!='') { eval(window.location='buscar_documento.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&&parametro='+document.plantilla_documento.fol_orig.value); };\">";
		 //echo "&nbsp;&nbsp;";
	   //echo "<a href='turnoDocumento.php?sess=$sess&fol_parametro=$fol_orig&control_botones_superior=1'><img src='$default->scg_graphics_url/turnador.gif' border=0></a>";
	   ?>
	   </b></font>
	  </td>
	  <td width="32%" valign="<?php echo $alineacion_vertical; ?>" align="left">
			<font class="chiquito">Registro:</font>
			<font class="chiquitoazul"><b>
			<?php echo "$fec_regi &nbsp;"; ?>
			</b></font>
	  </td>
	  <td width="32%" valign="<?php echo $alineacion_vertical; ?>" align="left">
			<font class="chiquito">Acuse:</font>
			<font class="chiquitoazul"><b>
			<?php echo "$fec_recep &nbsp;"; ?>
			&nbsp;
			<?php echo "$hora_recep &nbsp;"; ?>
			</b></font>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	 <tr>
	  <td width="10%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Referencia:</font>
	  </td>
	  <td width="40%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquitoazul"><b>
		<?php echo "$cve_docto &nbsp;"; ?>
		</b></font>
	  </td>
	  <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right">
		<font class="chiquito">Elaboración:</font>
	  </td>
	  <td width="35%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquitoazul"><b>
		<?php echo "$fec_elab &nbsp;"; ?>
		</b></font>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
		<tr>
		 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <font class="chiquito">Promotor:</font>
		 </td>
		 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <font class="chiquitoazul"><b>
			<?php
			$sql->query("select nom_prom,cve_prom from promotor where tipo in ('P','Q') and cve_prom='$cve_prom'");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$nombre_p = $sql->f("nom_prom");
					$clave_p  = $sql->f("cve_prom");
					echo "$nombre_p &nbsp;";
				}
			} else {
				echo "-";
			}
			?>
			</b></font>
		 </td>
		</tr>
	</table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
	<table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
		<tr>
		 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <font class="chiquito">Remitente:</font>
		 </td>
		 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		  <font class="chiquitoazul"><b>
			<?php
			$sql->query("select nom_prom,cve_prom from promotor where tipo in ('R','Q') and cve_prom='$cve_remite'");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$nombre_p = $sql->f("nom_prom");
					$clave_p  = $sql->f("cve_prom");
					echo "$nombre_p &nbsp;";
					if ($cve_refe && $cve_refe!=$cve_docto) {
						echo "&nbsp;($cve_refe)&nbsp;";
					}
				}
			} else {
				echo "-";
			}
			?>
			</b></font>
		 </td>
		</tr>
	</table>
  </td>
 </tr>
 <?php if ($nom_suje!="") { ?>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing"<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	  <tr>
	   <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="chiquito">Particular:</font>
	   </td>
	   <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="chiquitoazul"><b>
	  	<?php echo "$nom_suje &nbsp;"; ?>
	  	</b></font>
	   </td>
	  </tr>
   </table>
  </td>
 </tr>
 <?php } ?>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Firmado por:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquitoazul"><b>
	  <?php
	  if ($firmante=="") {
			echo "-";
		} else {
			echo "$firmante &nbsp;";
		}
		?>
		</b></font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Cargo:</font>
	 </td>
	 <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquitoazul"><b>
	  <?php
	  if ($firmante=="") {
			echo "-";
		} else {
			echo "$cargo_fmte &nbsp;";
		}
		?>
		</b></font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	<tr>
	 <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquito">Dirigido a:</font>
	 </td>
	 <td width="53%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	   <font class="chiquitoazul"><b>
	   <?php
			$sql->query("select nombre,clave from dirigido where clave='$cve_dirigido'");
			$num = $sql->num_rows($sql);
			if ($num > 0) {
				while($sql->next_record()) {
					$nom_destinatario = $sql->f("nombre");
					$cve_destinatario = $sql->f("clave");
					echo "$nom_destinatario &nbsp;";
				}
			} else {
				echo "-";
			}
	   ?>
	   </b></font>
	 </td>
	 <td width="15%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	  <font class="chiquito">Antecedentes:</font>
	 </td>
	 <td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	  <font class="chiquitoazul"><b>
	  <?php echo "$antecedente &nbsp;"; ?>
	  </b></font>
	 </td>
	</tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
    <tr>
     <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
      <font class="chiquito"><font class="chiquito">Expediente:</font></a>
     </td>
     <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
     		<font class="chiquitoazul"><b>
        <?php
				$sql->query("select cve_expe,nom_expe from expediente where cve_expe='$cve_expe'");
				$num = $sql->num_rows($sql);
				if ($num > 0) {
					while($sql->next_record()) {
						$cve_expe_menu = $sql->f("cve_expe");
						$nom_expe_menu = $sql->f("nom_expe");
						echo "$cve_expe_menu - $nom_expe_menu";
					}
				} else {
					echo "-";
				}
				?>
				</b></font>
 	   </td>
 	  </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	  <tr>
	   <td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="chiquito">Tipo:</font>
	   </td>
	   <td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
	     <font class="chiquitoazul"><b>
	     <?php
	  		$sql->query("select cve_ins,instruccion  from instruccion where tipo='D' and cve_ins='$cve_tipo' order by instruccion");
	  		$num = $sql->num_rows($sql);
	  		if ($num > 0) {
	  			while($sql->next_record()) {
	  				$cve_tipodocumento = $sql->f("cve_ins");
	  				$tipodocumento = $sql->f("instruccion");
	  				echo "$tipodocumento &nbsp;";
	  			}
	  		} else {
					echo "-";
				}
	     ?>
	     </b></font>
	   </td>
	  </tr>
   </table>
  </td>
 </tr>
 <tr>
	<td width="100%" valign="<?php echo $alineacion_vertical; ?>" align="justify">
		<font class="chiquito">Asunto:</font><br>
		<font class="chiquitoazul"><b>
		<?php echo "$txt_resum &nbsp;"; ?>
		</b></font>
	</td>
 </tr>
 <tr>
	<td width="100%" valign="<?php echo $alineacion_vertical; ?>" align="left">
		<font class="chiquito">Clasificación:</font><br>
		<?php
		if ($total_temas) {
			echo "<font class='chiquitoazul'><b>";
			for ($x=0; $x<$total_temas; $x++) {
				$cve_topico=$cve_tema[$x];
				$sql->query("select cve_tema,topico from tema where tipo='T' and cve_tema='$cve_topico'");
				$num = $sql->num_rows($sql);
				if ($num > 0) {
					while($sql->next_record()) {
						$cve_topico	= $sql->f("cve_tema");
						$topico 		= $sql->f("topico");
						echo $topico;
						if ($x<($total_temas-1)) echo ", ";
					}
				}
			}
			echo "</b></font><br>";
		} else {
			echo "-";
		}
		?>
	</td>
 </tr>
 <?php if ($cve_eve!="" && $cve_eve!="0") { ?>
	<tr>
		<td width="100%" valign="top" align="center">
			<table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
				<tr>
					<td width="12%" valign="<?php echo $alineacion_vertical; ?>" align="left">
						<font class="chiquito">Evento:</font>
					</td>
					<td width="88%" valign="<?php echo $alineacion_vertical; ?>" align="left">
						<font class="chiquitoazul"><b>
						<?php
							$sql->query("select cve_tema,topico from tema where tipo='E' and cve_tema='$cve_eve'");
							$num = $sql->num_rows($sql);
							if ($num > 0) {
								while($sql->next_record()) {
									$cve_evento = $sql->f("cve_tema");
									$evento = $sql->f("topico");
									echo "$evento &nbsp;";
								}
							} else {
								echo "-";
							}
						?>
						</b></font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center">
			<table width="100%" border="0" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
				<tr>
					<td width="20%" valign="<?php echo $alineacion_vertical; ?>" align="left">
						<font class="chiquito">Fecha del evento:</font>
					</td>
					<td width="80%" valign="<?php echo $alineacion_vertical; ?>" align="left">
						<font class="chiquitoazul"><b>
						<?php echo "$fec_eve &nbsp;"; ?>
						&nbsp;
						<?php echo "$time_eve &nbsp;"; ?>
						&nbsp;
						</b></font>
						<font size=-1>dd/mm/yyyy hh:mm (24hrs.)</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
 <?php } ?>
 <tr>
  <td width="100%" valign="top" align="center">
   <table width="100%" border="1" cellspacing="1" cellpadding="1">
		<tr>
		 <td align="center">
		 	<?php
		 	$naturaleza="";
			if ($clasif==1) {
				if ($naturaleza) {
					$naturaleza.=", ";
				}
				$naturaleza.="PRIORITARIO";
			}
			if ($nacional==1) {
				if ($naturaleza) {
					$naturaleza.=", ";
				}
				$naturaleza.="INTERSECRETARIAL";
			}
			if ($confi==1) {
				if ($naturaleza) {
					$naturaleza.=", ";
				}
				$naturaleza.="CONFIDENCIAL";
			}
			if ($salida==1) {
				if ($naturaleza) {
					$naturaleza.=", ";
				}
				$naturaleza.="SALIDA";
			}
			//$naturaleza="PRIORITARIO, INTERSECRETARIAL, CONFIDENCIAL, SALIDA";
			echo "<font class='chiquito'>$naturaleza &nbsp;</font>";
			?>
		 </td>
		 <td width="22%" valign="<?php echo $alineacion_vertical; ?>">
			<font class="chiquito">Registró:&nbsp;</font><font class="chiquitoazul"><b>
			 <?php
				echo "$usua_doc &nbsp;";
			 ?>
			</font>
		 </td>
		 <td width="22%" valign="<?php echo $alineacion_vertical; ?>">
			<font class="chiquito">Modificó:&nbsp;</font><font class="chiquitoazul"><b><?php echo "$modifica &nbsp;"; ?></font>
		 </td>
		</tr>
   </table>
  </td>
 </tr>
</table>
<br>

<!------------------------------------------------------------------------------------------------------>
<?php
$fol_parametro=$fol_orig;
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";

$num_turnos		=0;
$fol_orig		="";
$conse			="";
$fec_salid		="";
$fec_comp		="";
$fec_recdp		="";
$fec_elab		="";
$fec_notifica	="";
$fec_conclu		="";
$coment			="";
$cve_depe		="";
$nom_depe		="";
$cve_ins		="";
$instruccion	="";
$cve_docto		="";
$txt_resp		="";
$viable			="";
$califresp		="";
$cve_urge		="";
$usua_sal		="";
$modi_sal		="";
$usua_resp		="";
$modi_resp		="";
if ($fol_parametro!="") {
	$sql->query("select fol_orig from docsal where fol_orig='$fol_parametro'");
	$num_turnos = $sql->num_rows($sql);
	if ($num_turnos > 0) {
		$i=0;
		$query="select fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid,cve_depe,coment,cve_ins,to_char(fec_comp,'dd/mm/yyyy') as fec_comp,to_char(fec_recdp,'dd/mm/yyyy') as fec_recdp,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,txt_resp,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,viable,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,cve_urge,califresp,usua_sal,modi_sal,usua_resp,modi_resp,cve_resp from docsal where fol_orig='$fol_parametro' ";
		if ($conse_parametro!="") {
			$query.= "and conse='$conse_parametro'";
		}
		$query.=" order by fol_orig,conse";
		$sql->query($query);
		while ($sql->next_record()) {
			$i++;
			$fol_orig		= $sql->f("fol_orig");
			$conse			= $sql->f("conse");
			$fec_salid		= $sql->f("fec_salid");
			$cve_depe		= $sql->f("cve_depe");
			$coment			= $sql->f("coment");
			$cve_ins		= $sql->f("cve_ins");
			$fec_comp		= $sql->f("fec_comp");
			$fec_recdp		= $sql->f("fec_recdp");
			$cve_docto		= $sql->f("cve_docto");
			$fec_elab		= $sql->f("fec_elab");
			$txt_resp		= $sql->f("txt_resp");
			$fec_notifica	= $sql->f("fec_notifica");
			$viable			= $sql->f("viable");
			$fec_conclu		= $sql->f("fec_conclu");
			$cve_urge		= $sql->f("cve_urge");
			$califresp		= $sql->f("califresp");
			$usua_sal		= $sql->f("usua_sal");
			$modi_sal		= $sql->f("modi_sal");
			$usua_resp		= $sql->f("usua_resp");
			$modi_resp		= $sql->f("modi_resp");
			$cve_resp		= $sql->f("cve_resp");

			switch ($cve_resp) {
				case "":
					$situacion_texto_original="no requiere respuesta";
				break;
				case "N":
					$situacion_texto_original="pendiente";
				break;
				case "A":
					$situacion_texto_original="seguimiento";
				break;
				case "S":
					$situacion_texto_original="resuelto";
				break;
			}
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
?>
<table width="800" border="1" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>" bgcolor="#EAEAEA">
 <tr>
  <td width="40%" valign="center" align="left">
   <font class="alerta">TURNO <?php echo "$i/$num_turnos"; ?></font>
	<?php
	if (substr($control_menu_superior,1,1)!="2") {
		print("&nbsp;&nbsp;");
		print("<a href='turnoDocumento.php?accion=preexistentes&sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$conse&control_botones_superior=1'><img src='$default->scg_graphics_url/bot_cambio.gif' border=0 alt='Edición'></a>");
	}
	$imprimevolante="$fol_parametro-$conse";
	print("&nbsp;&nbsp;");
	print("<a href='"."javascript: newWindow(\"imprime_volante.php?sess=$sess&imprimevolante=$imprimevolante\",800,600,\"Volante\")'"."'><img src='$default->scg_graphics_url/bot_impresion.gif' border=0 alt='Impresión de Volante de Control'></a>");
	?>
  </td>
  <td width="60%" valign="center" align="right">
   <font class="alerta">
	<?php echo "$situacion_texto_original &nbsp;"; ?>
	</b></font>
	&nbsp;
	<?php
	if ($fec_conclu!="") {
			echo "&nbsp;&nbsp;";
			echo "<font class='chiquitoazul'><b>$fec_conclu &nbsp;</b></font>";
			echo "&nbsp;&nbsp;";
			if ($califresp=="0") echo "<font class='chiquitoazul'><b>NEGATIVA</b></font>";
			if ($califresp=="1") echo "<font class='chiquitoazul'><b>POSITIVA</b></font>";
		}
		?>
   </font>
  </td>
 </tr>
</table>
<table width="800" border="3" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>" bgcolor="#EAEAEA">
 <tr>
  <td width="100%" valign="top" align="center">
	 <table width="100%" border="1" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Destinatario:</font>
	   </td>
	   <td colspan=7>
	    <font class="chiquitoazul"><b>
	    <?php echo "$nom_depe &nbsp;"; ?>
	    </b></font>
	   </td>
	  </tr>
	  	<?php
		/*---------------- INICIO COPIAS en SALCCP -----------------*/
		$total_de_copias=0;
		$sql2 = new scg_DB;
		$sql2->query("select * from salccp where fol_orig='$fol_orig' and conse='$conse_parametro'");
		if ($sql2->num_rows($sql2) > 0) {
			while($sql2->next_record()) {
				$nom_ccp = $sql2->f("nom_ccp");
			}
		}
		//primero le quito los corchetes del inicio y del final
		$nom_ccp=substr($nom_ccp,0,(strlen($nom_ccp)-1));
		$nom_ccp=substr($nom_ccp,1,(strlen($nom_ccp)-1));

		//separo en cachos la cadena
		$arreglo_copias=explode("][",$nom_ccp);
		$num_cachos=count($arreglo_copias);
		$controlador=0;

		for ($y=0; $y<$num_cachos; $y++) {
			//cuento los cachos impares, que son los que contienen la clave de la dependencia

			//$impares = bcmod($y,2);  aqui utilizo la funcion bcmod para determinar si el numero es impar como en algunos PHP's no jala, utilizo entonces las siguientes lineas para calcular impares
			//if ($impares!=0) {

			$a1	= $y/2;
			$a2	= intval($y/2);
			if ($a1>$a2) {
				//meto en el arreglo copia las claves de la dependencia
				$copia[$controlador]=$arreglo_copias[$y];
				$controlador++;
			}
		}
		$total_de_copias=count($copia);

		if ($total_de_copias>0) {
		?>
	  <tr>
	   <td width="14%" valign="top" align="right">
	    <font class="chiquito">c.c.p:</font>
	   </td>
	   <td colspan=7>
	    <font class="chiquitoazul"><b>
	    <?php
		for ($y=0; $y<$total_de_copias; $y++) {
			$buscando=$copia[$y];
			$sql2 = new scg_DB;
			$sql2->query("select nom_depe,cve_depe, car_titu from dependencia where cve_depe='$buscando'");
			if ($sql2->num_rows($sql) > 0) {
				while($sql2->next_record()) {
					$menu_cve_depe = $sql2->f("cve_depe");
					$menu_nom_depe = $sql2->f("nom_depe");
					$menu_car_titu = $sql2->f("car_titu");
					//por cada elemento del catalogo checo contra todas las copias marcadas
					echo "$menu_nom_depe<br>";
				}
			}
		}
		/*---------------- FIN COPIAS en SALCCP -----------------*/
		?>
	    </b></font>
	   </td>
	  </tr>
		<?php
		}
		?>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Instrucción:</font>
	   </td>
	   <td colspan=7>
	    <font class="chiquitoazul"><b>
	    <?php echo "$instruccion &nbsp;"; ?>
	    </b></font>
	   </td>
	  </tr>
	  <?php if ($coment) { ?>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Instrucciones adicionales:</font>
	   </td>
	   <td colspan=7>
	    <font class="chiquitoazul"><b>
	    <?php echo "$coment &nbsp;"; ?>
	    </b></font>
	   </td>
	  </tr>
	  <?php } ?>
	  <?php if ($cve_urge || $fec_comp) { ?>
	  <tr>
	   <td width="100%" colspan=8  valign="<?php echo $alineacion_vertical; ?>" align="left">
	    <font class="chiquito">Fecha compromiso:</font>
	    &nbsp;&nbsp;
	    <font class="chiquitoazul"><b>
	    <?php echo "$fec_comp &nbsp;"; ?>
	    </b></font>
	   </td>
	  </tr>
	  <?php } ?>
	 </table>
  </td>
 </tr>
</table>
<table width="800" border="3" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>" bgcolor="#FFFFE6">
 <tr>
  <td width="100%" valign="top" align="center">
	 <table width="100%" border="1" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
		<?php
		if ($fol_parametro!="" && $conse_parametro!="") {
			$sql2 = new scg_DB;
			$sql2->query("select oid,etapa,porciento,to_char(fecha,'dd/mm/yyyy') as fecha from etapas where folio='$fol_parametro' and conse='$conse_parametro' order by oid");
			$num_etapas=0;
			$num_etapas = $sql2->num_rows($sql);
			if ($num_etapas > 0) {
				$x=0;
				while ($sql2->next_record()) {
					$oid		= $sql2->f("0");
					$etapa		= $sql2->f("etapa");
					$porciento	= $sql2->f("porciento");
					$fecha		= $sql2->f("fecha");
					if ($porciento!="") {
						$cadena_porciento="$porciento%";
					} else {
						$cadena_porciento="";
					}
					if ($x==0) {
						?>
						<tr>
						 <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
							<table width="100%" border=0 cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
							 <tr>
								<td valign="<?php echo $alineacion_vertical; ?>" align="right">
								 <font class="chiquito">Etapas:</font>
								</td>
							 </tr>
							</table>
						 </td>
						 <td colspan=3 valign="top">
							<!-- INICIO ETAPAS -------------------------------------------------------------------------------------------------- -->
							<table width="100%" border="3" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
							 <tr bgcolor='#<?php echo $bgcolor_titulos; ?>'>
								<td width="5%" align='center' class='chiquitoblanco'>
								 <?php if ($accion!="nueva_etapa" && $num_turnos>0 && $accion!="agrega_etapa") { print("<a href='principal.php?sess=$sess&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro&control_botones_superior=2&accion=nueva_etapa'><img src='$default->scg_graphics_url"."/new_etapae.gif' border=0></a>"); } else { print("&nbsp;"); } ?>
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
							<?php
					}
					print("<tr>\n<td>\n");
					print("<a href='principal.php?sess=$sess&oid=$oid&fol_parametro=$fol_parametro&conse_parametro=$conse_parametro&control_botones_superior=2&accion=borra_etapa'><img src='$default->scg_graphics_url"."/del_etapae.gif' border=0></a>");
					print("\n</td>\n<td>");
					print("<input type='text' name='etapa$x' value='$etapa' size=50 maxlength=100>\n");
					print("\n</td>\n<td>\n");
					print("<input type='text' name='porciento$x' value='$cadena_porciento' size=4 maxlength=4>\n");
					print("\n</td>\n<td>");
					print("<input type='text' name='fecha$x' value='$fecha' size=10 maxlength=10>\n");
					print("\n</td>\n</tr>\n");
					print("<input type='hidden' name='oid$x' value='$oid'>\n");
					$x++;
				}
				?>
				</table>
				<!-- FIN ETAPAS -------------------------------------------------------------------------------------------------- -->
			 </td>
			</tr>
			<?php
			}
		}
		?>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <?php
		if (substr($control_menu_superior,2,1)!="2") {
			//echo "control_menu_superior= $control_menu_superior<br>";
	    	print("<a href='principal.php?&sess=$sess&control_botones_superior=2&fol_parametro=$fol_parametro&conse_parametro=$conse'><img src='$default->scg_graphics_url/bot_cambio.gif' border=0 alt='Edición'></a>&nbsp;");
	    	print("<a href='"."javascript: newWindow(\"imprime_volante_conclusion.php?sess=$sess&imprimevolante=$imprimevolante\",800,600,\"Volante\")'"."'><img src='$default->scg_graphics_url/bot_impresion.gif' border=0 alt='Impresión de la Conclusión sobre el Volante de Control'></a>");
		}
	    ?>
	    <font class="chiquito">Descargo:</font>
	   </td>
	   <td colspan=3>
			<font class="chiquitoazul"><b>
	    <?php echo "$txt_resp &nbsp;" ?>
	    </b></font>
	   </td>
	  </tr>
	  <tr>
	   <td width="14%" valign="<?php echo $alineacion_vertical; ?>" align="right">
	    <font class="chiquito">Documento:</font>
	   </td>
	   <td>
	    <font class="chiquitoazul"><b>
	    <?php echo "$cve_docto &nbsp;"; ?>
	    </b></font>
	   </td>
	   <td>
	   	<font class="chiquito">Elaboración:</font>
	   	<font class="chiquitoazul"><b>
	   	<?php echo "$fec_elab &nbsp;"; ?>
	   	</b></font>
	   </td>
	  </tr>
	  <tr>
	   <td colspan=4>
	    <table width="100%" border="1" cellspacing="<?php echo $espaciado; ?>" cellpadding="<?php echo $espaciado; ?>">
 	     <tr>
	 	    <td>
	 	     <br>
	 	    </td>
   	    <td width="22%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <font class="chiquito">Registró:&nbsp;</font><font class="chiquitoazul"><b>
	 	     <?php
				switch ($cve_resp) {
					case "N":
						echo "$usua_sal &nbsp;";
					break;
					case "S":
						echo "$usua_resp &nbsp;";
					break;
					case "":
						echo "$usua_sal &nbsp;";
					break;
				}
			?>
			</font>
	 	    </td>
	 	    <td width="22%" valign="<?php echo $alineacion_vertical; ?>">
	 	     <font class="chiquito">Modificó:&nbsp;</font><font class="chiquitoazul"><b>
	 	     <?php
	 	     	if ($modi_sal=="" && $modi_resp=="") {
						echo "&nbsp;";
					}	else {
						switch ($cve_resp) {
							case "N":
								if ($modi_sal=="") {
									echo "&nbsp;";
								} else {
									echo "$modi_sal &nbsp;";
								}
							break;
							case "S":
								if ($modi_resp=="") {
									echo "$id_usuario &nbsp;";
								} else {
									echo "$modi_resp &nbsp;";
								}
							break;
							case "":
								if ($modi_sal=="") {
									echo "&nbsp;";
								} else {
									echo "$modi_sal &nbsp;";
								}
							break;
						}
					}
					?>
					</font>
	 	    </td>
 		   </tr>
 		  </table>
 	   </td>
	  </tr>
   </table>
  </td>
 </tr>
</table>
<table width=100% border=0 cellspacing=2 cellpadding=2>
 <tr>
  <td width=100% align=left>
	<a href="javascript: history.go(-1);"><?php echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
  </td>
 </tr>
</table>
<br>
<?php
		}
	}
}
?>