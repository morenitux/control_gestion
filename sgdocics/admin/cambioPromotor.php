<?php
print ("<script language='JavaScript' src='../includes/isValidDate.js'></script>");
print("<br>\n<center><font class='bigsubtitle'>$variable $lang_siglas</font></center>\n<br>\n");
$id=str_replace("~"," ",$id);
if ($accion!="insert") {
	$sql = new scg_DB;
	$sql->query("SELECT cve_prom,nom_prom,siglas,tit_prom,tipo,domicilio,colonia,delegacion,codigo_post,entidad,telefono,car_titu from promotor where cve_prom='$id'");
	$num = $sql->num_rows($sql);
	if ($num == 1) {
		while($sql->next_record()) {
			$cve_prom 	= $sql->f("cve_prom");
			$nom_prom 	= $sql->f("nom_prom");
			$siglas 		= $sql->f("siglas");
			$tit_prom 	= $sql->f("tit_prom");
			$car_titu 	= $sql->f("car_titu");
			$tipo 			= $sql->f("tipo");
			$domicilio 	= $sql->f("domicilio");
			$colonia 		= $sql->f("colonia");
			$delegacion = $sql->f("delegacion");
			$codigo_post= $sql->f("codigo_post");
			$entidad 		= $sql->f("entidad");
			$telefono 	= $sql->f("telefono");
		}
	} else {
		if ($num > 1) {
			print("Error\n");
			exit;
		} else {
			$cve_prom 	= "";
			$nom_prom 	= "";
			$siglas 		= "";
			$tit_prom 	= "";
			$car_titu 	= "";
			$tipo 			= "";
			$domicilio 	= "";
			$colonia 		= "";
			$delegacion = "";
			$codigo_post= "";
			$entidad 		= "";
			$telefono 	= "";
		}
	}
}
print("<script language='JavaScript'>\n");
$sql = new scg_DB;
$sql->query("select id_entidad_federativa,entidad_federativa from cat_entidad_federativa order by entidad_federativa");
$num_entidades = $sql->num_rows($sql);
if ($num_entidades > 0) {
	while($sql->next_record()) {
		$id_entidad_federativa= $sql->f("id_entidad_federativa");
		$entidad_federativa		= $sql->f("entidad_federativa");
		$i=($id_entidad_federativa)*1;
		$entidad_array1[$i]="$id_entidad_federativa";
		$entidad_array2[$i]="$entidad_federativa";
		print("var e".$id_entidad_federativa."Array =  new Array(\"('Seleccione el municipio','',true,true)\",\n");
		$sql2 = new scg_DB;
		$sql2->query("select id_delegacion_municipio,delegacion_municipio from cat_delegacion_municipio where id_entidad_federativa='$id_entidad_federativa' order by delegacion_municipio");
		$num_delegaciones = $sql2->num_rows($sql2);
		if ($num_delegaciones > 0) {
			$j=0;
			while($sql2->next_record()) {
				$id_delegacion_municipio 	= $sql2->f("id_delegacion_municipio");
				$delegacion_municipio			= $sql2->f("delegacion_municipio");
				print("\"('$delegacion_municipio', '$id_delegacion_municipio')\"");
				$j++;
				if ($j==$num_delegaciones) {
					print(");\n");
				} else {
					print(",\n");
				}
			}
		}
	}
}
?>
function despliegaMunicipios(inForm,selected) {
	var selectedArray = eval("e" + selected + "Array");
	while (selectedArray.length < inForm.delegacion.options.length) {
		inForm.delegacion.options[(inForm.delegacion.options.length - 1)] = null;
	}
	for (var i=0; i < selectedArray.length; i++) {
		eval("inForm.delegacion.options[i]=" + "new Option" + selectedArray[i]);
	}
	if (inForm.entidad.options[0].value == '') {
		inForm.entidad.options[0]= null;
			if ( navigator.appName == 'Netscape') {
				if (parseInt(navigator.appVersion) < 4) {
					window.history.go(0);
				} else {
					if (navigator.platform == 'Win32' || navigator.platform == 'Win16') {
						window.history.go(0);
					}
				}
		}
	}
}
//  End -->
</script>
<?
print("<form name='captura_promotor' action='$accion"."Promotor.php?sess=$sess&origen=$origen' method='post' target='_self' onsubmit='return regform_Validator(this)'>\n");
print("<center>\n");
if ($accion=="delete") print("<font class='alerta'>$lang_catdelete_warn</font>\n");
?>
<table border=0  width="700">
	<tr>
		<td align="right" width="25%">
			Nombre del Remitente:
		</td>
		<td>
			<input type="text" name="nom_prom" value="<? echo $nom_prom ?>"size=50 maxlength=100 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Siglas
		</td>
		<td>
			<input type="text" name="siglas" value="<? echo $siglas ?>" size=8 maxlength=8 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
</table>
<br>
<table border=0  width="700">
	<tr>
		<td align="right" width="25%">
			Nombre del Titular:
		</td>
		<td>
			<input type="text" name="tit_prom"  value="<? echo $tit_prom ?>"size=50 maxlength=50 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Cargo del Titular
		</td>
		<td>
			<input type="text" name="car_titu" value="<? echo $car_titu ?>"size=50 maxlength=100 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Tipo:
		</td>
		<td>
			Promotor<input type="radio" name="tipo"  value="P" <? if ($tipo=="P") { echo "checked"; } ?>>
			Remitente<input type="radio" name="tipo"  value="R" <? if ($tipo=="R") { echo "checked"; } ?>>
			Ambos<input type="radio" name="tipo" value="Q" <? if ($tipo=="Q" || $tipo=="") { echo "checked"; } ?>>
		</td>
	</tr>
</table>
<br>
<table border=0 width="700">
	<tr>
		<td align="right" width="25%">
			Domicilio
		</td>
		<td>
			<input type="text" name="domicilio" value="<? echo $domicilio ?>"size=40 maxlength=60 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Colonia
		</td>
		<td>
			<input type="text" name="colonia" value="<? echo $colonia ?>"size=40 maxlength=40 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Codigo Postal:
		</td>
		<td>
			<input type="text" name="codigo_post" value="<? echo $codigo_post ?>"size=6 maxlength=6 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Entidad/Estado:
		</td>
		<td>
			<select name='entidad' onChange="despliegaMunicipios(document.captura_promotor,document.captura_promotor.entidad.options[document.captura_promotor.entidad.selectedIndex].value)" <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
				<option value=0> Seleccione el estado</option>
				<?php
				$i=1;
				while ($i<=$num_entidades) {
					print("\t\t\t\t<option value='$entidad_array1[$i]'");
					if ($entidad==$entidad_array1[$i]) print(" selected");
					print(">$entidad_array2[$i]</option>\n");
					$i++;
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Delegacion/Municipio
		</td>
		<td>
			<select name="delegacion" <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
			<?php
			if ($entidad=="" || ($entidad=="" && $delegacion=="")) {
				print("<option value=0>Seleccione el municipio</option>\n");
				for ($x = 1; $x <= 6; $x++) print("<option value=0> </option>\n");
			} else {
				echo "<option value=0>Seleccione el municipio</option>\n";
				$sql2 = new scg_DB;
				$sql2->query("select id_delegacion_municipio,delegacion_municipio from cat_delegacion_municipio where id_entidad_federativa='$entidad' order by id_delegacion_municipio");
				$num_delegaciones = $sql2->num_rows($sql2);
				if ($num_delegaciones > 0) {
					$j=0;
					while($sql2->next_record()) {
						$id_delegacion_municipio 	= $sql2->f("id_delegacion_municipio");
						$delegacion_municipio			= $sql2->f("delegacion_municipio");
						echo "<option value=$id_delegacion_municipio";
						if ($delegacion==$id_delegacion_municipio) echo " selected";
						echo ">$delegacion_municipio </option>\n";
						$j++;
					}
				}
				for ($x = 1; $x <= 6; $x++) print("<option value=0> </option>\n");
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="25%">
			Teléfono
		</td>
		<td>
			<input type="text" name="telefono" value="<? echo $telefono?>" size=20 maxlength=20 <? if ($accion=="delete") { echo "onFocus='this.blur();'"; }?>>
		</td>
	</tr>
  <tr>
	  <td colspan=2>
	  </td>
	 </tr>
	 <tr>
	  <td>
		  <br>
	  </td>
	 </tr>
</table>
<?
print("<input type='button' value='$lang_basicbutton_x' onClick='location=\"admonCatalogo.php?sess=$sess&control_catalogos=$control_catalogos&origen=$origen\"'>");
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
print("<input type='hidden' name='origen' value='$origen'>\n");
print("</form>\n");
?>
<script language='JavaScript'>
function regform_Validator(f) {
	if (f.nom_prom.value.length < 1) {
		  alert("Por favor introduzca o verifique el nombre del remitente.");
		  f.nom_prom.focus();
		  return(false);
	}
	if (f.siglas.value.length < 1) {
		  alert("Por favor introduzca o verifique las siglas.");
		  f.siglas.focus();
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