<?
//INICIALIZACION DE VARIABLES
$condicion_adicional="";
if ($ok["vista"]!="") {
	$condicion_adicional="documento.fol_orig in (select fol_orig from docsal where cve_depe='".$ok["vista"]."' group by fol_orig)";
}
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";
switch ($columna) {
	case "0":
		$criterio_por_columna="";
	break;
	case "1":
		$criterio_por_columna="";
	break;
	case "2":
		$criterio_por_columna=" and cve_segui='1'";
	break;
	case "3":
		$criterio_por_columna=" and (cve_segui='0' or cve_segui='')";
	break;
	case "4":
		$criterio_por_columna=" and clasif='1'";
	break;
	case "5":
		$criterio_por_columna=" and nacional='1'";
	break;
	case "6":
		$criterio_por_columna="and confi='1'";
	break;
}

$query="SELECT
fol_orig,
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
notas
from documento
where documento.fol_orig is not null ";

switch ($tipo_reporte) {
	case "1": //Por promotor
		$criterio="Promotor";
		if ($parametro!="") {
			$query.=" and cve_prom='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and date_part('year',documento.fec_regi)='$anio_reporte'";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
	break;
	case "2": //Por remitente
		$criterio="Promotor";
		if ($parametro!="") {
			$query.=" and cve_remite='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and date_part('year',documento.fec_regi)='$anio_reporte'";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
	break;
	case "3": //Por tipo de documento
		$criterio="Promotor";
		if ($parametro!="") {
			$query.=" and cve_tipo='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and date_part('year',documento.fec_regi)='$anio_reporte'";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
	break;

	case "4": //Por año
		$criterio="Documentos por año";
		if ($parametro!="") {
			$query.=" and date_part('year',documento.fec_regi)='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and date_part('year',documento.fec_regi)='$anio_reporte'";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
	break;
	case "5": //Por mes del año de reporte
		$criterio="Documentos-".$anio_reporte;
		if ($parametro!="") {
			$query.=" and date_part('month',documento.fec_regi)='$parametro'";
		}
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and date_part('year',documento.fec_regi)='$anio_reporte'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
	break;
}
$query.=" order by fol_orig";
$sql = new scg_DB;
//echo $query."############";
$sql->query($query);
$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	//abre tabla
	?>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
	 <tr>
	  <td width=100% align=left>
			<font class='chiquito'>Regresar</font>&nbsp;<a href="javascript: history.go(-1);"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
	  </td>
	 </tr>
	</table>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
		<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
			<td align='center' class='chiquitoblanco'>
				No.
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Núm.Entrada"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Registro/<br>Acuse"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Referencia/<br>Fecha"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Firmante"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Asunto"; ?>
			</td>
		</tr>
	<?
	$x=0;
	$color_renglon=$color_1;
	while($sql->next_record()) {
		$tope=6;	//uno menos, la ultima columna es el identificador del criterio
		$parametro		= $sql->f("0");
		$fol_orig		= $sql->f("0");		//folio
		$fec_regi		= $sql->f("1");		//fecha de registro
		$fec_recep		= $sql->f("2");		//fecha de recepción
		$cve_docto		= $sql->f("3");		//folio del documento
		$fec_elab		= $sql->f("4");		//fecha del documento
		$firmante		= $sql->f("5");		//firmante
		$cve_prom		= $sql->f("6");		//clave del promotor
		$cve_remite		= $sql->f("7");		//clave del remitente
		$txt_resum		= $sql->f("8");		//asunto
		$cve_expe		= $sql->f("9");		//clave del expediente
		$nom_suje		= $sql->f("10");	//nom_suje
		$notas			= $sql->f("11");	//notas
		if (strlen($txt_resum)>400) {
			$txt_resum=substr($txt_resum,0,400)."...";
		}
		$x++;
		echo "<tr bgcolor='#$color_renglon' valign=top>\n<td class='chiquito' align='left'>$x.-</td>";
		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$fol_orig<br><a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento_consulta&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'><img src='$default->scg_graphics_url/consulta.gif' border='0' alt='Detalle'></a>";
	  	if (substr($control_menu_superior,1,1)!="2") {
	  		echo "&nbsp;<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'><img src='$default->scg_graphics_url/cambio.gif' border='0' alt='Edición'></a>";
		}
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$fec_regi<br>$fec_recep";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$cve_docto<br>$fec_elab";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$firmante";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$txt_resum";
	  	echo "\t</td>\n";

		echo "</tr>\n";
		if ($color_renglon==$color_1) {
			$color_renglon=$color_2;
		} else {
			$color_renglon=$color_1;
		}
	}
	//cierra tabla
	?>
	</table>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
	 <tr>
	  <td width=100% align=left>
			<font class='chiquito'>Regresar</font>&nbsp;<a href="javascript: history.go(-1);"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
	  </td>
	 </tr>
	</table>
	<?
}
?>