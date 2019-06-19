<script language="Javascript" src="includes/gotoPage.js"></script>
<script language="Javascript">
function regform_Validator(f) {
}
</script>
<table width=100% border=0 cellspacing=1 cellpadding=1>
 <tr>
  <td width=100% align=center>
   <br>
   <font class='bigsubtitle'>Usuario: <?php echo $parametro; ?></font>
  </td>
 </tr>
</table>
<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";

$onDocumentos = 0;
$onDescargos = 0;
$estdocumentos	= 0;
$estturnos 	= 0;
$buzonsolicitudes = 0;
$buzonrespuestas = 0;

$promotores = 0;
$expedientes = 0;
$temas = 0;
$eventos = 0;
$dependencias = 0;
$turnadores = 0;
$instrucciones = 0;
$tiposdocumento = 0;
$destinatarios = 0;

$cve_vista = "";

$sql = new scg_DB;
$sql->query("select count(*) as cuantos from privi_opcion where usuario is not null and usuario='$parametro'");
while($sql->next_record()) {
	$cuantos = $sql->f("0");
}
$privilegio = array();

if ($cuantos>0) {
	$query="SELECT upper(objeto) as objeto,usuario from privi_opcion where usuario is not null and usuario not in ('SYSSCG','SYSSQLBZ') and usuario='$parametro' order by objeto";
	$sql->query($query);
	$numero_renglones = $sql->num_rows($sql);
	$i=0;
	if ($numero_renglones > 0) {
		$color_renglon=$color_1;
		while($sql->next_record()) {
			$objeto			= "";
			$objeto			= $sql->f("objeto");
			$privilegio[$i] = $objeto;
			$largo			= strlen($objeto);
			$posicion_cambio= $largo - 5;
			$pedazo_vista	= substr($objeto,$posicion_cambio,5);
			if ($pedazo_vista=="VISTA") {
				$cve_vista	= substr($objeto,0,$posicion_cambio);
			}
			$i++;
		}
	}
}

if (in_array("PBSOLVOL",$privilegio)) {
	$onDocumentos = 1;
}
if (in_array("PBCONSUDOC",$privilegio)) {
	$onDocumentos = 2;
}
if (in_array("PBRESP",$privilegio)) {
	$onDescargos = 1;
}
if (in_array("PBCONSURESP",$privilegio)) {
	$onDescargos = 2;
}
if (in_array("PBESTDOC",$privilegio)) {
	$estdocumentos	= 1;
}
if (in_array("PBSEGEJEC",$privilegio)) {
	$estturnos 	= 1;
}
if (in_array("PBBUZONV",$privilegio)) {
	$buzonsolicitudes = 1;
}
if (in_array("PBBUZONRESP",$privilegio)) {
	$buzonrespuestas = 1;
}

if (in_array("PBPROMO",$privilegio)) {
	$promotores = 1;
}
if (in_array("PBEXPE",$privilegio)) {
	$expedientes = 1;
}
if (in_array("PBTEMA",$privilegio)) {
	$temas = 1;
}
if (in_array("PBEVENTO",$privilegio)) {
	$eventos = 1;
}
if (in_array("PBDEPE",$privilegio)) {
	$dependencias = 1;
}
if (in_array("PBTURNA",$privilegio)) {
	$turnadores = 1;
}
if (in_array("PBINSTRU",$privilegio)) {
	$instrucciones = 1;
}
if (in_array("PBTIPODOC",$privilegio)) {
	$tiposdocumento = 1;
}
if (in_array("PBDIRIGE",$privilegio)) {
	$destinatarios = 1;
}
if (in_array("PBUSERS",$privilegio)) {
	$controlusuarios = 1;
}


/*
echo "onDocumentos	$onDocumentos<br>";
echo "onDescargos	$onDescargos<br>";
echo "estdocumentos	$estdocumentos<br>";
echo "estturnos	$estturnos<br>";
echo "buzonsolicitudes	$buzonsolicitudes<br>";
echo "buzonrespuestas	$buzonrespuestas<br>";
// "PBCONDOC": //Consulta de Documentos
// "PBSEGUIMIENTO" //Seguimiento de turnos
echo "promotores 		$promotores<br>";
echo "expedientes 		$expedientes<br>";
echo "temas 			$temas<br>";
echo "eventos 			$eventos<br>";
echo "dependencias 		$dependencias<br>";
echo "turnadores 		$turnadores<br>";
echo "instrucciones 	$instrucciones<br>";
echo "tiposdocumento 	$tiposdocumento<br>";
echo "destinatarios 	$destinatarios<br>";
*/
?>
<form name="consola_privilegios" action="validaPrivilegios.php?sess=<?php echo $sess; ?>" method="post" target="_self" onSubmit="return regform_Validator(this);">
<table width=80% border=0 cellspacing=5 cellpadding=5>
 <tr valign=top>
  <td width=66% align=center>
   <table width=100% border=1 cellspacing=2 cellpadding=2>
    <tr>
     <td width=50% align=center>
      <font class='bigsubtitle'>
      Documentos y<br>
      Turnos
      </font>
     </td>
     <td width=50% align=center>
      <font class='bigsubtitle'>
      Respuestas<br>
      Descargos
      </font>
     </td>
    </tr>
    <tr>
     <td width=50% align=left>
      <input type="radio" name="onDocumentos"<?php if (!$onDocumentos || $onDocumentos=="0") echo " checked"; ?> value=0>&nbsp;Ningún privilegio
     </td>
     <td width=50% align=left>
      <input type="radio" name="onDescargos"<?php if (!$onDescargos || $onDescargos=="0") echo " checked"; ?> value=0>&nbsp;Ningún privilegio
     </td>
    </tr>
    <tr>
     <td width=50% align=left>
      <input type="radio" name="onDocumentos"<?php if ($onDocumentos=="1") echo " checked"; ?> value=1>&nbsp;Registro
     </td>
     <td width=50% align=left>
      <input type="radio" name="onDescargos"<?php if ($onDescargos=="1") echo " checked"; ?> value=1>&nbsp;Registro
     </td>
    </tr>
    <tr>
     <td width=50% align=left>
      <input type="radio" name="onDocumentos"<?php if ($onDocumentos=="2") echo " checked"; ?> value=2>&nbsp;Sólo consulta
     </td>
     <td width=50% align=left>
      <input type="radio" name="onDescargos"<?php if ($onDescargos=="2") echo " checked"; ?> value=2>&nbsp;Sólo consulta
     </td>
    </tr>
   </table>
   <br>
   <table width=100% border=1 cellspacing=2 cellpadding=2>
    <tr>
     <td width=100% align=center>
      <font class='bigsubtitle'>
	  Acceso a módulos adicionales:<br>
	  </font>
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="estdocumentos"<?php if ($estdocumentos=="1") echo " checked"; ?> value="estdocumentos">&nbsp;Estadísticas de Documentos
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="estturnos"<?php if ($estturnos=="1") echo " checked"; ?> value="estturnos">&nbsp;Estadísticas de Turnos
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="buzonsolicitudes"<?php if ($buzonsolicitudes=="1") echo " checked"; ?> value="buzonsolicitudes">&nbsp;Buzón de Solicitudes
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="buzonrespuestas"<?php if ($buzonrespuestas=="1") echo " checked"; ?> value="buzonrespuestas">&nbsp;Buzón de Respuestas
	 </td>
	</tr>
   </table>
  </td>
  <td width=34% align=center>
   <table width=100% border=1 cellspacing=2 cellpadding=2>
    <tr>
     <td width=100% align=center>
      <font class='bigsubtitle'>
	  Acceso a Catálogos<br>
	  </font>
	  <font class='negritas'>
	  (Altas, bajas y cambios)
	  </font>
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="promotores"<?php if ($promotores==1) echo " checked"; ?> value="promotores">&nbsp;Promotores-Remitentes
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="expedientes"<?php if ($expedientes==1) echo " checked"; ?> value="expedientes">&nbsp;Expedientes
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="temas"<?php if ($temas==1) echo " checked"; ?> value="temas">&nbsp;Temas (Clasificación)
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="eventos"<?php if ($eventos==1) echo " checked"; ?> value="eventos">&nbsp;Eventos
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="dependencias"<?php if ($dependencias==1) echo " checked"; ?> value="dependencias">&nbsp;Áreas (Dependencias)
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="turnadores"<?php if ($turnadores==1) echo " checked"; ?> value="turnadores">&nbsp;Turnadores
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="instrucciones"<?php if ($instrucciones==1) echo " checked"; ?> value="instrucciones">&nbsp;Instrucciones
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="tiposdocumento"<?php if ($tiposdocumento==1) echo " checked"; ?> value="tiposdocumento">&nbsp;Tipos de Documentos
	 </td>
	</tr>
    <tr>
     <td width=100% align=left>
	  <input type="checkbox" name="destinatarios"<?php if ($destinatarios==1) echo " checked"; ?> value="destinatarios">&nbsp;Destinatarios
	 </td>
	</tr>
   </table>
  </td>
 </tr>
</table>
<table width=80% border=0 cellspacing=5 cellpadding=5>
 <tr>
  <td>
   <font class='bigsubtitle'>Vincular este usuario con el área:</font><br>
   <select name="cve_depe">
   <?php
    if (!$cve_vista) {
    	echo "<option value=0 selected>USUARIO DEL ESQUEMA GENERAL</option>\n";
	} else {
		echo "<option value=0>USUARIO DEL ESQUEMA GENERAL</option>\n";
	}
	$sql = new scg_DB;
	$sql->query("select nom_depe,cve_depe from dependencia where baja is null order by nom_depe,cve_depe");
	if ($sql->num_rows($sql) > 0) {
		while($sql->next_record()) {
			$cve_depe = $sql->f("cve_depe");
			$nom_depe = $sql->f("nom_depe");
			if ($cve_vista && $cve_depe==$cve_vista) {
				echo "<option value='$cve_depe' selected>$nom_depe</option>\n";
			} else {
				echo "<option value='$cve_depe'>$nom_depe</option>\n";
			}
		}
	}
   ?>
   </select>
   <br>
   <font size=-1>(Todos los privilegios actuarán exclusivamente sobre el subconjunto de documentos turnados a esta área)</font>
  </td>
 </tr>
 <tr>
  <td>
   <input type="checkbox" name="controlusuarios"<?php if ($controlusuarios==1) echo " checked"; ?> value="controlusuarios">&nbsp;
   <font class='bigsubtitle'>Acceso a control de usuarios</font><br>
   <font size=-1>(Se requiere que la cuenta sea de un usuario del esquema general)</font>
  </td>
 </tr>
</table>
<br><br>
<input type="hidden" name="usuario" value="<?php echo $parametro; ?>">
<input type="submit" value="Actualizar">&nbsp;<input type="button" value="Cancelar" onClick="gotoPage('principal.php?sess=<?php echo $sess; ?>&control_botones_superior=10');">
</form>