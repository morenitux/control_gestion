<?php
/*--------------------------------------------------------------------------------------
|
|	Archivo:	scg.lib.php
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
$language = "Spanish";
require("$default->scg_fs_root/language/$language/language.inc");

class scg_DB extends DB_Sql {
	var $classname = "scg_DB";

	// Servidor donde reside la base de datos
	var $Host = "localhost";

	// Nombre de la base de datos
	var $Database = "SCG12";

	// Usuario para accesar a la base de datos
	var $User = "SCG12";

	// Password para accesar a la base de datos
	var $Password = "SCG12";


	function haltmsg($msg) {
		printf("</td></table><b>Database error:</b> %s<br>\n", $msg);
		printf("<b>SQL Error</b>: %s (%s)<br>\n",
		$this->Errno, $this->Error);
	}
}

/*--------------------------------------------------------------------------------------*/

class Scg_Session {
	var $sessid;
	var $sessuserid;
	var $sessdata;

	function Open_Session($sessid, $sessuserid) {
		$this->sessid = $sessid;
		$this->sessuserid = $sessuserid;
		if ($sessid == "0") {
			$current = time();
			$random = $this->sessuserid . $current;
			$this->sessid = md5($random);
			$sql = new scg_DB;
			if (getenv(HTTP_X_FORWARDED_FOR)){
				$ip=getenv(HTTP_X_FORWARDED_FOR);
			} else {
				$ip=getenv(REMOTE_ADDR);
			}

			//verifica si al usuario le corresponde una vista por ser usuario interno
			$string_de_vista="";
			$query = "select upper(objeto) from privi_opcion where usuario='$this->sessuserid' and upper(objeto) like '%VISTA'";
			$sql->query($query);
			$control_menu_catalogos="0000000000";
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$string_de_vista = $sql->f("0");
				}
			}
			if (strlen($string_de_vista)>5) {
				$puro_id_vista=substr($string_de_vista,0,(strlen($string_de_vista)-5));
				$query = "select * from dependencia where cve_depe='$puro_id_vista'";
				$sql->query($query);
				if ($sql->num_rows($sql) > 0) {
					while($sql->next_record()) {
						$cve_depe = $sql->f("0");
					}
				}
				if ($cve_depe==$puro_id_vista) {
					$string_de_vista=$puro_id_vista;
				} else {
					$string_de_vista="";
				}
			}

			//verifica privilegios de acceso a modificación de catálogos y arma cadena
			$query = "select upper(objeto) from privi_opcion where usuario='$this->sessuserid'";
			$sql->query($query);
			$control_menu_catalogos="0000000000";
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$objeto = $sql->f("0");
					switch ($objeto) {
						case "PBPROMO": //Promotores / remitentes
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",0,1);
						break;
						case "PBEXPE": //Expedientes
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",1,1);
						break;
						case "PBTEMA": //Temas
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",2,1);
						break;
						case "PBEVENTO": //Eventos
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",3,1);
						break;
						case "PBDEPE": //Dependencias
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",4,1);
						break;
						case "PBTURNA": //Turnadores
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",5,1);
						break;
						case "PBINSTRU": //Instrucciones
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",6,1);
						break;
						case "PBTIPODOC": //Tipos de Documentos
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",7,1);
						break;
						case "PBDIRIGE": //Destinatarios
							$control_menu_catalogos=substr_replace ($control_menu_catalogos,"1",8,1);
						break;
					}
				}
			}

			//verifica privilegios de acceso para el menú superior y arma cadena
			$query = "select upper(objeto) from privi_opcion where usuario='$this->sessuserid'";
			$sql->query($query);
			if ($control_menu_catalogos=="0000000000") {
				$control_menu_superior="00000000010";
			} else {
				$control_menu_superior="10000000010";
			}
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$objeto = $sql->f("0");
					switch ($objeto) {
						case "PBSOLVOL":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",1,1);
						break;
						case "PBCONSUDOC":
							$control_menu_superior=substr_replace ($control_menu_superior,"2",1,1);
						break;
						case "PBRESP":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",2,1);
						break;
						case "PBESTDOC":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",3,1);
						break;
						case "PBSEGEJEC":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",5,1);
						break;
						case "PBCONDOC":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",4,1);
						break;
						case "PBSEGUIMIENTO":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",6,1);
						break;
						case "PBBUZONV":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",7,1);
						break;
						case "PBBUZONRESP":
							$control_menu_superior=substr_replace ($control_menu_superior,"1",8,1);
						break;
					}
				}
			}

			$query = "SELECT upper(tableowner) from pg_tables where upper(tableName)='DOCUMENTO'";
			$sql->query($query);
			if ($sql->num_rows($sql) > 0) {
				while($sql->next_record()) {
					$propietario = $sql->f("0");
				}
			}
			if ($propietario==$this->sessuserid) {
				$control_menu_superior=substr_replace ($control_menu_superior,"1111111",0,7);
				$control_menu_superior=substr_replace ($control_menu_superior,"11",9,2);
				$control_menu_catalogos="1111111111";

				//CCEDILLO: INICIO AGREGADO PARA BUZONES
				$sql->query("SELECT tableName from pg_tables where upper(tableName)='SOLI_BUZON'");
				if ($sql->num_rows($sql) > 0) {
					$control_menu_superior=substr_replace ($control_menu_superior,"1",7,1);
				}

				$sql->query("SELECT tableName from pg_tables where upper(tableName)='RESP_BUZON'");
				if ($sql->num_rows($sql) > 0) {
					$control_menu_superior=substr_replace ($control_menu_superior,"1",8,1);
				}
				//CCEDILLO: FIN AGREGADO PARA BUZONES
			}
			$result = $sql->query("insert into sesion_activa values ('$this->sessid', '$this->sessuserid', '$current', '$ip','$control_menu_superior','$control_menu_catalogos','$string_de_vista')");
			if (!result) die("$lang_err_sess_write");
		}
		$sql = new scg_DB;
		$sql->query("select * from sesion_activa where sess_id = '$this->sessid'");
		$numrows = $sql->num_rows($sql);
		if(!$numrows) die("$lang_err_sess_notvalid");
		while($sql->next_record()) {
			$this->sessdata["sessid"] = $sql->f("sess_id");
			$this->sessdata["ctrl_menu_sup"] = $sql->f("ctrl_menu_sup");
			$this->sessdata["ctrl_menu_cat"] = $sql->f("ctrl_menu_cat");
			$this->sessdata["vista"] = $sql->f("vista");
		}
		$sql->disconnect($sql->Link_ID);
		return $this;
	}
}

/*--------------------------------------------------------------------------------------*/

function notify_users($groupid, $flag, $parent, $filename, $title, $desc) {
                global $default;
                global $lang_notif_subject_new, $lang_notif_subject_upd, $lang_notif_msg;
                global $lang_title, $lang_description;
                $sql = new scg_DB;

                $path = find_path($parent);
		$sql->query("select id from files where filename='$filename' AND parent='$parent'");
		$sql->next_record();
		$fileid = $sql->f("id");

                $sql->query("select distinct id, email from usuarios as u, $default->scg_users_grpmem_table as m where notify = 1 and (u.groupid = $groupid or m.groupid = $groupid)");

                while($sql->next_record())
                {

			if ( check_auth($fileid, "file_download", $sql->f(id)) == 1 ) {

                  		$newpath = ereg_replace(" ","%20",$path);
                  		$newfilename = ereg_replace(" ","%20",$filename);
                  		if ( $flag == 0 )
                     				mail($sql->f("email"),
                          				"$lang_notif_subject_new",
                          				"$lang_notif_msg$default->scg_notify_link$newpath/$newfilename " .
                          				"\n\n $lang_title: $title" .
                          				"\n\n $lang_description: $desc \n\n",
                           				"From: $default->scg_notify_from\nReply-to: $default->scg_notify_replyto\nX-mailer: PHP/" . phpversion() . "\n");
                  		else
                     				mail($sql->f("email"),
                         				"$lang_notif_subject_upd",
                         				"$lang_notif_msg$default->scg_notify_link$newpath/$newfilename " .
                         				"\n\n $lang_title: $title" .
                         				"\n\n $lang_description: $desc \n\n",
                         				"From: $default->scg_notify_from\nReply-to: $default->scg_notify_replyto\nX-mailer: PHP/" . phpversion() . "\n");
				}

                	}

}

/*--------------------------------------------------------------------------------------*/

function verify_login($username, $password) {
	//VERIFICA la identidad del usuario
	global $default;
	$sql = new scg_DB;
	$sql->query("select * from usuarios where usuario='$username' and clave='$password'");
	$numrows = $sql->num_rows($sql);
	if ($numrows >= "1") { ///OJO OJO OJO aqui!!!!!!!!!!!!!!!!!!
		while($sql->next_record()) {
			if ($elusuarioestadeshabilitad=='S') { //en algun momento se puede poner un campo adicional en la tabla que permita saber si el usuario está inhabilitado o no
				$verified["bit"] = 2;
			} else {
				$verified["bit"] = 1;
			}
			$verified["userid"]			= $sql->f("usuario");
			$verified["ctrl_menu_sup"] 	= $sql->f("ctrl_menu_sup");
			$verified["ctrl_menu_cat"] 	= $sql->f("ctrl_menu_cat");
			$verified["vista"]			= $sql->f("vista");
		}
	}
	/*ccedillo*/
	$sql->query("select * from sesion_activa where usuario = '".$verified["userid"]."'");
	$numrows = $sql->num_rows($sql);
	if ($numrows == "1") {
		while($sql->next_record()) {
			$ip_anterior	= $sql->f("ip");
			if (getenv(HTTP_X_FORWARDED_FOR)){
				$ip=getenv(HTTP_X_FORWARDED_FOR);
			} else {
				$ip=getenv(REMOTE_ADDR);
			}
			if ($ip_anterior == $ip) {
				$verified["bit"]	= 4; //ya estaba activa una sesión de la misma máquina y será borrada la más antigua
			} else {
				$verified["bit"]	= 3; //ya está activa en otra máquina
			}
		}
	}
	if ($verified["bit"] == 4) {
		$sql = new scg_DB;
		$sql->query("delete from sesion_activa where usuario = '".$verified["userid"]."'");
		$verified["bit"]	= 1;
	}
	/*ccedillo*/
	$sql->disconnect($sql->Link_ID);
	return $verified;
}

/*--------------------------------------------------------------------------------------*/

function verify_session($sess) {
	global $default, $lang_sesstimeout, $lang_sessinuse;
  	$sess = ltrim($sess);
	$verified["bit"] = 0;
	$sql = new scg_DB;
  	$sql->query("select * from sesion_activa where sess_id = '$sess'");
	$numrows = $sql->num_rows($sql);
	$time = time();
	if ($numrows == "1") {
		while($sql->next_record()) {
			if (getenv(HTTP_X_FORWARDED_FOR)){
				$ip=getenv(HTTP_X_FORWARDED_FOR);
			} else {
				$ip=getenv(REMOTE_ADDR);
			}
			if ($ip == $sql->f("ip")) {
				if(($time - $sql->f("lastused")) <= $default->scg_timeout) {
					$verified["bit"] = 1;
					$verified["userid"] = $sql->f("usuario");
					$verified["ctrl_menu_sup"] 	= $sql->f("ctrl_menu_sup");
					$verified["ctrl_menu_cat"] 	= $sql->f("ctrl_menu_cat");
					$verified["vista"] 					= $sql->f("vista");
					$sql->query("select * from usuarios where usuario = '".$verified["userid"]."'");
					while($sql->next_record()) $verified["groupid"] = $sql->f("groupid");
				} else {
					if (file_exists("./includes/header.inc")) {
						include("./includes/header.inc");
					} else {
						include("../includes/header.inc");
					}
					exit("<BR><BR><CENTER>".$lang_sesstimeout);
				}
			} else {
				if (file_exists("./includes/header.inc")) {
					include("./includes/header.inc");
				} else {
					include("../includes/header.inc");
				}
				print("<BR><BR><CENTER>".$lang_sessinuse);
				exit;
			}
		}
	}
	$sql->disconnect($sql->Link_ID);
	return $verified;
}

/*--------------------------------------------------------------------------------------*/

function uid_to_name($id) {
	global $default;
	$sql = new scg_DB; $sql->query("select name from usuarios where usuario = '$id'");
	while($sql->next_record()) $name = $sql->f("name");
	if ($name == "") $name = "scg";
	$sql->disconnect($sql->Link_ID);
	return $name;
}

if ($sess) {
	$ok = verify_session($sess);
	$temporary_ok =  $ok["bit"];
	$userid = $ok["userid"];
	if ($ok["bit"] != "1") {
		print("<br><br><center>".$lang_invalidsess);
		exit;
	} else {
		$lastused = time();
		$sql = new scg_DB;
		$sql->query("update sesion_activa set lastused = '$lastused' where usuario = '$userid'");
		$sql->disconnect($sql->Link_ID);
	}
}

/*--------------------------------------------------------------------------------------*/

function checkrequirements() {
    global $default, $lang_err_bad_version_1, $lang_err_bad_version_2, $lang_err_bad_version_3;
    if (substr(phpversion(),0,5) < $default->phpversion) {
        print("<CENTER><H3>$lang_err_bad_version_1<BR>");
        print("$default->phpversion<BR>");
        print("$lang_err_bad_version_2<BR>");
        print phpversion();
        print("<BR>$lang_err_bad_version_3</H3></CENTER>");
        return 1;
    } else {
        return 0;
    }
}

/*--------------------------------------------------------------------------------------*/

function printError($message, $submessage) {
	global $default;
        global $sess, $parent, $expand, $order, $sortorder ,$sortname;

	require("$default->scg_fs_root/locale/$default->scg_lang/language.inc");
	include("./includes/header.inc");
	echo("<TABLE WIDTH=$default->table_expand_width BGCOLOR=\"#d0d0d0\" CELLSPACING=0 CELLPADDING=0 BORDER=0 HEIGHT=30>");
	echo("<TR><TD ALIGN=LEFT>");
	print("$lang_user: ");
	print("<A HREF='prefs.php?user=$userid&sess=$sess&expand=$expand&order=$order&sortname=$sortname'>");
	print uid_to_name($userid);
	print ("</A><FONT SIZE=-1>");
	print("<A HREF='index.php?login=logout&sess=$sess'> ($lang_logout)</A>");
	print("</FONT></TD>");
	print("<TD ALIGN=RIGHT><A HREF='browse.php?sess=$sess&parent=$parent&expand=$expand&order=$order&$sortorder=$sortname'>$lang_return</A>");
	print("</TD></TR></TABLE><BR><BR><CENTER>");
	print $message;
	print $submessage;
	include("./includes/footer.inc");
}
if (!$sess && !$loginname && !$login) header("Location: " . $default->scg_root_url . "/index.php?login=1");
?>
