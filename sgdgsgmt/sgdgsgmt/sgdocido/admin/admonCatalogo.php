<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	admonCatalogo.php
|	Autor:		Saúl E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Noviembre 2002
|
|	Gobierno del Distrito Federal
|	Oficialía Mayor
|	Coordinación Ejecutiva de Desarrollo Informático
|	Dirección de Nuevas Tecnologías
|
|	Última actualización:	04/11/2002
|
--------------------------------------------------------------------------------------*/
require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");

print ("<body bgcolor='$default->body_bgcolor' text='$default->body_textcolor' link='$default->body_link' vlink='$default->body_vlink' onLoad='window.opener.document.plantilla_documento.ventana_auxiliar.value=\"abierta\"'>\n");
print ("<link rel='stylesheet' type='text/css' title='style1' href='$default->styles'>");

$bgcolor_titulos="#003399";
$color_1="FFFFFF";
$color_2="FFFFCC";
switch ($control_catalogos) {
	case "1":
		$variable=$lang_cat_1;
		$query = "select cve_prom,siglas,nom_prom,tit_prom,car_titu,tipo,telefono from promotor where baja is null order by nom_prom ";
	break;
	case "2":
		$variable=$lang_cat_2;
		$query = "select cve_expe,cve_expe as cve_expe2,nom_expe from expediente where baja is null order by cve_expe ";
	break;
	case "3":
		$variable=$lang_cat_3;
		$query = "select cve_tema,topico from tema where tipo='T' and baja is null order by topico";
	break;
	case "4":
		$variable=$lang_cat_4;
		$query = "select cve_tema,topico from tema where tipo='E' and baja is null order by topico";
	break;
	case "5":
		$variable=$lang_cat_5;
		$query = "select cve_depe,siglas,nom_depe,nom_titu,car_titu,null as clave from dependencia where baja is null union select cve_depe,siglas,nom_depe,nom_titu,car_titu,'<img src=\"$default->scg_graphics_url/buzon.gif\" border=\"0\" alt=\"'||clave||'\">' as clave from dependencia,depe_buzon where baja is null and cve_depe=clave order by nom_depe";
	break;
	case "6":
		$variable=$lang_cat_6;
		$query = "select cve_turn,nom_turn,car_turn,no_oficio from turnador where baja is null order by nom_turn";
	break;
	case "7":
		$variable=$lang_cat_7;
		$query = "select cve_ins,instruccion from instruccion where tipo='I' and baja is null order by instruccion";
	break;
	case "8":
		$variable=$lang_cat_8;
		$query = "select cve_ins,instruccion from instruccion where tipo='D' and baja is null order by instruccion";
	break;
	case "9":
		$variable=$lang_cat_9;
		$query = "select clave,nombre,cargo from dirigido where baja is null order by nombre";
	break;
}
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$sql = new scg_DB;
$sql->query($query);
$num = $sql->num_rows($sql);
$campos = $sql->num_fields($sql);
$tope=$campos-2;
if ($origen=="") {
	print("<center><a href='abcCatalogo.php?sess=$sess&control_catalogos=$control_catalogos&accion=insert&origen=$origen'><img src='$default->scg_graphics_url/alta.gif' border='0' alt='$lang_new'></a><font class='chiquito'>$lang_new</font>&nbsp;&nbsp;&nbsp;<a href='javascript: window.opener.document.plantilla_documento.ventana_auxiliar.value=\"cerrada\"; window.close();'><img src='$default->scg_graphics_url/puertita.gif' border='0' alt='$lang_close'></a><font class='chiquito'>$lang_close</font>\n");
} else {
	print("<center><a href='abcCatalogo.php?sess=$sess&control_catalogos=$control_catalogos&accion=insert&origen=$origen'><img src='$default->scg_graphics_url/alta.gif' border='0' alt='$lang_new'></a><font class='chiquito'>$lang_new</font>&nbsp;&nbsp;&nbsp;<a href='javascript: window.opener.location.reload(); window.close();'><img src='$default->scg_graphics_url/puertita.gif' border='0' alt='$lang_close'></a><font class='chiquito'>$lang_close</font>\n");
}
if ($num > 0) {
	$i = 0;
	print("<table border='0' cellspacing='2' cellpadding='2'>\n");
	print("\t<tr>\n");
	print("\t\t<td align='center' bgcolor='$bgcolor_titulos'>\n");
	print("\t\t\t<br>\n");
	print("\t\t</td>\n");
	print("\t\t<td align='center' colspan='2' bgcolor='$bgcolor_titulos'>\n");
	print("\t\t\t<font class='chiquitoblanco'>1</font>\n");
	print("\t\t</td>\n");
	$control=0;
	while($control<$tope) {
		$control2=$control+2;
		print("\t\t<td align='center' class='chiquitoblanco' bgcolor='$bgcolor_titulos'>\n");
		print("\t\t\t$control2\n");
		print("\t\t</td>\n");
		$control++;
	}
	print("\t</tr>\n");
	$color_renglon=$color_1;
	while($sql->next_record()) {
		$control=0;
		$n=$i+1;
		while($control<$campos) {
			$campo[$control] = $sql->f("$control");
			if ($control==0) {
				print("\t<tr bgcolor='#"."$color_renglon'>\n");
				print("\t\t<td valign='top' class='chiquito'>$n.-</td>\n");
			} else {
				if ($control==1) {
					print("\t\t<td valign='top' class='chiquito'>$campo[1]&nbsp;</td>\n");
					print("<td valign='top' class='chiquito'>");
					$campo[0]=str_replace(" ","~",$campo[0]);
					echo "<a href='abcCatalogo.php?id=$campo[0]&sess=$sess&control_catalogos=$control_catalogos&accion=update&origen=$origen'><img src='$default->scg_graphics_url/cambio.gif' border='0' alt='cambioDependencia.php?id=$campo[0]'></a> ";
					echo "<a href=abcCatalogo.php?id=$campo[0]&sess=$sess&control_catalogos=$control_catalogos&accion=delete&origen=$origen><img src='$default->scg_graphics_url/baja.gif' border='0' alt=\"Baja\"></a>";
					print("</td>\n");
				} else {
					print("<td valign='top' class='chiquito'>$campo[$control]&nbsp;</td>\n");
				}
			}
			$control++;
		}
		print("</tr>\n");
		$i++;
		if ($color_renglon==$color_1) {
			$color_renglon=$color_2;
		} else {
			$color_renglon=$color_1;
		}
	}
} else {
	print("<table border='0' cellspacing='2' cellpadding='2'>\n");
	print("\t<tr bgcolor='#".$color_2."'>\n");
	print("\t\t<td colspan='8' valign='top' align='center' class='chiquito'>\n");
	print("$lang_no_catresults\n");
	print("\t\t</td>\n");
	print("\t</tr>\n");
}
print("</table><br>\n");
print("</center>\n");
?>