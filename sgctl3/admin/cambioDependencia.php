<?php
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$id=str_replace("~"," ",$id);
if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT cve_depe,siglas,nom_depe,tel_depe,dir_depe,nom_titu,car_titu,titulo_titu,orden from dependencia where cve_depe='$id'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$cve_prom 	= $sql->f("cve_prom");
			$nom_prom 	= $sql->f("nom_prom");
			$siglas 	= $sql->f("siglas");
			$tit_prom 	= $sql->f("tit_prom");
			$car_titu 	= $sql->f("car_titu");
			$tipo 		= $sql->f("tipo");
			$domicilio 	= $sql->f("domicilio");
			$colonia 	= $sql->f("colonia");
			$delegacion = $sql->f("delegacion");
			$codigo_post= $sql->f("codigo_post");
			$entidad 	= $sql->f("entidad");
			$telefono 	= $sql->f("telefono");

			$siglas 	= $sql->f("siglas");
			$nom_depe	= $sql->f("nom_depe");
			$tel_depe	= $sql->f("tel_depe");
			$dir_depe	= $sql->f("dir_depe");
			$nom_titu	= $sql->f("nom_titu");
			$car_titu	= $sql->f("car_titu");
			$titulo_titu= $sql->f("titulo_titu");
			$orden		= $sql->f("orden");

		}
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$siglas 		= "";
			$nom_depe		= "";
			$tel_depe		= "";
			$dir_depe		= "";
			$nom_titu		= "";
			$car_titu		= "";
			$titulo_titu	= "";
			$orden			= "";
		}
	}
}

print("<form name='captura_dependencia' action='$accion"."Dependencia.php?sess=$sess&origen=$origen' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");
?>
<table border=0 width="">
	<tr>
		<td align="right" width="25%">
			Siglas:
		</td>
		<td>
			<input type="text" name="siglas" value="<? echo $siglas ?>" size=8 maxlength=8 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Nombre Dependencia:
		</td>
		<td>
			<input type="text" name="nom_depe" value="<? echo $nom_depe ?>" size=50 maxlength=100 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Telefono:
		</td>
		<td>
			<input type="text" name="tel_depe" value="<? echo $tel_depe ?>" size=20 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Dirección:
		</td>
		<td>
			<input type="text" name="dir_depe" value="<? echo $dir_depe ?>" size=50 maxlength=70 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Nombre Titular:
		</td>
		<td>
			<input type="text" name="nom_titu" value="<? echo $nom_titu ?>" size=40 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Cargo Titular:
		</td>
		<td>
			<input type="text" name="car_titu" value="<? echo $car_titu ?>" size=50 maxlength=100 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Título Titular:
		</td>
		<td>
			<input type="text" name="titulo_titu" value="<? echo $titulo_titu ?>" size=20 maxlength=20 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Orden:
		</td>
		<td>
			<input type="text" name="orden" value="<? echo $orden ?>" size=3 maxlength=3 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
</table>
<?
print("<input type='button' value='$lang_basicbutton_x' onClick='location=\"admonCatalogo.php?sess=$sess&control_catalogos=$control_catalogos\"'>");
switch ($accion) {
 case "insert":
	echo "<input type='submit' value='$lang_basicbutton_a'>";
 break;
 case "update":
	echo "<input type='submit' value='$lang_basicbutton_c'>";
 break;
 case "delete":
	echo "<input type='submit' value='$lang_basicbutton_b'>";
 break;
}
print("</center>\n");
print("<input type='hidden' name='id' value='$id'>\n");
print("</form>\n");
?>
<script language='JavaScript'>
function regform_Validator(f) {
	if (f.siglas.value.length < 1) {
		  alert("Por favor introduzca o verifique las siglas.");
		  f.siglas.focus();
		  return(false);
	}
	if (f.nom_depe.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre de la dependencia.");
		  f.nom_depe.focus();
		  return(false);
	}
	if (f.nom_titu.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre del titular.");
		  f.nom_titu.focus();
		  return(false);
	}
	if (f.car_titu.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre del titular.");
		  f.car_titu.focus();
		  return(false);
	}
	if (window.RegExp) {
		var reg = new RegExp("[0-9-]*$","g");
		if (!reg.test(f.telefono.value)) {
			alert("El teléfono sólo puede contener números y guiones.");
			f.telefono.focus();
			return(false);
		}
	}
}
</script>