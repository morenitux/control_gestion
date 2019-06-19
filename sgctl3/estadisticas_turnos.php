<script language="JavaScript" src="includes/gotoPage.js"></script>
<?

$condicion_adicional="";
if ($ok["vista"]!="") {
	$condicion_adicional="docsal.cve_depe='".$ok["vista"]."'";
}

//INICIALIZACION DE VARIABLES
$fecha_now = date("d/m/Y");
$hora_now  = date("H:i");
$anio_now  = date("Y");
//ccedillo
if ($anio_reporte=="") $anio_reporte=$anio_now;
//ccedillo
$bgcolor_titulos="#6C9CFF";
$color_1="EAEAEA";
$color_2="C6FFFF";
if (!$tipo_reporte) {
	$tipo_reporte=1; //el reporte por default es por los turnados a:
}
switch ($tipo_reporte) {
	case "1": //Por turnados a:
		$criterio="Turnado a: (".$anio_reporte.")";
		$query="SELECT
		Dependencia.Nom_Depe,
		Count(*),
		sum(Case When cve_resp='' then 1 end),
		sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end),
		sum(Case When CVE_RESP='N' then 1 end),
		sum(Case When cve_resp='A' then 1 end),
		sum(Case When cve_resp='S' then 1 end),
		Docsal.Cve_Depe
		FROM DOCSAL Docsal Left Join Dependencia Dependencia On (Docsal.Cve_Depe=Dependencia.Cve_Depe)
		WHERE Docsal.Fol_Orig IS NOT NULL";
		if ($anio_reporte!="") {
			$query.=" and Date_Part('year',Docsal.Fec_salid)=".($anio_reporte)."::float8";
		}
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" GROUP BY Dependencia.Nom_Depe,Docsal.Cve_Depe,Dependencia.Siglas order by Dependencia.Nom_Depe";
	break;
	case "2": //Por fecha de compromiso
		$criterio="Por fecha de compromiso-".$anio_reporte;
		$query="SELECT
		Date_Part('month',Docsal.Fec_Comp),
		Count(*),
		sum(Case When cve_resp='' then 1 end),
		sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end),
		sum(Case When CVE_RESP='N' then 1 end),
		sum(Case When cve_resp='A' then 1 end),
		sum(Case When cve_resp='S' then 1 end),
		Date_Part('month',Docsal.Fec_Comp)
		FROM DOCSAL Docsal
		WHERE Date_Part('year',Docsal.Fec_Comp)=".($anio_reporte)."::float8";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" GROUP BY Date_Part('month',Docsal.Fec_Comp) order by Date_Part('month',Docsal.Fec_Comp)";
	break;
	case "3": //Por tipo de documento
		$criterio="Tipo de documento-".$anio_reporte;
		$query="SELECT
		Instruccion.Instruccion,
		Count(*),
		sum(Case When cve_resp='' then 1 end),
		sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end),
		sum(Case When CVE_RESP='N' then 1 end),
		sum(Case When cve_resp='A' then 1 end),
		sum(Case When cve_resp='S' then 1 end),
		documento.Cve_Tipo
		FROM Docsal Docsal, Documento Documento Left Join Instruccion Instruccion On (Documento.Cve_Tipo=Instruccion.Cve_Ins)
		WHERE Docsal.Fol_Orig=Documento.Fol_orig";
		//ccedillo
		if ($anio_reporte!="") {
			$query.=" and Date_Part('year',Docsal.Fec_salid)=".($anio_reporte)."::float8";
		}
		//ccedillo
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" GROUP BY Instruccion.Instruccion,Documento.Cve_Tipo order by Instruccion.Instruccion";
	break;
	case "4": //Por a�o
		$criterio="Turnos por a�o";
		$query="SELECT
		Date_Part('year',Docsal.Fec_salid),
		Count(*),
		sum(Case When cve_resp='' then 1 end),
		sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end),
		sum(Case When CVE_RESP='N' then 1 end),
		sum(Case When cve_resp='A' then 1 end),
		sum(Case When cve_resp='S' then 1 end),
		Date_Part('year',Docsal.Fec_salid)
		FROM DOCSAL Docsal";
		if ($condicion_adicional!="") {
			$query.=" WHERE ".$condicion_adicional;
		}
		$query.=" GROUP BY Date_Part('year',Docsal.Fec_salid) order by Date_Part('year',Docsal.Fec_salid)";
	break;
	case "5": //Por mes del a�o actual
		$criterio="Turnos-".$anio_reporte;
		$query="SELECT
		Date_Part('month',Docsal.Fec_salid),
		Count(*),
		sum(Case When cve_resp='' then 1 end),
		sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end),
		sum(Case When CVE_RESP='N' then 1 end),
		sum(Case When cve_resp='A' then 1 end),
		sum(Case When cve_resp='S' then 1 end),
		Date_Part('month',Docsal.Fec_salid)
		FROM DOCSAL Docsal
		WHERE Date_Part('year',Docsal.Fec_Salid)='$anio_reporte'::float8";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" GROUP BY Date_Part('month',Docsal.Fec_salid) order by Date_Part('month',Docsal.Fec_salid)";
	break;
	case "6": //Turnos del d�a
		$criterio="Turnos del día-".$fecha_now;
		$query="SELECT
		Dependencia.Nom_Depe,
		Count(*),
		sum(Case When cve_resp='' then 1 end),
		sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end),
		sum(Case When CVE_RESP='N' then 1 end),
		sum(Case When cve_resp='A' then 1 end),
		sum(Case When cve_resp='S' then 1 end),
		Docsal.Cve_Depe
		FROM DOCSAL Docsal Left Join Dependencia Dependencia On (Docsal.Cve_Depe=Dependencia.Cve_Depe)
		WHERE Docsal.Fol_Orig IS NOT NULL and to_char(docsal.fec_salid,'dd/mm/yyyy')='$fecha_now'";
		if ($condicion_adicional!="") {
			$query.=" and ".$condicion_adicional;
		}
		$query.=" GROUP BY Dependencia.Nom_Depe,Docsal.Cve_Depe,Dependencia.Siglas order by Dependencia.Nom_Depe";
	break;
}

print("<form name='estadisticas_turnos' action='principal.php?sess=$sess&control_botones_superior=5' method='post'>\n");
print("<select name='anio_reporte' onChange=\"gotoPage('principal.php?sess=$sess&control_botones_superior=5&anio_reporte='+document.estadisticas_turnos.anio_reporte.options[document.estadisticas_turnos.anio_reporte.selectedIndex].value+'&tipo_reporte='+document.estadisticas_turnos.tipo_reporte.options[document.estadisticas_turnos.tipo_reporte.selectedIndex].value);\">\n");

$sql = new scg_DB;
$query2="SELECT date_part('year',docsal.Fec_Comp) as anio from documento,docsal where documento.fol_orig is not null and documento.fol_orig=docsal.fol_orig and docsal.Fec_Comp is not null";
if ($condicion_adicional!="") {
	$query2.=" and ".$condicion_adicional;
}
$query2.=" group by anio";
$query2.=" union SELECT date_part('year',documento.fec_regi) as anio from documento,docsal where documento.fol_orig is not null and documento.fol_orig=docsal.fol_orig and documento.fec_regi is not null";
if ($condicion_adicional!="") {
	$query2.=" and ".$condicion_adicional;
}
$query2.="  group by anio order by anio desc";
$sql->query($query2);
$ya_puse_este_anio="N";
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$anio = ($sql->f("anio"));
		if ($anio_reporte==$anio) {
			print("<option value=$anio selected>$anio</option>\n");
		} else {
			print("<option value=$anio>$anio</option>\n");
		}
	}
}
print("</select>&nbsp;");
print("<select name='tipo_reporte' onChange=\"gotoPage('principal.php?sess=$sess&control_botones_superior=5&tipo_reporte='+this.options[this.selectedIndex].value);\">\n");
if ($tipo_reporte=="1") {
	print("<option value=1 selected>Turnado a:</option>\n");
} else {
	print("<option value=1>Turnado a:</option>\n");
}

if ($tipo_reporte=="2") {
	print("<option value=2 selected>Turnos por fecha de compromiso</option>\n");
} else {
	print("<option value=2>Turnos por fecha de compromiso</option>\n");
}

if ($tipo_reporte=="3") {
	print("<option value=3 selected>Turnos por tipo de documento</option>\n");
} else {
	print("<option value=3>Turnos por tipo de documento</option>\n");
}
if ($tipo_reporte=="4") {
	print("<option value=4 selected>Turnos por año</option>\n");
} else {
	print("<option value=4>Turnos por año</option>\n");
}

if ($tipo_reporte=="5") {
	print("<option value=5 selected>Turnos por mes</option>\n");
} else {
	print("<option value=5>Turnos por mes</option>\n");
}

if ($tipo_reporte=="6") {
	print("<option value=6 selected>Turnos del día</option>\n");
} else {
	print("<option value=6>Turnos del día</option>\n");
}
print("</select>\n");
//print("<input type='submit' value=' Aceptar '>\n");
print("</form>\n");

$sql->query($query);
$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	//abre tabla
	?>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
		<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=0'><font class='chiquitoblanco'>$criterio</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=1'><font class='chiquitoblanco'>Total</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=2'><font class='chiquitoblanco'>No req. respuesta</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=3'><font class='chiquitoblanco'>Req. respuesta</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=4'><font class='chiquitoblanco'>Pendiente</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=5'><font class='chiquitoblanco'>En tr�mite</font></a>"; ?>
			</td>
			<td align='center' class='chiquitoblanco'>
				<? echo "<a href='graficos.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=6'><font class='chiquitoblanco'>Resueltos</font></a>"; ?>
			</td>
		</tr>
	<?
	$color_renglon=$color_1;
	while($sql->next_record()) {
		$tope=6; //uno menos, la ultima columna es el identificador del criterio
		$col[0] 			= $sql->f("0"); //Dependencia.Nom_Depe
		$col[1] 			= $sql->f("1"); //Count(*)
		$col[2]	 			= $sql->f("2"); //sum(Case When cve_resp='' then 1 end)
		$col[3] 			= $sql->f("3"); //sum(Case When CVE_RESP='N' or CVE_RESP='A' or CVE_RESP='S' then 1 end)
		$col[4]				= $sql->f("4"); //sum(Case When CVE_RESP='N' then 1 end)
		$col[5]				= $sql->f("5"); //sum(Case When cve_resp='A' then 1 end)
		$col[6]				= $sql->f("6"); //sum(Case When cve_resp='S' then 1 end)
		$parametro		= $sql->f("7");
		if ($tipo_reporte=='2' || $tipo_reporte=='5') {
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
				//echo "<a href='listados.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&columna=$i&parametro=$parametro'>$col[$i]</a></td>\n";
				if ($i!=0) {
					echo "<a href='listados.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=$i&parametro=$parametro'>$col[$i]</a></td>\n";
				} else {
					//$col[1] total
					//$col[2] no requiere respuesta
					//$col[3] si requiere respuesta
					//$col[4] pendiente
					//$col[5] en tramite
					//$col[6] resuelto

					$cadena_valores="";
					if ($col[1]) { $cadena_valores.=$col[1].","; } else { $cadena_valores.="0,"; }
					if ($col[2]) { $cadena_valores.=$col[2].","; } else { $cadena_valores.="0,"; }
					if ($col[3]) { $cadena_valores.=$col[3].","; } else { $cadena_valores.="0,"; }
					if ($col[4]) { $cadena_valores.=$col[4].","; } else { $cadena_valores.="0,"; }
					if ($col[5]) { $cadena_valores.=$col[5].","; } else { $cadena_valores.="0,"; }
					if ($col[6]) { $cadena_valores.=$col[6]; } else { $cadena_valores.="0"; }
					echo "<a href='graf_tper.php?sess=$sess&control_botones_superior=$control_botones_superior&tipo_reporte=$tipo_reporte&anio_reporte=$anio_reporte&columna=$i&parametro=$parametro&cadena_valores=$cadena_valores'>$col[$i]</a></td>\n";
				}
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
