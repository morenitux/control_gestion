<?
/*--------------------------------------------------------------------------------------
|	Archivo:        pendientes1.php
|       Autor:          Alfredo Morales Becerra (alfmorales@metro.df.gob.mx)
|       Fecha:          Marzo 2006
|
|       Sistema de Transporte Colectivo
|       Direcci�n de Transportaci�n
|       Proyecto: "Sistema de Gesti�n"
|
|       �ltima adaptaci�n para Transportaci�n:   24/06/2008
|
--------------------------------------------------------------------------------------*/
?><script language="JavaScript" src="includes/gotoPage.js"></script><?
//INICIALIZACION DE VARIABLES
$fecha_now = date("d/m/Y");
$hora_now  = date("H:i");
$anio_now  = date("Y");
//ccedillo
//if ($anio_reporte=="") $anio_reporte=$anio_now;
//ccedillo
$bgcolor_titulos="#6C9CFF";
$color_1="EAEAEA";
$color_2="C6FFFF";
$texto_vencidos=($pendientes=="V" ? "Vencidos" : "Por Preescribir");
$texto_vencidos=($pendientes=="S" ? "Vigentes" : $texto_vencidos);
$dias=($pendientes=="V" ? " docsal.CVE_RESP='N' and docsal.fec_comp<=now()" : " docsal.fec_comp>now() and  docsal.fec_comp<=now()+ interval '4 day'");
$dias=($pendientes=="S" ? "docsal.fec_comp>now() and  docsal.fec_comp>=now()+ interval '4 day'" : $dias);
if (!$tipo_reporte) $tipo_reporte=1; //el reporte por default es por los turnados a:
if ($anio_reporte=="" or !$anio_reporte) $anio_reporte="TODOS";
//echo $anio_reporte;
switch ($tipo_reporte) {
	case "1": //Por turnados a:
		$criterio="Turnos $texto_vencidos por �rea";
		$query="SELECT
		Dependencia.Nom_Depe,
		sum(Case When CVE_RESP='N' and $dias then 1 end) as vencidos,
		Docsal.Cve_Depe
		FROM DOCSAL Docsal Left Join Dependencia Dependencia On (Docsal.Cve_Depe=Dependencia.Cve_Depe)
		WHERE Docsal.Fol_Orig IS NOT NULL";
		if ($anio_reporte!="TODOS") $query.=" and Date_Part('year',Docsal.Fec_salid)=".($anio_reporte)."::float8";
		$query.=" GROUP BY Dependencia.Nom_Depe,Docsal.Cve_Depe,Dependencia.Siglas order by Dependencia.Nom_Depe";
	break;
	case "2": //Por fecha de compromiso
		$criterio="Turnos $texto_vencidos por fecha de compromiso ".$anio_reporte;
		$query="SELECT
		Date_Part('month',Docsal.Fec_Comp),
		sum(Case When CVE_RESP='N' and $dias then 1 end) as vencidos,
		Date_Part('month',Docsal.Fec_Comp)
		FROM DOCSAL Docsal";
		if ($anio_reporte!="TODOS") $query.=" WHERE Date_Part('year',Docsal.Fec_Comp)=".($anio_reporte)."::float8 ";
		$query.=" GROUP BY Date_Part('month',Docsal.Fec_Comp) order by Date_Part('month',Docsal.Fec_Comp)";
	break;
	case "3": //Por tipo de documento
		$criterio="Turnos $texto_vencidos por Tipo de documento ".$anio_reporte;
		$query="SELECT
		Instruccion.Instruccion,
		sum(Case When CVE_RESP='N' and $dias then 1 end) as vencidos,
		documento.Cve_Tipo
		FROM Docsal Docsal, Documento Documento Left Join Instruccion Instruccion On (Documento.Cve_Tipo=Instruccion.Cve_Ins)
		WHERE Docsal.Fol_Orig=Documento.Fol_orig";
		//ccedillo
		if ($anio_reporte!="TODOS") $query.=" and Date_Part('year',Docsal.Fec_salid)=".($anio_reporte)."::float8";
		$query.=" GROUP BY Instruccion.Instruccion,Documento.Cve_Tipo order by Instruccion.Instruccion";
	break;
	case "4": //Por a�o
		$criterio="Turnos $texto_vencidos por a�o";
		$query="SELECT
		Date_Part('year',Docsal.Fec_salid),
		sum(Case When CVE_RESP='N' and $dias then 1 end) as vencidos,
		Date_Part('year',Docsal.Fec_salid)
		FROM DOCSAL Docsal GROUP BY Date_Part('year',Docsal.Fec_salid) order by Date_Part('year',Docsal.Fec_salid)";
	break;
	case "5": //Por mes del a�o actual
		$criterio="Turnos $texto_vencidos del".$anio_reporte;
		$query="SELECT
		Date_Part('month',Docsal.Fec_salid),
		sum(Case When CVE_RESP='N' and $dias then 1 end) as vencidos,
		Date_Part('month',Docsal.Fec_salid)
		FROM DOCSAL Docsal ";
		if ($anio_reporte!="TODOS") $query.="WHERE Date_Part('year',Docsal.Fec_Salid)='$anio_reporte'::float8 ";
		$query.=" GROUP BY Date_Part('month',Docsal.Fec_salid) order by Date_Part('month',Docsal.Fec_salid)";
	break;
}
//echo $tipo_reporte."    ".$anio_reporte;

?>
<form name='estadisticas_turnos' action='principal.php?sess=$sess&control_botones_superior=11' method='post'>
 <select name='anio_reporte' onChange="gotoPage('principal.php?sess=<? echo $sess ?>&control_botones_superior=11&anio_reporte='+document.estadisticas_turnos.anio_reporte.options[document.estadisticas_turnos.anio_reporte.selectedIndex].value+'&pendientes=<? echo $pendientes ?>&tipo_reporte='+document.estadisticas_turnos.tipo_reporte.options[document.estadisticas_turnos.tipo_reporte.selectedIndex].value);">

<?
echo "<option value='TODOS'".($anio_reporte=="TODOS" ? "selected" : "").">TODOS</option>\n";
if (!$anio_reporte) $anio_reporte=date('Y');
$sql = new scg_DB;
$query2="SELECT distinct date_part('year',docsal.Fec_Comp) as anio from docsal where CVE_RESP='N' and fec_comp<=now()";
$sql->query($query2);
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$anio = ($sql->f("0"));
		/*
		if ($anio_reporte==$anio) {
			print("<option value=$anio selected>$anio</option>\n");
		} else {
			print("<option value=$anio>$anio</option>\n");
		}
		*/
		echo "<option value='$anio' ".($anio_reporte==$anio ? "selected" : "").">$anio</option>\n";
	}
}
print("</select>&nbsp;");
print("<select name='tipo_reporte' onChange=\"gotoPage('principal.php?sess=$sess&control_botones_superior=11&pendientes=$pendientes&tipo_reporte='+this.options[this.selectedIndex].value);\">\n");
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

print("</select>\n");
//print("<input type='submit' value=' Aceptar '>\n");
print("</form>\n");

$sql->query($query);
$numero_renglones = $sql->num_rows($sql);
if ($numero_renglones > 0) {
	//abre tabla
	?>
	<table width=70% border=0 cellspacing=2 cellpadding=2>
		<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
			<td align='center' class='chiquitoblanco'>
			 <font class='chiquitoblanco'><? echo $criterio ?></font>
			</td>
			<td align='center' class='chiquitoblanco'>
			 <font class='chiquitoblanco'>Turnos
			</td>
		</tr>
	<?
	$color_renglon=$color_1;
	$gran_total=0;
	while($sql->next_record()) {
		$tope=1; //uno menos, la ultima columna es el identificador del criterio
		$col[0] 			= $sql->f("0"); //Dependencia.Nom_Depe
		$col[1] 			= $sql->f("1"); // pendientes
		$col[2] 			= $sql->f("2"); // parametro
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
   	    if ($col[1]!=0) {?>
   	    <tr bgcolor='#<? echo $color_renglon ?>'>
         <td class='chiquito' align='left'><? echo $col[0] ?></td>
         <td class='chiquito' align='center'><a href='listados.php?sess=<? echo $sess ?>&pendientes=<? echo $pendientes ?>&control_botones_superior=<? echo $pendientes ?>&anio_reporte=<? echo $anio_reporte ?>&parametro=<? echo $col[2] ?>&parametro1=<? echo $col[0] ?>&tipo_reporte=<? echo $tipo_reporte ?>'>
          <? echo $col[1] ?>
         </td>
        </tr>
        <?
		if ($color_renglon==$color_1) {
  		   $color_renglon=$color_2;
		} else {
		   $color_renglon=$color_1;
		}
        }
        $gran_total+=$col[1];
		$i++;
	}
	//cierra tabla
	?>
		<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
			<td align='left' class='chiquitoblanco'>
				Total:
			</td>
			<?
			for ($i = 1; $i <= $tope; $i++) echo "<td class='chiquitoblanco' align='center'>$gran_total</td>\n";
			?>
		</tr>
	</table>
	<?
}
