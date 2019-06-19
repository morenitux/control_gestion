<?
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$condicion_adicional="";
if ($ok["vista"]!="") {
	$condicion_adicional="documento.fol_orig in (select fol_orig from docsal where cve_depe='".$ok["vista"]."' group by fol_orig)";
}
if ($anio_busqueda && $anio_busqueda!="9999") {
	$condicion_adicional2="date_part('year',documento.fec_regi)='$anio_busqueda'";
	if ($condicion_adicional) $condicion_adicional=$condicion_adicional2." and ".$condicion_adicional;
}
$cuantos_hay=0;
$sql = new scg_DB;
$query="SELECT count(*) from documento where fol_orig like '%$parametro%'";
if ($condicion_adicional!="") {
	$query.=" and ".$condicion_adicional;
}
$sql->query($query);
if ($sql->next_record()) {
	$cuantos_hay = $sql->f("0");
}
if ($cuantos_hay==0) {
	header("Location: principal.php?sess=$sess&control_botones_superior=1&not_found=$parametro");
} else {
	if ($cuantos_hay>1) {
		header("Location: listados.php?sess=$sess&control_botones_superior=1&parametro=$parametro&variable=lista_documentos_por_busqueda&modificador=folio&anio_busqueda=$anio_busqueda");
	} else {
		$query="SELECT fol_orig from documento where fol_orig like '%$parametro%'";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$sql->query($query);
		if ($sql->next_record()) {
			$parametro = $sql->f("0");
		}
		header("Location: listados.php?sess=$sess&control_botones_superior=1&variable=detalle_documento&parametro=$parametro");
	}
}
?>
