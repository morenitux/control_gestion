<?
//INICIALIZACION DE VARIABLES
$anio_busqueda="";
$pal_reporte="";
$condicion_adicional="";
if ($ok["vista"]!="") {
	$condicion_adicional="docsal.cve_depe='".$ok["vista"]."'";
}

$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#6C9CFF";
$color_1="EAEAEA";
$color_2="C6FFFF";
switch ($columna) {
	case "0":
		$criterio_por_columna="";
		$criterio_texto_por_columna="";
	break;
	case "1":
		$criterio_por_columna="";
		$criterio_texto_por_columna="";
	break;
	case "2":
		$criterio_por_columna=" and CVE_RESP=''";
		$criterio_texto_por_columna="No requieren respuesta";
		$pal_reporte.="[cve_resp===vacio]";
	break;
	case "3":
		$criterio_por_columna=" and (CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S')";
		$criterio_texto_por_columna="Requieren respuesta";
		$pal_reporte.="[cve_resp===TODOSMENOSVACIO]";
	break;
	case "4":
		$criterio_por_columna=" and CVE_RESP='N'";
		$criterio_texto_por_columna="Pendientes";
		$pal_reporte.="[cve_resp===N]";
	break;
	case "5":
		$criterio_por_columna=" and CVE_RESP='A'";
		$criterio_texto_por_columna="En trámite";
		$pal_reporte.="[cve_resp===A]";
	break;
	case "6":
		$criterio_por_columna="and CVE_RESP='S'";
		$criterio_texto_por_columna="Resueltos";
		$pal_reporte.="[cve_resp===S]";
	break;
}

if ($tipo_reporte=='1' || $tipo_reporte=='6') {
	$query="SELECT nom_depe,siglas from dependencia where cve_depe='$parametro'";
	$sql = new scg_DB;
	$sql->query($query);
	$numero_renglones = $sql->num_rows($sql);
	if ($numero_renglones > 0) {
		while($sql->next_record()) {
			$nom_depe	= $sql->f("nom_depe");
			$siglas		= $sql->f("siglas");
		}
	}
	if ($siglas) {
		$dependencia=$siglas;
	} else {
		if ($nom_depe) {
			$dependencia=$nom_depe;
		} else {
			$dependencia="";
		}
	}
}

if ($tipo_reporte=='2' || $tipo_reporte=='5') {
	$mes_parametro="";
	switch ($parametro) {
		case "1":
			$mes_parametro="Enero";
		break;
		case "2":
			$mes_parametro="Febrero";
		break;
		case "3":
			$mes_parametro="Marzo";
		break;
		case "4":
			$mes_parametro="Abril";
		break;
		case "5":
			$mes_parametro="Mayo";
		break;
		case "6":
			$mes_parametro="Junio";
		break;
		case "7":
			$mes_parametro="Julio";
		break;
		case "8":
			$mes_parametro="Agosto";
		break;
		case "9":
			$mes_parametro="Septiembre";
		break;
		case "10":
			$mes_parametro="Octubre";
		break;
		case "11":
			$mes_parametro="Noviembre";
		break;
		case "12":
			$mes_parametro="Diciembre";
		break;
	}
}

$query="SELECT
docsal.fol_orig,
conse,
to_char(fec_salid,'dd/mm/yyyy'),
documento.cve_docto,
documento.txt_resum,
nom_depe,
to_char(docsal.fec_comp,'dd/mm/yyyy')
FROM docsal,dependencia,documento";
$query.=" WHERE documento.fol_orig=docsal.fol_orig and docsal.cve_depe=dependencia.cve_depe and docsal.fol_orig is not null ";
switch ($tipo_reporte) {
	case "1": //Por Dependencia
		if ($dependencia) {
			$criterio="Turnos del $anio_reporte a $dependencia";
		} else {
			$criterio="Turnos del $anio_reporte a $parametro";
		}
		if ($parametro!="") {
			$query.=" and docsal.cve_depe='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		if ($anio_reporte!="") {
			$query.=" and Date_Part('year',Docsal.Fec_salid)='$anio_reporte'";
		}
		$pal_reporte.="[cve_depe===$parametro]";
		$anio_busqueda = $anio_reporte;
	break;
	case "2": //Por fecha compromiso (mes)
		$criterio="Turnos con fecha compromiso en $mes_parametro del $anio_reporte";
		if ($parametro!="") {
			$query.=" and Date_Part('month',Docsal.Fec_Comp)='$parametro' and Date_Part('year',Docsal.Fec_Comp)=$anio_reporte::float8 ";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$pal_reporte.="[month_fec_comp===$parametro]";
		$pal_reporte.="[year_fec_comp===$anio_reporte]";
		$anio_busqueda = '';
	break;
	case "3": //Por tipo de documento
		$query.=" and docsal.fol_orig=documento.fol_orig";
		$criterio="$parametro turnados durante $anio_reporte";
		if ($parametro!="") {
			$query.=" and cve_tipo='$parametro' and Date_Part('year',Docsal.Fec_salid)='$anio_now'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		if ($anio_reporte!="") {
			$query.=" and Date_Part('year',Docsal.Fec_salid)='$anio_reporte'";
		}
		$pal_reporte.="[cve_tipo===$parametro]";
		$anio_busqueda = $anio_reporte;
	break;
	case "4": //Turnos por año
		$criterio="Turnos del $parametro";
		if ($parametro!="") {
			$query.=" and date_part('year',docsal.fec_salid)='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$pal_reporte.="[year_fec_salid===$parametro]";
		$anio_busqueda = $parametro;
	break;
	case "5": //Por mes del año actual
		$criterio="Turnos de $mes_parametro del $anio_reporte";
		if ($parametro!="") {
			$query.=" and date_part('year',docsal.fec_salid)='$anio_reporte' and date_part('month',docsal.fec_salid)='$parametro' ";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$pal_reporte.="[month_fec_salid===$parametro]";
		$anio_busqueda = $anio_reporte;
	break;
	case "6": //Por día de hoy
		if ($dependencia) {
					$criterio="Turnos del día $fecha_now a $dependencia";
		} else {
			$criterio="Turnos del día $fecha_now a $parametro";
		}
		if ($parametro!="") {
			$query.=" and to_char(docsal.fec_salid,'dd/mm/yyyy')='$fecha_now' and docsal.cve_depe='$parametro'";
		}
		if ($criterio_por_columna!="") {
			$query.=$criterio_por_columna;
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$pal_reporte.="[cve_depe===$parametro]";
		$pal_reporte.="[fec_salid===$fecha_now]";
		$anio_busqueda = $anio_now;
	break;
}
if ($criterio_texto_por_columna && $criterio) $criterio=$criterio." ".$criterio_texto_por_columna."";

$query.=" order by docsal.cve_depe, fol_orig";
//echo "$query<br>";
$sql = new scg_DB;
$sql->query($query);

$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	//abre tabla
	?>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
	 <tr>
	  <td width=50% align=left>
		<a href="javascript: history.go(-1);"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>&nbsp;
		<font class='bigsubtitle'><? echo $criterio; ?></font>
	  </td>
	  <td width=50% align=right>
			<? print("<a href=\"javascript: newWindow('reporte_generico_pdf.php?sess=$sess&pal_reporte=$pal_reporte&anio_busqueda=$anio_busqueda',1024,800,'ReportePDF');\">"); ?><? echo "<img src='$default->scg_graphics_url"."/bot_impresion.gif' border='0' alt='Imprimir este listado' title='Imprimir este listado'>"; ?></a>&nbsp;<font class='chiquito'>Imprimir</font>
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
				<? echo "Fecha de turno"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Referencia"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Asunto"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Turnado a"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "Fecha compromiso"; ?>
			</td>
		</tr>
	<?
	$x=0;
	$color_renglon=$color_1;
	while($sql->next_record()) {
		$tope=6;			//uno menos, la ultima columna es el identificador del criterio
		$parametro		= $sql->f("0");
		$fol_orig		=	$sql->f("0");		//folio
		$turno			=	$sql->f("1");		//turno
		$fec_salid		=	$sql->f("2");		//fecha de turno
		$cve_docto		=	$sql->f("3");		//No. de documento
		$asunto			=	$sql->f("4");		//Asunto
		$nom_depe		=	$sql->f("5");		//Dependencia
		$fec_comp		=	$sql->f("6");		//Fecha copromiso de respuesta
		if (strlen($asunto)>400) {
			$asunto=substr($asunto,0,400)."...";
		}
		$x++;
		echo "<tr bgcolor='#$color_renglon' valign=top>\n<td class='chiquito' align='left'>$x.-</td>";
		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "$fol_orig<br><a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento_consulta&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'><img src='$default->scg_graphics_url/consulta.gif' border='0' alt='Detalle'></a>";
	  	if (substr($control_menu_superior,1,1)!="2") {
			echo "&nbsp;<a href='listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'><img src='$default->scg_graphics_url/cambio.gif' border='0' alt='Edición'></a>";
		}
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$fec_salid";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$cve_docto&nbsp";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$asunto&nbsp;";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$nom_depe&nbsp;";
	  	echo "\t</td>\n";

		echo "\t<td class='chiquito' align='left'>\n";
	  	echo "\t\t$fec_comp&nbsp;";
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
		<a href="javascript: history.go(-1);"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
	  </td>
	 </tr>
	</table>
	<?
}