<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	graficos.php
|	Autor:		Saúl E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Diciembre 2002
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

switch ($tipo_reporte) {
	case "1": //Por promotor
		$criterio="Promotor";
		$query="SELECT
		promotor.nom_prom,
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when cve_Segui='0' then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		documento.cve_prom
		from documento documento
		left join promotor promotor
		on (documento.cve_prom=promotor.cve_prom)
		where documento.fol_orig is not null ";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by promotor.nom_prom,documento.cve_prom
		order by promotor.nom_prom,documento.cve_prom";
	break;
	case "2": //Por remitente
		$criterio="Remitente";
		$query="SELECT
		promotor.nom_prom,
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when cve_Segui='0' then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		documento.cve_remite
		from documento documento
		left join promotor promotor
		on (documento.cve_remite=promotor.cve_prom)
		where documento.fol_orig is not null ";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by promotor.nom_prom,documento.cve_remite
		order by promotor.nom_prom,documento.cve_remite";
	break;
	case "3": //Por tipo de documento
		$criterio="Tipo de documento";
		$query="SELECT
		instruccion.instruccion,
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when cve_Segui='0' then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		documento.cve_tipo
		from documento documento
		left join instruccion instruccion
		on (documento.cve_tipo=instruccion.cve_ins)
		where documento.fol_orig is not null ";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by instruccion.instruccion,documento.cve_tipo
		order by instruccion.instruccion,documento.cve_tipo";
	break;
	case "4": //Por año
		$criterio="Documentos por año";
		$query="SELECT
		date_part('year',documento.fec_regi),
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when cve_Segui='0' then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		date_part('year',documento.fec_regi)
		from documento documento
		where documento.fol_orig is not null ";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by date_part('year',documento.fec_regi)
		order by date_part('year',documento.fec_regi)";
	break;
	case "5": //Por mes del año actual
		$criterio="Documentos-".$anio_now;
		$query="SELECT
		date_part('month',documento.fec_regi),
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when cve_Segui='0' then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		date_part('month',documento.fec_regi)
		from documento
		where documento.fol_orig is not null
		and date_part('year',documento.fec_regi)='".$anio_now."'::float8 ";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by date_part('month',documento.fec_regi)";
	break;
}

//echo $query."<br>";

$sql = new scg_DB;
$sql->query($query);

$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	while($sql->next_record()) {
		$tope=6; //uno menos, la ultima columna es el identificador del criterio
		$col[0] =	$sql->f("0");
		if ($columna=="0") {
			$campo_traer=1;
		} else {
			$campo_traer=$columna;
		}
		$col[1] = $sql->f($campo_traer);
		switch ($campo_traer) {
			case "0":
				$subcriterio="Total";
			break;
			case "1":
				$subcriterio="Total";
			break;
			case "2":
				$subcriterio="Turnados";
			break;
			case "3":
				$subcriterio="En Archivo";
			break;
			case "4":
				$subcriterio="Relevantes";
			break;
			case "5":
				$subcriterio="Intersecretariales";
			break;
			case "6":
				$subcriterio="Confidenciales";
			break;
		}
		if ($tipo_reporte=="5") {
			$mes=$col[0];
			switch ($mes) {
				case "1":
					$col[0]="Enero";
				break;
				case "2":
					$col[0]="Febrero";
				break;
				case "3":
					$col[0]="Marzo";
				break;
				case "4":
					$col[0]="Abril";
				break;
				case "5":
					$col[0]="Mayo";
				break;
				case "6":
					$col[0]="Junio";
				break;
				case "7":
					$col[0]="Julio";
				break;
				case "8":
					$col[0]="Agosto";
				break;
				case "9":
					$col[0]="Septiembre";
				break;
				case "10":
					$col[0]="Octubre";
				break;
				case "11":
					$col[0]="Noviembre";
				break;
				case "12":
					$col[0]="Diciembre";
				break;
			}
		}
		//echo "$col[0] - $col[1]<br>";
		if ($col[1]>0) {
			$string_de_valores.="$col[1]$%&";
			$string_de_titulos.="$col[0]$%&";
		}
	}
//	$sql->disconnect($sql->Link_ID);

	/*$string_de_valores=substr($string_de_valores,0,strlen($string_de_valores)-1);
	$string_de_titulos=substr($string_de_titulos,0,strlen($string_de_titulos)-1);
	echo "$string_de_valores<br>";
	echo "$string_de_titulos<br>";*/

	exec("rm -f pastel*"); //Instrucción de Shell para borrar archivos con pregunta
	flush();  // Es para dar un refresh
	$n=date("Hms");
	$nombregraf="pastel$n";
	include("./includes/class.graph");

	$arreglo_totales = explode("$%&",$string_de_valores);
	$arreglo_titulos = explode("$%&",$string_de_titulos);
	$arreglo_colores = array("skyblue","steelblue","slateblue","dpurple","red","gold","lyellow","skyblue","lgreen");

	$a = array(
		$arreglo_titulos,
		$arreglo_totales
	);
	phpplot(array(
		"cubic"=> true,
		"title_text"=> "$criterio, $subcriterio (% de distribución)",
		"transparent"=> true,
		"size"=> array(500,300),
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
include("./includes/footer.inc");
?>