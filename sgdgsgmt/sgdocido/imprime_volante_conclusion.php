<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	imprime_volante_conclusion.php
|	Autor:		Saúl E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Diciembre 2003
|
|	Gobierno del Distrito Federal
|	Oficialía Mayor
|	Coordinación Ejecutiva de Desarrollo Informático
|	Dirección de Nuevas Tecnologías
|
|	Última actualización:	30/12/2003
|
--------------------------------------------------------------------------------------*/
require("./config/scg.php");
require("./config/html.php");
require("./includes/scg.lib.php");
$sql = new scg_DB;
$sql->query("select usuarios.usuario from usuarios,sesion_activa where usuarios.usuario=sesion_activa.usuario and sess_id='$sess'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$id_usuario = $sql->f("usuario");
	}
}

$arreglo			= explode("-",$imprimevolante);
$num_cachos			= count($arreglo);
if ($num_cachos>2) {
	$parametro			= $arreglo[0]."-".$arreglo[1];
	$conse_parametro	= $arreglo[2];
} else {
	$parametro			= $arreglo[0];
	$conse_parametro	= $arreglo[1];
}


$fec_conclu	= "";
$cve_resp	= "";
$califresp	= "";
$modi_sal	= "";
$modi_resp	= "";
$txt_resp	= "";
$cve_docto	= "";

$sql = new scg_DB;
$sql->query("select to_char(fec_conclu,'dd/mm/yyyy') as fec_conclu, cve_resp, califresp, modi_sal, modi_resp, txt_resp, cve_docto from docsal where fol_orig='$parametro' and conse='$conse_parametro'");
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$fec_conclu	 = $sql->f("fec_conclu");
		$cve_resp	 = $sql->f("cve_resp");
		$califresp	 = $sql->f("califresp");
		$modi_sal	 = $sql->f("modi_sal");
		$modi_resp	 = $sql->f("modi_resp");
		$txt_resp	 = $sql->f("txt_resp");
		$cve_docto	 = $sql->f("cve_docto");
	}
}

$bgcolor_titulos="#FFFFFF";
$color_1="FFFFFF";
$color_2="FFFFFF";

?>
<html>
<head>
	<script language="JavaScript1.2">
	var agt=navigator.userAgent.toLowerCase();
	function displayBio(obj) {
		var docURL = location.href;
		if (obj.checked) {
			if (docURL.indexOf('showBibliography') == -1) {
				location.href = docURL+"&showBibliography=Y";
			} else {
				location.href = docURL.replace( /showBibliography=N/, "showBibliography=Y" );
			}
		}	else {
			if (docURL.indexOf('showBibliography') == -1) {
				location.href = docURL+"&showBibliography=N";
			}else {
				location.href = docURL.replace( /showBibliography=Y/, "showBibliography=N" );
			}
		}
	}
	function imprimeVolante() {
		var prn = new Image();
		prn.src="<? echo 'impresion.php?sess=$sess&anio_parametro=$anio_parametro&userid=$userid'; ?>";
		if (window.print) {
			setTimeout('window.print();',200);
		} else if (agt.indexOf("mac") != -1) {
			alert("Oprima 'Cmd+p' para imprimir.");
		}	else {
			alert("Oprim 'Ctrl+p' para imprimir.")
		}
	}
	</script>
	<?php
	if ($accion=="para_entrega" || $accion=="transmitida") {
		print("<title>PARA ENTREGA</title>\n");
	} else {
		if ($accion=="preliminar") {
			print("<title>VERSIÓN PRELIMINAR</title>\n");
		} else {
			print("<title>$default->ssp_title_in_header</title>\n");
		}
	}
	?>

<link rel="stylesheet" type="text/css" title="style1" href="<?php echo($default->styles)?>">
</head>
<body bgColor="#FFFFFF" onload="imprimeVolante();">
<center>
<?php


/* MODIFICAR LA SIGUIENTE VARIABLE PARA REALIZAR UN AJUSTE VERTICAL A LA IMPRESION */
$ajuste_vertical = 44;
/* ------------------------------------------------------------------------------- */



for ($x=1; $x<=$ajuste_vertical; $x++) {
	echo "<br>";
}


/* EN LA SIGUIENTE TABLA LOS BORDES SON VISIBLES
PERO PUEDEN OCULTARSE PONIENDO EL PARAMETRO border="0";
SE SUGIERE DESAPARECER LOS BORDES HASTA QUE SE HAYA
HECHO EL AJUSTE VERTICAL DE LA IMPRESION */
?>
<table width="700" border="0" bordercolor="#EEEEEE" cellspacing="1" cellpadding="1">
<tr>
 <td valign="top" height="100">
 	 <font class="chiquito"><b>
<?php
if ($txt_resp) {
	echo "$txt_resp<br>";
	if ($fec_conclu!="") {
		echo "<font class='chiquitoazul'><b>$fec_conclu &nbsp;</b></font>";
		echo "&nbsp;&nbsp;";
		if ($califresp=="0") echo "<font class='chiquitoazul'><b>NEGATIVA</b></font>";
		if ($califresp=="1") echo "<font class='chiquitoazul'><b>POSITIVA</b></font>";
		echo "&nbsp;&nbsp;";
	}
	if ($modi_sal=="" && $modi_resp=="") {
		echo "&nbsp;";
	}	else {
		switch ($cve_resp) {
			case "N":
				if ($modi_sal=="") {
					echo "&nbsp;";
				} else {
					echo "$modi_sal &nbsp;";
				}
			break;
			case "S":
				if ($modi_resp=="") {
					echo "$id_usuario &nbsp;";
				} else {
					echo "$modi_resp &nbsp;";
				}
			break;
			case "":
				if ($modi_sal=="") {
					echo "&nbsp;";
				} else {
					echo "$modi_sal &nbsp;";
				}
			break;
		}
	}
}
?>
	 </b></font>
 </td>
</tr>
</table>
</center>
</body>