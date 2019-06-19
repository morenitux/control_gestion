<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	header.inc
|	Autor:		Sa�l E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Noviembre 2002
|
|	Gobierno del Distrito Federal
|	Oficial�a Mayor
|	Coordinaci�n Ejecutiva de Desarrollo Inform�tico
|	Direcci�n de Nuevas Tecnolog�as
|
|	�ltima actualizaci�n:	04/11/2002
|
--------------------------------------------------------------------------------------*/
?>
<html>
	<head>

	<?php
	header('Content-Type: text/html; charset=UTF-8');
	print("<script language='JavaScript'>self.name='$windowname'</script>\n");
	print("<title>$default->scg_title_in_header</title>\n");
	if ($control_catalogos!="" && $control_catalogos!="0") {
		print("<script language='JavaScript' src='includes/newWindow.js'></script>\n");
	}
	?>
	<link rel="stylesheet" type="text/css" title="style1" href="<?php echo($default->styles)?>">
</head>

<body bgcolor="<?php echo($default->body_bgcolor) ?>"
  text="<?php echo($default->body_textcolor) ?>"
  link="<?php echo($default->body_link) ?>"
  vlink="<?php echo($default->body_vlink) ?>"
  <?php
	if ($control_catalogos!="" && $control_catalogos!="0") {
		include "$default->scg_fs_root/includes/onLoad.php"; //utilizar esta l�nea si no jala directo el include
		//include "onLoad.php"; //utilizar esta l�nea si el include jala sin la ruta
	}
	if ($control_botones_superior=="1" && $folio_capturado!="") {
		echo " onLoad='alert(\"El documento $folio_capturado ha sido registrado\")'";
	}
	if ($control_botones_superior=="1" && $folio_actualizado!="") {
		echo " onLoad='alert(\"El documento $folio_actualizado ha sido actualizado\")'";
	}
	if ($control_botones_superior=="1" && $not_found!="") {
		if ($not_found!="complex") {
			if ($not_found!="AUTOMATICO") {
				echo " onLoad='alert(\"El folio $not_found no fue encontrado\")'";
			} else {
				echo " onLoad='alert(\"Capture el folio del documento que desea buscar\")'";
			}
		} else {
			$not_found=="";
			echo " onLoad='alert(\"No se encontró ningún documento que cumpla con estas condiciones\")'";
		}
	}
	if ($control_botones_superior=="1" && $imprimevolante!="") {
		echo " onLoad='newWindow(\"imprime_volante.php?sess=$sess&imprimevolante=$imprimevolante\",800,600,\"Volante\")'";
	}
	if ($control_botones_superior=="7" && $folio_capturado!="") {
		echo " onLoad='alert(\"El documento $folio_capturado ha sido registrado\")'";
	}
  ?>
  >
	<center>
	<table border=1 width=800 cellspacing=0 cellpading=0>
	 <tr>
		<td width=100% height=10 valign=top align=center>
		 <?php
		 include "includes/menu_superior.php";
		 ?>
		</td>
	 </tr>
	 <tr>
		<td width=100% valign=top align=center>
		 <table width=100% border=1 cellspacing=0 cellpading=0>
			<tr>
