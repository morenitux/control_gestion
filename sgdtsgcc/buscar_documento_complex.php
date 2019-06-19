<?php
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");

$fol_orig		= strtoupper($fol_orig);
$domicilio		= strtoupper($domicilio);
$colonia		= strtoupper($colonia);
$codigo_post	= strtoupper($codigo_post);
$telefono		= strtoupper($telefono);
$entidad		= strtoupper($entidad);
$delegacion		= strtoupper($delegacion);
$comentarios	= strtoupper($comentarios);
$cve_docto		= strtoupper($cve_docto);
$cve_prom		= strtoupper($cve_prom);
$cve_remite		= strtoupper($cve_remite);
$cve_dirigido	= strtoupper($cve_dirigido);
$antecedente	= strtoupper($antecedente);
$nom_suje		= strtoupper($nom_suje);
$firmante		= strtoupper($firmante);
$cargo_fmte		= strtoupper($cargo_fmte);
$cve_tipo		= strtoupper($cve_tipo);
$cve_expe		= strtoupper($cve_expe);
$txt_resum		= strtoupper($txt_resum);
$cve_evento		= strtoupper($cve_evento);

if ($default->scg_tipo_folios!="1" && $fol_orig=="AUTOMATICO") {
	$fol_orig="";
}


$cuantos_hay=0;
$sql = new scg_DB;
$query_complex="fol_orig is not null ";
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
if ($fec_elab && $control_fec_elab) {
	if ($query_complex) $query_complex.="and ";
	$query_complex.="to_char(fec_elab,'dd/mm/yyyy') like '%$fec_elab%' ";
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
if ($clasif==1) {
	if ($query_complex) $query_complex.="and ";
	$query_complex.="clasif='1' ";
}
if ($nacional==1) {
	if ($query_complex) $query_complex.="and ";
	$query_complex.="nacional='1' ";
}
if ($confi==1) {
	if ($query_complex) $query_complex.="and ";
	$query_complex.="confi='1' ";
}
if ($salida==1) {
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
$condicion_adicional="";
if ($ok["vista"]!="") {
	$condicion_adicional="documento.fol_orig in (select fol_orig from docsal where cve_depe='".$ok["vista"]."' group by fol_orig)";
}
if ($condicion_adicional!="") {
	$query_complex.=" and ".$condicion_adicional;
}
$por_tema="";
$num_cachos=count($cve_tema);
if ($num_cachos>0) {
	for ($y=0; $y<$num_cachos; $y++) {
		if ($por_tema && $y>0) $por_tema.="or ";
			$por_tema.="cve_tema='$cve_tema[$y]' ";
	}
	if ($por_tema) {
		$por_tema="fol_orig in (select fol_orig from doctem where ".$por_tema.") ";
		if ($query_complex) $query_complex.="and ";
		$query_complex.=$por_tema;

	}
}
if ($anio_busqueda && $anio_busqueda!="9999") {
	$query_complex.=" and date_part('year',documento.fec_regi)='$anio_busqueda'";
}
if ($query_complex=="") {
	$query_complex="fol_orig is null";
}
$query="SELECT fol_orig from documento where ".$query_complex;
$cuantos_hay=0;
//echo "Query: $query<br>";

$sql->query($query);
$cuantos_hay= $sql->num_rows($sql);
//echo "Cuantos $cuantos_hay<br>";

if ($cuantos_hay==0) {
	//$sql->disconnect($sql->Link_ID);
	header("Location: principal.php?sess=$sess&control_botones_superior=1&not_found=complex");
} else {
	if ($cuantos_hay>1) {
		//echo "Sí son mas de uno<br>";
		$parametro_por_tema="";
		$num_cachos=count($cve_tema);
		if ($num_cachos>0) {
			for ($y=0; $y<$num_cachos; $y++) {
				if ($parametro_por_tema && $y>0) $parametro_por_tema.="&";
					$parametro_por_tema.="cve_tema[".$y."]=$cve_tema[$y]";
			}
		}
		//$sql->disconnect($sql->Link_ID);
		header("Location: listados.php?sess=$sess&control_botones_superior=1&parametro=complex&variable=lista_documentos_por_busqueda&modificador=folio&fol_orig=$fol_orig&domicilio=$domicilio&colonia=$colonia&codigo_post=$codigo_post&telefono=$telefono&entidad=$entidad&delegacion=$delegacion&comentarios=$comentarios&fec_recep=$fec_recep&control_fec_recep=$control_fec_recep&hora_recep=$hora_recep&control_hora_recep=$control_hora_recep&cve_docto=$cve_docto&fec_elab=$fec_elab&control_fec_elab=$control_fec_elab&cve_prom=$cve_prom&cve_expe=$cve_expe&cve_remite=$cve_remite&cve_dirigido=$cve_dirigido&antecedente=$antecedente&nom_suje=$nom_suje&firmante=$firmante&cargo_fmte=$cargo_fmte&cve_tipo=$cve_tipo&txt_resum=$txt_resum&cve_evento=$cve_evento&fec_eve=$fec_eve&hora_evento=$hora_evento&clasif=$clasif&nacional=$nacional&confi=$confi&salida=$salida&anio_busqueda=$anio_busqueda&$parametro_por_tema");
	} else {
		if ($sql->next_record()) $parametro = $sql->f("fol_orig");
		//$sql->disconnect($sql->Link_ID);
		if (substr($control_menu_superior,1,1)=="1") {
			header("Location: listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&parametro=$parametro");
		} else {
			header("Location: listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento_consulta&parametro=$parametro");
		}
	}
}
?>