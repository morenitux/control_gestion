<?php
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}
$sql = new scg_DB;
$sql->query("select * from tbl_mensaje");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$licencia = $sql->f("licencia");
		$headvol1 = $sql->f("headvol1");
		$headvol2 = $sql->f("headvol2");
		$headvol3 = $sql->f("headvol3");
		$bmprep 	= $sql->f("bmprep");
	}
}

$arreglo			= explode("-",$imprimevolante);
$num_cachos			= count($arreglo);
if ($num_cachos>2) {
	$parametro			= $arreglo[0]."-".$arreglo[1];
	$conse_parametro	= $arreglo[2];
} else {
	$parametro			= $arreglo[0];
	$conse_parametro	= $arreglo[1];
}

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
$sql = new scg_DB;
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
$sql = new scg_DB;
$sql->query("SELECT * from doctem where fol_orig='$parametro'");
$x=0;
$total_temas=$sql->num_rows($sql);
while ($sql->next_record()) {
	$cve_tema[$x] = $sql->f("cve_tema");
	$x++;
}
if ($entidad!="") {
	$sql = new scg_DB;
	$sql->query("select id_entidad_federativa,entidad_federativa from cat_entidad_federativa where id_entidad_federativa='$entidad'");
	if ($sql->next_record()) {
		$numero_entidad	= $sql->f("id_entidad_federativa")*1;
		$nombre_entidad = $sql->f("entidad_federativa");
	}
}
if ($delegacion!="") {
	$sql = new scg_DB;
	$sql->query("select id_delegacion_municipio,delegacion_municipio from cat_delegacion_municipio where id_delegacion_municipio='$delegacion'");
	if ($sql->next_record()) {
		$numero_delegacion	= $sql->f("id_delegacion_municipio")*1;
		$nombre_delegacion 	= $sql->f("delegacion_municipio");
	}
}

$fol_parametro=$fol_orig;
$bgcolor_titulos="#FFFFFF";
$color_1="FFFFFF";
$color_2="FFFFFF";

$num_turnos		=0;
$fol_orig		="";
$conse			="";
$fec_salid		="";
$fec_comp		="";
$fec_recdp		="";
$cve_turn		="";
$fec_elab_sal	="";
$fec_notifica	="";
$fec_conclu		="";
$coment			="";
$cve_depe		="";
$nom_depe		="";
$cve_ins		="";
$instruccion	="";
$cve_docto_sal	="";
$txt_resp		="";
$viable			="";
$califresp		="";
$cve_urge		="";
$usua_sal		="";
$modi_sal		="";
$usua_resp		="";
$modi_resp		="";
$query="select fol_orig,conse,to_char(fec_salid,'dd/mm/yyyy') as fec_salid,cve_depe,coment,cve_ins,to_char(fec_comp,'dd/mm/yyyy') as fec_comp,to_char(fec_recdp,'dd/mm/yyyy') as fec_recdp,cve_turn,cve_docto,to_char(fec_elab,'dd/mm/yyyy') as fec_elab,txt_resp,to_char(fec_notifica,'dd/mm/yyyy') as fec_notifica,viable,to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu,cve_urge,califresp,usua_sal,modi_sal,usua_resp,modi_resp,cve_resp from docsal where fol_orig='$fol_parametro' and conse='$conse_parametro'";
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
	$fec_recdp		= $sql->f("fec_recdp");
	$cve_turn		= $sql->f("cve_turn");
	$cve_docto_sal	= $sql->f("cve_docto");
	$fec_elab_sal	= $sql->f("fec_elab");
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
	if ($cve_urge=="") {
		$situacion_texto_original="NO REQUIERE RESPUESTA";
	} else {
		if ($fec_conclu!="") {
			$situacion_texto_original="RESUELTO";
		} else {
			$situacion_texto_original="PENDIENTE";
		}
	}
	if ($cve_depe!="") {
		$sql2 = new scg_DB;
		$sql2->query("select nom_depe,titulo_titu,nom_titu,car_titu from dependencia where cve_depe='$cve_depe'");
		if ($sql2->num_rows($sql2) == 1) {
			if ($sql2->next_record()) {
				$nom_depe	= $sql2->f("nom_depe");
				$titulo_titu= $sql2->f("titulo_titu");
				$nom_titu	= $sql2->f("nom_titu");
				$car_titu	= $sql2->f("car_titu");
			}
		}
		//$sql2->disconnect($sql2->Link_ID);
	}
	if ($cve_turn!="") {
		$sql2 = new scg_DB;
		$sql2->query("select nom_turn,car_turn from turnador where cve_turn='$cve_turn'");
		if ($sql2->num_rows($sql2) == 1) {
			if ($sql2->next_record()) {
				$nom_turn	= $sql2->f("nom_turn");
				$car_turn	= $sql2->f("car_turn");
			}
		}
		//$sql2->disconnect($sql2->Link_ID);
	}
	if ($cve_ins!="") {
		$sql2 = new scg_DB;
		$sql2->query("select instruccion from instruccion where cve_ins='$cve_ins'");
		if ($sql2->num_rows($sql2) == 1) {
			if ($sql2->next_record()) {
				$instruccion = $sql2->f("instruccion");
			}
		}
		//$sql2->disconnect($sql2->Link_ID);
	}
}

?>
<html>
<head>
	<script language="JavaScript1.2">
	var agt=navigator.userAgent.toLowerCase();
	function displayBio(obj) {
		var docURL = location.href;
		if (obj.checked) {
			if (docURL.indexOf('showBibliography') == -1) {
				location.href = docURL+"&showBibliography=Y";
			} else {
				location.href = docURL.replace( /showBibliography=N/, "showBibliography=Y" );
			}
		}	else {
			if (docURL.indexOf('showBibliography') == -1) {
				location.href = docURL+"&showBibliography=N";
			}else {
				location.href = docURL.replace( /showBibliography=Y/, "showBibliography=N" );
			}
		}
	}
	function imprimeVolante() {
		var prn = new Image();
		prn.src="<? echo 'impresion.php?sess=$sess&anio_parametro=$anio_parametro&userid=$userid'; ?>";
		if (window.print) {
			setTimeout('window.print();',200);
		} else if (agt.indexOf("mac") != -1) {
			alert("Oprima 'Cmd+p' para imprimir.");
		}	else {
			alert("Oprim 'Ctrl+p' para imprimir.")
		}
	}
	</script>
	<?php
	if ($accion=="para_entrega" || $accion=="transmitida") {
		print("<title>PARA ENTREGA</title>\n");
	} else {
		if ($accion=="preliminar") {
			print("<title>VERSIÓN PRELIMINAR</title>\n");
		} else {
			print("<title>$default->ssp_title_in_header</title>\n");
		}
	}
	?>
	<link rel="stylesheet" type="text/css" title="style1" href="<?php echo($default->styles)?>">
</head>
<body bgColor="#FFFFFF" onLoad="imprimeVolante();">
<center>
<table width="700" border="0" bordercolor="#EEEEEE" cellspacing="0" cellpadding="0">
<tr>
<td align="left" width="192">
   <?php echo "<img src='$default->scg_graphics_url/logo_stc.jpg' border=0 width=\"192\" height=\"47\">"; ?>
</td>
<td align="center">
    <font face="Arial" size="3"><b><i>Turno de Correspondencia</i></b></font>
</td>
<td align="right" width="170">
   <?php echo "<img src='$default->scg_graphics_url/ger134.png' border=0 width=\"170\" height=\"43\">"; ?>
</td>
</tr>
</table>
<br>
<table width="700" border="0" bordercolor="#EEEEEE" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
 <tr>
   <td width="65%" valign="top" align="left">
      <table width="100%" border="0" cellspacing="<? echo $espaciado+1; ?>" cellpadding="<? echo $espaciado+1; ?>">
       <tr>
        <td width="15%" valign="top">
         <font face="Arial" size="2">Para:</font>
        </td>
        <td width="85%" align="left" valign="top">
         <font class="chiquito"><b>
	    <?php
	    if ($nom_titu) {
			if ($titulo_titu) $nom_titu="$titulo_titu $nom_titu";
			echo "$nom_titu";
		}
		if ($car_titu) echo "<br>$car_titu";
	    ?>
         </b></font>
        </td>
       </tr>
       <tr>
        <td width="15%" valign="top">
         <font face="Arial" size="2"><br>De:</font>
        </td>
        <td width="85%" align="left" valign="top">
         <font class="chiquito"><b><br>
	    <?php
	    if ($nom_turn) {
			echo "$nom_turn";
		}
		if ($car_turn) echo "<br>$car_turn";
	    ?>
         </b></font>
        </td>
       </tr>
      </table>
  </td>
  <td width="35%" valign="top" align="left">
   <table width="100%" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
	<tr>
	 <td align="center" bgcolor="#EEEEEE">
         <font face="Arial" size="3"><b>Recepción</b></font>
	 </td>
	</tr>
    <tr>
     <td>
      <table width="100%" border="0" cellspacing="<? echo $espaciado+1; ?>" cellpadding="<? echo $espaciado+1; ?>">
       <tr>
        <td width="35%" valign="top">
         <font face="Arial" size="2">Folio:</font>
        </td>
        <td width="65%" align="left" valign="top">
         <font class="chiquito"><b><? echo "$fol_orig-$conse_parametro"; ?></b></font>
        </td>
       </tr>
       <tr>
        <td width="35%" valign="top">
         <font face="Arial" size="2">Fecha:</font>
        </td>
        <td width="65%" align="left" valign="top">
         <font class="chiquito"><b><? echo "$fec_recep"; ?></b></font>
        </td>
       </tr>
       <tr>
        <td width="35%" valign="top">
         <font face="Arial" size="2">Hora:</font>
        </td>
        <td width="65%" align="left" valign="top">
         <font class="chiquito"><b><? echo "$hora_recep"; ?></b></font>
        </td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>
</table>
<br>
<table width="700" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
 <td align="center" bgcolor="#EEEEEE">
	 <font face="Arial" size="3"><b>Procedencia</b></font>
 </td>
</tr>
<tr>
 <td>
  <table width="100%" border="0" cellspacing="<? echo $espaciado+1; ?>" cellpadding="<? echo $espaciado+1; ?>">
   <tr>
	<td width="15%" valign="top">
	 <font face="Arial" size="2">Número:</font>
	</td>
	<td width="85%" align="left" valign="top">
	 <font class="chiquito"><b>
		<?php echo "$cve_docto &nbsp;"; ?>
	 </b></font>
	</td>
   </tr>
   <tr>
	<td width="20%" valign="top">
	 <font face="Arial" size="2">Fecha del oficio:</font>
	</td>
	<td width="80%" align="left" valign="top">
	 <font class="chiquito"><b>
		<?php echo "$fec_elab &nbsp;"; ?>
	 </b></font>
	</td>
   </tr>
   <tr>
	<td width="15%" valign="top">
	 <font face="Arial" size="2">Área:</font>
	</td>
	<td width="85%" align="left" valign="top">
	 <font class="chiquito"><b>
	<?php
	$sql = new scg_DB;
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
</table>
<br>
<table width="700" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
 <td align="center" bgcolor="#EEEEEE">
	 <font face="Arial" size="3"><b>Asunto</b></font>
 </td>
</tr>
<tr>
 <td valign="top" height="125">
 	 <font class="chiquito"><b>
		<?php echo "$txt_resum &nbsp;"; ?>
	 </b></font>
 </td>
</tr>
</table>
<br>
<table width="700" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
 <td align="center" bgcolor="#EEEEEE">
	 <font face="Arial" size="3"><b>Instrucciones</b></font>
 </td>
</tr>

<tr>
	<td valign="top" height="150">

  <table width="100%" border="0" cellspacing="<? echo $espaciado+1; ?>" cellpadding="<? echo $espaciado+1; ?>">
   <tr>
	<td width="25%" valign="top">
	 <font face="Arial" size="2">Instrucción:</font>
	</td>
	<td width="75%" align="left" valign="top">
	 <font class="chiquito"><b>
	    <?php echo "$instruccion &nbsp;"; ?>
	 </b></font>
	</td>
   </tr>
   <tr>
	<td width="25%" valign="top">
	 <font face="Arial" size="2">Instrucciones adicionales:</font>
	</td>
	<td width="75%" align="left" valign="top">
	 <font class="chiquito"><b>
	    <?php echo "$coment &nbsp;"; ?>
	 </b></font>
	</td>
   </tr>
<table>
<br>




<table width="697" border="0" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
    <td width="20%" aling="center">
       <font face="Arial" size="1"><center>Preparar Respuesta</center></font>
   	</td>

   	<td width="20%" aling="center">
   	    <font face="Arial" size="1"><center>Para su Análisis</center></font>
    </td>
    <td width="20%" aling="center">
		<font face="Arial" size="1"><center>Para su Conocimiento</center></font>
    </td>
	<td width="20%" aling="center">
      	<font face="Arial" size="1"><center>Comentarios</center></font>
   	</td>
   	<td width="20%" aling="center">
        <font face="Arial" size="1"><center>Atención Procedente</center></font>
	</td>
</tr>
</table>

<table width="697" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
    <td width="20%" aling="center">
       <br>
   	</td>

   	<td width="20%" aling="center">
   	    <br>
    </td>
    <td width="20%" valing="top">
		<br>
    </td>
	<td width="20%" valing="top">
      	<br>
   	</td>
   	<td width="20%" valing="top">
       <br>
	</td>
</tr>
<table>

<br>

   <tr>
      <td width="25%" valign="top">
    	  <font face="Arial" size="2">Fecha compromiso:</font>
      </td>
	  <td width="75%" align="left" valign="top">
 	      <font class="chiquito"><b>
	      <?php echo "$fec_comp &nbsp;"; ?> .-
	      <font class="alerta"><b>
		  <?php
		  switch ($cve_urge) {
			     case '':
				      echo '&nbsp;No requiere respuesta';
			          break;
			     case 'O':
				      echo '&nbsp;Requiere respuesta ordinaria';
			          break;
			     case 'U':
				      echo '&nbsp;Requiere respuesta urgente';
			          break;
			     case 'E':
				      echo '&nbsp;Requiere respuesta extraurgente';
			          break;
		         }
		  ?>
		  </b></font>
	 </b></font>
	</td>
   </tr>
  </table>
 </td>
</tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="5">
<tr><br>
 <td valign="top" height="100">
	 <font face="Arial" size="3"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A t e n t a m e n t e</b></font>
	 <br><br><br><br><br>
	 _____________________________
 </td>
</tr>
</table>
<br>
<table width="700" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
 <td align="center" bgcolor="#EEEEEE">
	 <font face="Arial" size="3"><b>Conclusión</b></font>
 </td>
</tr>
<tr>
 <td valign="top" height="100">
 	 <font class="chiquito"><b>
		<br>
	 </b></font>
 </td>
</tr>
</table>
<table width="700" border="1" bordercolor="#EEEEEE" cellspacing="0" cellpadding="1">
<tr>
 <td align="center" bgcolor="#EEEEEE">
	 <font face="Arial" size="2"><b>
	 Regresar este formato con su conclusión y firma en el tiempo señalado
	 </b></font>
 </td>
</tr>
</table>
</center>
</body>
<?php
//$sql->disconnect($sql->Link_ID);
?>
