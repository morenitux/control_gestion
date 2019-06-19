<script language="JavaScript" src="includes/gotoPage.js"></script>
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
if (!$tipo_reporte) {
	$tipo_reporte=5; //el reporte por default es por mes del a�o
}
if (!$anio_reporte) {
	if ($tipo_reporte=="4") {
		$anio_reporte="TODOS";
	} else {
		$anio_reporte=$anio_now;
	}
}
switch ($tipo_reporte) {
	case "1": //Por promotor
		$criterio="Promotor";
		$query="SELECT
		promotor.nom_prom,
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when (cve_segui='0' or cve_segui='') then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		documento.cve_prom
		from documento documento
		left join promotor promotor
		on (documento.cve_prom=promotor.cve_prom)
		where documento.fol_orig is not null ";
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and Date_Part('year',documento.fec_regi)=".($anio_reporte)."::float8";
		}
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
		sum(case when (cve_segui='0' or cve_segui='') then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		documento.cve_remite
		from documento documento
		left join promotor promotor
		on (documento.cve_remite=promotor.cve_prom)
		where documento.fol_orig is not null ";
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and Date_Part('year',documento.fec_regi)=".($anio_reporte)."::float8";
		}
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
		sum(case when (cve_segui='0' or cve_segui='') then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		documento.cve_tipo
		from documento documento
		left join instruccion instruccion
		on (documento.cve_tipo=instruccion.cve_ins)
		where documento.fol_orig is not null ";
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and Date_Part('year',documento.fec_regi)=".($anio_reporte)."::float8";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by instruccion.instruccion,documento.cve_tipo
		order by instruccion.instruccion,documento.cve_tipo";
	break;
	case "4": //Por a�o
		$criterio="Documentos por año";
		$query="SELECT
		date_part('year',documento.fec_regi),
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when (cve_segui='0' or cve_segui='') then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		date_part('year',documento.fec_regi)
		from documento documento
		where documento.fol_orig is not null ";
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and Date_Part('year',documento.fec_regi)=".($anio_reporte)."::float8";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by date_part('year',documento.fec_regi)
		order by date_part('year',documento.fec_regi)";
	break;
	case "5": //Por mes del a�o actual
		$criterio="Documentos-".$anio_reporte;
		$query="SELECT
		date_part('month',documento.fec_regi),
		count(*),
		sum(case when cve_segui='1' then 1 end),
		sum(case when (cve_segui='0' or cve_segui='') then 1 end),
		sum(case when clasif='1' then 1 end),
		sum(case when nacional='1' then 1 end),
		sum(case when confi='1' then 1 end),
		date_part('month',documento.fec_regi)
		from documento
		where documento.fol_orig is not null ";
		if ($anio_reporte && $anio_reporte!="TODOS") {
			$query.=" and Date_Part('year',documento.fec_regi)=".($anio_reporte)."::float8";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" group by date_part('month',documento.fec_regi)";
	break;
}
print("<form name='estadisticas_documentos' action='principal.php?sess=$sess&control_botones_superior=3' method='post'>\n");
print("<select name='anio_reporte' onChange=\"gotoPage('principal.php?sess=$sess&control_botones_superior=3&anio_reporte='+document.estadisticas_documentos.anio_reporte.options[document.estadisticas_documentos.anio_reporte.selectedIndex].value+'&tipo_reporte='+document.estadisticas_documentos.tipo_reporte.options[document.estadisticas_documentos.tipo_reporte.selectedIndex].value);\">\n");
$sql = new scg_DB;
$query2="SELECT date_part('year',documento.fec_regi) as anio from documento where documento.fol_orig is not null";
if ($condicion_adicional!="") {
	$query2.=" and ".$condicion_adicional;
}
$query2.=" group by anio order by anio desc";
$sql->query($query2);
$ya_puse_este_anio="N";
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$anio = ($sql->f("anio"));
		if ($anio_reporte==$anio) {
			print("<option value='$anio' selected>$anio</option>\n");
		} else {
			print("<option value='$anio'>$anio</option>\n");
		}
	}
}
print("<option value='TODOS'");
if ($anio_reporte=="TODOS") echo " selected";
print(">TODOS</option>\n");
print("</select>&nbsp;");
print("<select name='tipo_reporte' onChange=\"gotoPage('principal.php?sess=$sess&control_botones_superior=3&anio_reporte='+document.estadisticas_documentos.anio_reporte.options[document.estadisticas_documentos.anio_reporte.selectedIndex].value+'&tipo_reporte='+document.estadisticas_documentos.tipo_reporte.options[document.estadisticas_documentos.tipo_reporte.selectedIndex].value);\">\n");
if ($tipo_reporte=="1") {
	print("<option value=1 selected>Por promotor</option>\n");
} else {
	print("<option value=1>Por promotor</option>\n");
}
if ($tipo_reporte=="2") {
	print("<option value=2 selected>Por remitente</option>\n");
} else {
	print("<option value=2>Por remitente</option>\n");
}
if ($tipo_reporte=="3") {
	print("<option value=3 selected>Por tipo de documento</option>\n");
} else {
	print("<option value=3>Por tipo de documento</option>\n");
}
if ($tipo_reporte=="4") {
	print("<option value=4 selected>Por año</option>\n");
} else {
	print("<option value=4>Por año</option>\n");
}
if ($tipo_reporte=="5") {
	print("<option value=5 selected>Por mes</option>\n");
} else {
	print("<option value=5>Por mes</option>\n");
}


/*
$sql = new scg_DB;
$query2="SELECT date_part('year',documento.fec_regi) as anio from documento where documento.fol_orig is not null ";
if ($condiciona_adicional!="") {
	$query2.=" and ".$condiciona_adicional;
}
$query2.=" group by anio order by anio";
$sql->query($query2);
$ya_puse_este_anio="N";
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$anio = $sql->f("anio");
		if ($anio_now==$anio) $ya_puse_este_anio="S";
		if ($tipo_reporte=="$anio") {
			print("<option value=$anio selected>Por mes ($anio)</option>\n");
		} else {
			print("<option value=$anio>Por mes ($anio)</option>\n");
		}
	}
}
if ($ya_puse_este_anio=="N") {
	if ($tipo_reporte=="$anio_now") {
		print("<option value=$anio_now selected>Por mes ($anio_now)</option>\n");
	} else {
		print("<option value=$anio_now>Por mes ($anio_now)</option>\n");
	}
}*/

print("</select>\n");
print("</form>\n");

//print($query);
$sql->query($query);
$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	//abre tabla
	?>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
		<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=0'><font class='chiquitoblanco'>$criterio</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=1'><font class='chiquitoblanco'>Total</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=2'><font class='chiquitoblanco'>Turnados</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=3'><font class='chiquitoblanco'>En Archivo</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=4'><font class='chiquitoblanco'>Relevantes</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=5'><font class='chiquitoblanco'>Intersecretariales</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=6'><font class='chiquitoblanco'>Confidenciales</font></a>"; ?>
			</td>
		</tr>
	<?
	$color_renglon=$color_1;
	while($sql->next_record()) {
		$tope=6; //uno menos, la ultima columna es el identificador del criterio
		$col[0] 			=	$sql->f("0");
		$col[1] 			= $sql->f("1");
		$col[2]	 			= $sql->f("2");
		$col[3] 			= $sql->f("3");
		$col[4]				= $sql->f("4");
		$col[5]				= $sql->f("5");
		$col[6]				= $sql->f("6");
		$parametro		= $sql->f("7");
		// $parametro		= str_replace("","",$parametro);
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
		for ($i = 0; $i <= $tope; $i++) {
			$valor=$col[$i];
			if ($i==0) {
				echo "<tr bgcolor='#$color_renglon'>\n<td class='chiquito' align='left'>";
				$gran_total[$i]=$valor;
			} else {
				echo "<td class='chiquito' align='right'>";
				$gran_total[$i]+=$valor;
			}
			if (!$valor) {
					if ($i==0) {
						echo "-</td>\n";
					} else {
						echo "0</td>\n";
					}
			} else {
					echo "<a href='listados.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=$i&parametro=$parametro'>$col[$i]</a></td>\n";
			}
			if ($i==$tope) {
				echo "</tr>\n";
				if ($color_renglon==$color_1) {
					$color_renglon=$color_2;
				} else {
					$color_renglon=$color_1;
				}
			}
		}
	}
	//cierra tabla
	?>
		<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
			<td align='center' class='chiquitoblanco'>
				Total:
			</td>
			<?
			for ($i = 1; $i <= $tope; $i++) {
				echo "<td class='chiquitoblanco' align='right'>$gran_total[$i]</td>\n";
			}
			?>
		</tr>
	</table>
	<?
}
?>
