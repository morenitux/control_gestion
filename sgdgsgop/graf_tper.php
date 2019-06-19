<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	graf_tper.php
|	Autor:		Saúl E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Mayo 2003
|
|	Gobierno del Distrito Federal
|	Oficialía Mayor
|	Coordinación Ejecutiva de Desarrollo Informático
|	Dirección de Nuevas Tecnologías
|
|	Última actualización:	04/11/2002
|
--------------------------------------------------------------------------------------*/
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
require("./includes/readhd.php");
$titulo_en_header = $default->scg_title_in_header;
$windowname = "Graficos";
include("./includes/header.inc");
$anio_now  =date("Y");
$string_de_valores="";
$string_de_titulos="";
$string_de_colores="";


$titulo_grafico = "";
switch ($tipo_reporte) {
	case 1:
		$titulo_grafico = "";
		$sql = new scg_DB;
		$query2="select nom_depe from dependencia where cve_depe='$parametro'";
		$sql->query($query2);
		$ya_puse_este_anio="N";
		if ($sql->num_rows($sql) > 0) {
			while($sql->next_record()) {
				$nom_depe = ($sql->f("0"));
			}
		}
		$titulo_grafico=$nom_depe;
	break;
}

$valor=explode(",",$cadena_valores);
//$valor[0] total
//$valor[1] no requiere respuesta
//$valor[2] si requiere respuesta
//$valor[3] pendiente
//$valor[4] en tramite
//$valor[5] resuelto

$resueltos  = $valor[5]+$valor[1];
$pendientes = $valor[3];
$en_tramite = $valor[4];
$total = $resueltos + $pendientes + $en_tramite;


echo "<center>";
echo "<br><br>";
echo "<font class='bigsubtitle'>$titulo_grafico</font>";
echo "<br>";
echo "<font class='bigsubtitle'>$anio_reporte</font>";
echo "<br><br>";
if ($total > 0) {
	exec("rm -f pastel*"); //Instrucción de Shell para borrar archivos con pregunta
	flush();  // Es para dar un refresh
	$n=date("Hms");
	$nombregraf="pastel$n";
	include("./includes/class.graph");

	$arreglo_totales = array($resueltos,$pendientes,$en_tramite);
	$arreglo_titulos = array("Resueltos = $resueltos","Pendientes = $pendientes","En trámite = $en_tramite");
	$arreglo_colores = array("lgreen","gold","lyellow","lgreen","skyblue","steelblue","slateblue","dpurple");

	$a = array(
		$arreglo_titulos,
		$arreglo_totales
	);
	phpplot(array(
		"cubic"=> true,
		"title_text"=> "",
		"transparent"=> true,
		"size"=> array(600,300),
		"colorset"=> $arreglo_colores
		)
	);
	phpdata($a);
	phpdraw("piegraph",array( "drawsets" => array(1)));
	phpshow($nombregraf);
	echo "<img src=\"$nombregraf\" border=3><br><br>";

	echo "&nbsp;";
	print("</td>\n");


}
echo "</center>";
include("./includes/footer.inc");
?>