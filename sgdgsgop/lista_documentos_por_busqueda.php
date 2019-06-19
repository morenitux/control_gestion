<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";

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
notas,
cve_refe
from documento
where documento.fol_orig is not null ";
if ($parametro!='complex') {
	if ($modificador=="folio") {
		$query.=" and fol_orig like '%$parametro%'";
	}
} else {
	$control_regresar='no_back';
	$query_complex="";
	if ($fol_orig) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(fol_orig) like '%$fol_orig%' ";
	}
	if ($domicilio) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(domicilio) like '%$domicilio%' ";
	}
	if ($colonia) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(colonia) like '%$colonia%' ";
	}
	if ($codigo_post) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(codigo_post) like '%$codigo_post%' ";
	}
	if ($telefono) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(telefono) like '%$telefono%' ";
	}
	if ($entidad) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="entidad='$entidad' ";
	}
	if ($delegacion) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="delegacion='$delegacion' ";
	}
	if ($comentarios) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(notas) like '%$comentarios%' ";
	}
	if ($fec_recep && $control_fec_recep) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="to_char(fec_recep,'dd/mm/yyyy') like '%$fec_recep%' ";
	}
	if ($hora_recep && $control_hora_recep) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="to_char(fec_recep,'HH24:mi') like  '%$hora_recep%' ";
	}
	if ($cve_docto) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="(upper(cve_docto) like '%$cve_docto%' or upper(cve_refe) like '%$cve_docto%') ";
	}
	if ($fec_elab && $control_fec_elab) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="to_char(fec_elab,'dd/mm/yyyy') like '%$fec_elab%' ";
	}
	if ($cve_prom) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="cve_prom='$cve_prom' ";
	}
	if ($cve_remite) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="cve_remite='$cve_remite' ";
	}
	if ($cve_dirigido) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="cve_dirigido='$cve_dirigido' ";
	}
	if ($cve_expe!='999') {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(cve_expe)='$cve_expe' ";
	}
	if ($antecedente) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(antecedente) like '%$antecedente%' ";
	}
	if ($nom_suje) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(nom_suje) like '%$nom_suje%' ";
	}
	if ($firmante) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(firmante) like '%$firmante%' ";
	}
	if ($cargo_fmte) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(cargo_fmte) like '%$cargo_fmte%' ";
	}
	if ($cve_tipo) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="cve_tipo='$cve_tipo' ";
	}
	if ($txt_resum) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="upper(txt_resum) like '%$txt_resum%' ";
	}
	if ($cve_evento) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="cve_eve='$cve_evento' ";
	}
	if ($fec_eve) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="to_char(fec_eve,'dd/mm/yyyy') like '%$fec_eve%' ";
	}
	if ($hora_evento) {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="to_char(time_eve,'HH24:mi') like '%$hora_evento%' ";
	}
	if ($clasif=='true') {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="clasif='1' ";
	}
	if ($nacional=='true') {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="nacional='1' ";
	}
	if ($confi=='true') {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="confi='1' ";
	}
	if ($salida=='true') {
		if ($query_complex) $query_complex.="and ";
		$query_complex.="salida='1' ";
	}
	if ($control_fec_recep) {
	}
	if ($control_hora_recep) {
	}
	if ($control_fec_elab) {
	}
	if ($fecha_now) {
	}
	if ($hora_now) {
	}

	$por_tema="";
	$num_cachos=count($cve_tema);
	if ($num_cachos>0) {
		for ($y=0; $y<$num_cachos; $y++) {
			if ($por_tema && $y>0) $por_tema.="or ";
				$por_tema.="cve_tema='$cve_tema[$y]' ";
		}
		if ($por_tema) {
			$por_tema="documento.fol_orig in (select fol_orig from doctem where ".$por_tema.") ";
			if ($query_complex) $query_complex.="and ";
			$query_complex.=$por_tema;

		}
	}

	$condicion_adicional="";
	if ($ok["vista"]!="") {
		$condicion_adicional="documento.fol_orig in (select fol_orig from docsal where cve_depe='".$ok["vista"]."' group by fol_orig)";
	}
	if ($condicion_adicional!="") {
		$query_complex.=" and ".$condicion_adicional;
	}
	if ($query_complex) $query.=" and ";
	$query.=$query_complex;
}
if ($anio_busqueda && $anio_busqueda!="9999") {
	$query.=" and date_part('year',documento.fec_regi)='$anio_busqueda'";
}
$query.=" order by fol_orig";
//echo $query."<br>";

$sql = new scg_DB;
$sql->query($query);
$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	//abre tabla
	?>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
	 <tr>
	  <td width=50% align=left>
			<font class='chiquito'>Regresar</font>&nbsp;<a href="<?php if ($control_regresar!='no_back') { echo 'javascript: history.go(-1);'; } else { echo 'principal.php?sess='.$sess.'&control_botones_superior=1'; } ?>"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
	  </td>
	  <td width=50% align=right>
	        <font class=grande><? echo number_format($numero_renglones)." reportes seleccionados."; ?></font>
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
		$cve_refe		= $sql->f("12");	//referencia de turnos electronicos
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
	  	echo "\t\t$cve_docto<br>";
	  	if ($cve_refe) echo "$cve_refe<br>";
	  	echo "$fec_elab";
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
 	   <font class='chiquito'>Regresar</font>&nbsp;<a href="<?php if ($control_regresar!='no_back') { echo 'javascript: history.go(-1);'; } else { echo 'principal.php?sess='.$sess.'&control_botones_superior=1'; } ?>"><? echo "<img src='$default->scg_graphics_url"."/back.gif' border='0'>"; ?></a>
	  </td>
	 </tr>
	</table>
	<?
}
//$sql->disconnect($sql->Link_ID);
?>