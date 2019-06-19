<?php
require("./config/scg.php");
require("./includes/scg.lib.php");
$espaciado=1;
$alineacion_vertical="top";
?>
<html>
 <head>
  <script language="JavaScript">
 	function limpia_parametros(f) {
		window.opener.document.plantilla_documento.domicilio.value="";
		window.opener.document.plantilla_documento.colonia.value="";
		window.opener.document.plantilla_documento.codigo_post.value="";
		window.opener.document.plantilla_documento.telefono.value="";
		window.opener.document.plantilla_documento.entidad.value="";
		window.opener.document.plantilla_documento.control_entidad.value="";
		window.opener.document.plantilla_documento.valor_entidad.value="";
		window.opener.document.plantilla_documento.delegacion.value="";
		window.opener.document.plantilla_documento.control_delegacion.value="";
		window.opener.document.plantilla_documento.valor_delegacion.value="";
		window.opener.document.plantilla_documento.comentarios.value="";
	}
 	function regresa_parametros(f) {
		window.opener.document.plantilla_documento.domicilio.value=f.domicilio.value;
		window.opener.document.plantilla_documento.colonia.value=f.colonia.value;
		window.opener.document.plantilla_documento.codigo_post.value=f.codigo_post.value;
		window.opener.document.plantilla_documento.telefono.value=f.telefono.value;
		window.opener.document.plantilla_documento.entidad.value=f.entidad[f.entidad.selectedIndex].value;
		window.opener.document.plantilla_documento.control_entidad.value=f.entidad.selectedIndex;
		window.opener.document.plantilla_documento.valor_entidad.value=f.entidad[f.entidad.selectedIndex].text;
		window.opener.document.plantilla_documento.delegacion.value=f.delegacion[f.delegacion.selectedIndex].value;
		window.opener.document.plantilla_documento.control_delegacion.value=f.delegacion.selectedIndex;
		window.opener.document.plantilla_documento.valor_delegacion.value=f.delegacion[f.delegacion.selectedIndex].text;
		window.opener.document.plantilla_documento.comentarios.value=f.comentarios.value;
 		window.opener.document.plantilla_documento.captura=true;
		<?php
		if (substr($ok['ctrl_menu_sup'],1,1)=='1') {
			echo "window.opener.document.plantilla_documento.boton_domicilio.value='Editar Domicilio';";
		} else {
			echo "window.opener.document.plantilla_documento.boton_domicilio.value='Ver Domicilio';";
		}
		?>
 		self.close();
	}
 	function cancela_domicilio() {
		limpia_parametros(document.plantilla_domicilio);
 		window.opener.document.plantilla_documento.captura=false;
		<?php
		if (substr($ok['ctrl_menu_sup'],1,1)=='1') {
			echo "window.opener.document.plantilla_documento.boton_domicilio.value='Capturar Domicilio';";
		} else {
			echo "window.opener.document.plantilla_documento.boton_domicilio.value='Ver Domicilio';";
		}
		?>
 		self.close();
	}
	function regform_Validator(f) {
		return (true);
	}
	<?php
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
 	function jala_datos(f) {
		f.domicilio.value=window.opener.document.plantilla_documento.domicilio.value;
		f.colonia.value=window.opener.document.plantilla_documento.colonia.value;
		f.codigo_post.value=window.opener.document.plantilla_documento.codigo_post.value;
		f.telefono.value=window.opener.document.plantilla_documento.telefono.value;
		if (window.opener.document.plantilla_documento.control_entidad.value!='') {
			f.entidad.options[window.opener.document.plantilla_documento.control_entidad.value].value = window.opener.document.plantilla_documento.entidad.value;
			f.entidad.options[window.opener.document.plantilla_documento.control_entidad.value].text  = window.opener.document.plantilla_documento.valor_entidad.value;
			f.entidad.options[window.opener.document.plantilla_documento.control_entidad.value].selected = true;
			despliegaMunicipios(f,window.opener.document.plantilla_documento.entidad.value);
		}
		if (f.delegacion.options[1].text!="" && f.delegacion.options[2].text!="") {
			if (window.opener.document.plantilla_documento.valor_delegacion.value!="") {
				if (window.opener.document.plantilla_documento.control_delegacion.value<=f.delegacion.options.length) {
					f.delegacion.options[window.opener.document.plantilla_documento.control_delegacion.value].value = window.opener.document.plantilla_documento.delegacion.value;
					f.delegacion.options[window.opener.document.plantilla_documento.control_delegacion.value].text  = window.opener.document.plantilla_documento.valor_delegacion.value;
					f.delegacion.options[window.opener.document.plantilla_documento.control_delegacion.value].selected = true;
				} else {
					var option3 = new Option(window.opener.document.plantilla_documento.valor_delegacion.value,window.opener.document.plantilla_documento.delegacion.value);
					f.delegacion.options[0] = option3;
					f.delegacion.options[0].selected = true;
				}
			}
		}
		f.comentarios.value=window.opener.document.plantilla_documento.comentarios.value;
	}
  </script>
 </head>
 <body bgcolor='#CCCCCC' onLoad="javascript: window.opener.document.plantilla_documento.control_ventana.value=1; jala_datos(document.plantilla_domicilio);" onUnLoad="javascript: window.opener.document.plantilla_documento.control_ventana.value=0;">
  <?php
 	//INICIALIZACION DE VARIABLES
 	$alineacion_vertical="top";
  ?>
  <form name="plantilla_domicilio" method="post" action="documento.php" target="_self" onsubmit="return regform_Validator(this)">
  <table width="700" border="3" cellspacing="<? echo $espaciado; ?>" cellpadding="<? echo $espaciado; ?>">
    <tr>
      <td width="84" valign="<?php echo $alineacion_vertical; ?>">
       <font class="chiquito">Domicilio:</font>
      </td>
      <td colspan="3">
        <input type="text" name="domicilio" size=60 maxlength=60 onChange="this.value=this.value.toUpperCase();">
      </td>
    </tr>
    <tr>
      <td width="84" valign="<?php echo $alineacion_vertical; ?>">
       <font class="chiquito">Colonia:</font>
      </td>
      <td colspan="3">
        <input type="text" name="colonia" size=40 maxlength=40 onChange="this.value=this.value.toUpperCase();">
      </td>
    </tr>
    <tr>
      <td width="84" valign="<?php echo $alineacion_vertical; ?>">
       <font class="chiquito">Entidad:</font>
      </td>
      <td>
		<select name='entidad' onChange="despliegaMunicipios(document.plantilla_domicilio,document.plantilla_domicilio.entidad.options[document.plantilla_domicilio.entidad.selectedIndex].value)">
		<option value=0 selected> Seleccione el estado</option>
		<?php
			for($x = 1;$x < 33;$x++) {
				echo "<option value='$entidad_array1[$x]'>$entidad_array2[$x]</option>\n";
			}

	  	?>
		</select>
      </td>
      <td width="84" valign="<?php echo $alineacion_vertical; ?>" align="right">
       <font class="chiquito">Delegaci&oacute;n / Municipio:</font>
      </td>
      <td width="113">
		<select name="delegacion">
	    <option value=0>Seleccione el municipio</option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		<option value=0> </option>
		</select>
      </td>
    </tr>
    <tr>
      <td width="84" valign="<?php echo $alineacion_vertical; ?>">
       <font class="chiquito">Cod. postal:</font>
      </td>
      <td>
        <input type="text" name="codigo_post" size=6 maxlength=6 onChange="this.value=this.value.toUpperCase();">
      </td>
      <td width="113" valign="<?php echo $alineacion_vertical; ?>" align="right">
       <font class="chiquito">Tel&eacute;fono:</font>
      </td>
      <td>
        <input type="text" name="telefono" size=40 maxlength=50 onChange="this.value=this.value.toUpperCase();">
      </td>
    </tr>
    <tr>
      <td width="84" valign="<?php echo $alineacion_vertical; ?>">
       <font class="chiquito">Comentarios:</font>
      </td>
      <td colspan="3">
        <textarea name="comentarios" wrap cols=70 rows=3 onChange="this.value=this.value.toUpperCase();"></textarea>
      </td>
    </tr>
    <tr>
     <td colspan="5" align="center">
      <?php
		if ($origen=='capturar') {
			print("<input type='button' name='cancelar' value='Cancelar' onClick=\"javascript: cancela_domicilio();\">");
			print("<input type='reset' name='limpiar' value='Limpiar Forma' onClick=\"javascript: limpia_parametros(document.plantilla_domicilio);\">");
			print("<input type='submit' name='guardar' value='Aceptar' onClick=\"javascript: regresa_parametros(document.plantilla_domicilio);\">");
		} else {
			if (substr($ok['ctrl_menu_sup'],1,1)=='1') {
				print("<input type='submit' name='guardar' value='Aceptar cambios' onClick=\"javascript: regresa_parametros(document.plantilla_domicilio);\">");
			} else {
				print("<input type='submit' name='guardar' value='Cerrar ventana' onClick=\"javascript: regresa_parametros(document.plantilla_domicilio);\">");
			}
		}
      ?>
     </td>
    </tr>
  </table>
  </form>
 </body>
</html>