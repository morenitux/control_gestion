<?
//INICIALIZACION DE VARIABLES
$fecha_now =date("d/m/Y");
$hora_now  =date("H:i");
$anio_now  =date("Y");
$bgcolor_titulos="#003399";
$color_1="EAEAEA";
$color_2="C6FFFF";

$sql = new scg_DB;
$query = "SELECT upper(tableowner) from pg_tables where upper(tableName)='DOCUMENTO'";
$sql->query($query);
if ($sql->num_rows($sql) > 0) {
	while($sql->next_record()) {
		$propietario = $sql->f("0");
	}
}

$sql->query("select count(*) as cuantos from usuarios where usuario is not null and usuario!='$propietario'");
while($sql->next_record()) {
	$cuantos = $sql->f("0");
}
if ($cuantos>0) {
	$query="SELECT distinct usuario from usuarios where usuario is not null and usuario not in ('SYSSCG','SYSSQLBZ','$propietario') order by usuario";
	$sql->query($query);
	$numero_renglones = $sql->num_rows($sql);
	if ($numero_renglones > 0) {
		//abre tabla
		?>
		<table width=100% border=0 cellspacing=2 cellpadding=2>
		 <tr>
		  <td width=100% align=center>
				<font class='bigsubtitle'>Administración de Usuarios</font>
		  </td>
		 </tr>
		</table>
		<br>
		<?php print ("<center><a href='principal.php?sess=$sess&control_botones_superior=10&variable=cambiaUsuario&accion=insert'><img src='$default->scg_graphics_url/alta.gif' border='0' alt='$lang_new'></a><font class='chiquito'>$lang_new</font>\n"); ?>
		<br>
		<table width=200 border=0 cellspacing=2 cellpadding=2>
			<tr bgcolor='#<? echo $bgcolor_titulos; ?>'>
				<td align='center' class='chiquitoblanco'>
					No.
				</td>
				<td colspan='2' align='center' class='chiquitoblanco'>
					<? echo "Usuario"; ?>
				</td>
			</tr>
		<?
		$x=0;
		$color_renglon=$color_1;
		while($sql->next_record()) {
			$usuario = "";
			$usuario = $sql->f("usuario");
			$x++;

			echo "<tr bgcolor='#$color_renglon' valign=top>\n<td class='chiquito' align='left'>$x.-";
			echo "</td>";
			echo "\t<td class='chiquito' align='left'>\n";
			echo "\t\t";
			if (true) {
				echo "&nbsp;<a href='principal.php?sess=$sess&control_botones_superior=10&variable=cambiaUsuario&accion=update&parametro=$usuario'><img src='$default->scg_graphics_url/cambio.gif' border='0' title='Cambiar Contraseña y Descrìpción' alt='Cambiar Contraseña y Descrìpción'></a>&nbsp;";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=10&variable=cambiaUsuario&accion=delete&parametro=$usuario'><img src='$default->scg_graphics_url/baja.gif' border='0' title='Eliminar Usuario' alt='Eliminar Usuario'></a>&nbsp;";
				echo "<a href='principal.php?sess=$sess&control_botones_superior=10&variable=cambiaPrivilegios&parametro=$usuario'><img src='$default->scg_graphics_url/llave.gif' border='0' title='Modificar Privilegios' alt='Modificar Privilegios'></a>";
			}
			echo "\t</td><td align='center'>$usuario</td>\n";
			echo "</tr>\n";
			if ($color_renglon==$color_1) {
				$color_renglon=$color_2;
			} else {
				$color_renglon=$color_1;
			}
		}
		//cierra tabla
		?>
		</table>
		<?
	}
} else {
	?>
	<br>
	<table width=100% border=0 cellspacing=2 cellpadding=2>
	 <tr>
	  <td width=100% align=center>
			<font class='bigsubtitle'>No hay usuarios registrados</font>
	  </td>
	 </tr>
	</table>
	<?
}
?>