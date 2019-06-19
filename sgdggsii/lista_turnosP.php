<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#6C9CFF";
$color_1="EAEAEA";
$color_2="C6FFFF";
$anio_busqueda="";
$pal_reporte="";
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
$texto_vencidos=($pendientes=="V" ? "Vencidos" : "Por Preescribir");
$condi=($pendientes=="V" ? " " : "+ interval '4 day'");
$query="SELECT
docsal.fol_orig,
conse,
to_char(fec_salid,'dd/mm/yyyy'),
documento.cve_docto,
documento.txt_resum,
nom_depe,
to_char(docsal.fec_comp,'dd/mm/yyyy')
FROM docsal,dependencia,documento";
$query.=" WHERE documento.fol_orig=docsal.fol_orig and docsal.cve_depe=dependencia.cve_depe and docsal.fol_orig is not null and docsal.fec_comp>now() and  docsal.fec_comp<=now()+ interval '4 day'  and cve_resp='N'";
switch ($tipo_reporte) {
	case "1": //Por Dependencia
		if ($dependencia) {
			$criterio="Turnos $texto_vencidos".($anio_reporte!="TODOS" ? " del $anio_reporte" : " registrados en la base de datos")." a $dependencia";
		} else {
			$criterio="Turnos $texto_vencidos".($anio_reporte!="TODOS" ? " del $anio_reporte" : " registrados en la base de datos")." a $parametro";
		}
		$query.=" and docsal.cve_depe='$parametro' ";
		if ($anio_reporte!="TODOS") $query.=" and Date_Part('year',Docsal.Fec_salid)='$anio_reporte' ";
	break;
	case "2": //Por fecha compromiso (mes)
		$criterio="Turnos $texto_vencidos con fecha compromiso en $mes_parametro".($anio_reporte!="TODOS" ? " del $anio_reporte" : " registrados en la base de datos");
		$query.=" and Date_Part('month',Docsal.Fec_Comp)='$parametro' ";
		if ($anio_reporte!="TODOS") $query.="  and Date_Part('year',Docsal.Fec_salid)='$anio_reporte' ";
	break;
	case "3": //Por tipo de documento
		$query.=" and docsal.fol_orig=documento.fol_orig and cve_tipo='$parametro' ";
		if ($anio_reporte!="TODOS") $query.=" and Date_Part('year',Docsal.Fec_salid)='$anio_reporte' ";
		$criterio="$parametro1 turnados".($anio_reporte!="TODOS" ? "durante $anio_reporte": " registrados en la base de datos");
	break;
	case "4": //Turnos por año
		$criterio="Turnos $texto_vencidos del $parametro";
		$query.=" and date_part('year',docsal.fec_salid)='$parametro'";
	break;
	case "5": //Por mes del año actual
		$criterio="Turnos $texto_vencidos de $mes_parametro".($anio_reporte!="TODOS" ? " del $anio_reporte" : " registrados en la base de datos");
		if ($anio_reporte!="TODOS") $query.=" and date_part('year',docsal.fec_salid)='$anio_reporte'";
		$query.=" and date_part('month',docsal.fec_salid)='$parametro' ";
	break;
}
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
			<td align='center' class='chiquitoblanco'>No.</td>
			<td align='center' class='chiquitoblanco'>Núm.Entrada</td>
			<td align='center' class='chiquitoblanco'>Fecha de turno</td>
			<td align='center' class='chiquitoblanco'>Referencia</td>
			<td align='center' class='chiquitoblanco'>Asunto</td>
			<td align='center' class='chiquitoblanco'>Turnado a</td>
			<td align='center' class='chiquitoblanco'>Fecha compromiso</td>
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