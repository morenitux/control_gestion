<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	header.inc
|	Autor:		Saúl E Morales Cedillo (ccedillo@df.gob.mx)
|	Fecha:		Noviembre 2002
|
|	Gobierno del Distrito Federal
|	Oficialía Mayor
|	Coordinación Ejecutiva de Desarrollo Informático
|	Dirección de Nuevas Tecnologías
|
|	Última actualización:	04/11/2002
|
--------------------------------------------------------------------------------------*/
?>
<html>
	<head>
	<?php
	print("<title>$default->scg_title_in_header</title>");
	?>
	<link rel="stylesheet" type="text/css" title="style1" href="<?php echo($default->styles)?>">
</head>

<body bgcolor="<?php echo($default->body_bgcolor) ?>"
  text="<?php echo($default->body_textcolor) ?>"
  link="<?php echo($default->body_link) ?>"
  vlink="<?php echo($default->body_vlink) ?>" onLoad="">
	<center>
	<table width=100% border=5>
	 <tr>
	  <td colspan=2>
	   <table border=0 width=100% cellpadding=5 cellspacing=5>
	    <tr>
	     <td width=50% align=left>
	      <?php print("<img src='$default->scg_graphics_url/$default->logo' border=0>\n"); ?>
	     </td>
	     <td width=50% align=right>
	      <br>
	      <?php print("<font class=bigtitle>$lang_owner_name</font>"); ?>
	      <br>
	      <?php print("<font class=bigtitle>$lang_app_name</font>"); ?>
	     </td>
	    </tr>
	   </table>
	  </td>
	 </tr>
	 <tr>
	  <td width=50%  height=400><br></td>
	  <td width=50%>