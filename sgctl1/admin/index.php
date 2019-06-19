<?php

/*

  File: index.php
  Author: Chris
  Date: 2000/12/14

  scg: Copyright Chris Vincent <cvincent@project802.net>

  You should have received a copy of the GNU Public
  License along with this package; if not, write to the
  Free Software Foundation, Inc., 59 Temple Place - Suite 330,
  Boston, MA 02111-1307, USA.

  Customización: Saúl E Morales Cedillo (ccedillo@df.gob.mx)
  Dirección de Nuevas Tecnologías
  Coordinación Ejecutiva de Desarrollo Informático
  GDF - México - Septiembre 2002

*/

require("../config/scg.php");
require("../config/html.php");
require("../includes/scg.lib.php");
$incluye_cabeza="";
$titulo_en_header="Administración<br>del ".$default->scg_title_in_header;
$source_para="admin_index";
include("../includes/header.inc");
$incluye_cabeza="";
print("<CENTER>");

if($usergroupid != "0") die("$lang_err_unauthorized");

if(!$action) $action = "users";

function printusers() {
	global $sess, $default, $lang_users;
	$sql = new scg_DB;
	$sql->query("select name,id from usuarios order by name");
	print("<TABLE><TR><TD BGCOLOR='#8EB08A'>$lang_users</TD></TR>");
	while($sql->next_record()) {
		print("<TR><TD align=left><A HREF='index.php?sess=$sess&action=users&user=".$sql->f("id")."'>".$sql->f("name")."</A></TD></TR>");
	}
	print("</TABLE>");
}

function printgroups() {
	global $sess, $lang_groups, $default;
	$sql = new scg_DB;
	$sql->query("select name,id from $default->scg_groups_table order by name");
	print("<TABLE><TR><TD BGCOLOR='#8EB08A'>$lang_groups</TD></TR>");
	while($sql->next_record()) {
		print("<TR><TD align=left><A HREF='index.php?sess=$sess&action=groups&group=".$sql->f("id")."'>".$sql->f("name")."</A></TD></TR>");
	}
	print("</TABLE>");
}

function printuser($id) {
	//global $sess,$change,$lang_saved,$lang_title,$lang_group,$lang_username,$lang_password,$lang_change,$lang_quota,$lang_groupmember,$lang_disableuser, $lang_userlang;
	global $sess,$change,$lang_saved,$lang_user_tag,$lang_group,$lang_username,$lang_password,$lang_change,$lang_quota,$lang_groupmember,$lang_disableuser, $lang_userlang;
	global $lang_deleteuser, $lang_email, $lang_notification, $default, $lang_required, $lang_notify_explanation, $lang_disable_explanation;
	if(isset($change)) print("$lang_saved<BR>");
	$sql = new scg_DB;
	$sql->query("select id,name from $default->scg_groups_table");
	$i=0;
	while($sql->next_record()) {
		$groups[$i][0] = $sql->f("id");
		$groups[$i][1] = $sql->f("name");
		$i++;
	}
	$sql->query("select * from usuarios where id = '$id'");
	while($sql->next_record()) {
		print("<form name='admin_user' action='admin_dbmodify.php' method=post target='_self' onsubmit='return regform_Validator(this);'>\n");
		//print("<FORM action='admin_dbmodify.php' method=POST>");
		print("<input type=hidden name=id value=".$sql->f("id").">");
		print("<input type=hidden name=sess value=$sess>");
		print("<input type=hidden name=action value=user>");
		print("<table border=0 cellspacing=2 cellpadding=2><TR valign=top><TD BGCOLOR='#8EB08A' align=right width=50%>$lang_user_tag</TD><TD align=left width=20%><input type=text name=name value='".$sql->f("name")."'></TD><td width=30%><font face=Arial size=1 color=black>$lang_required</font></td></TR>");
		print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_group</TD><TD align=left><SELECT name=groupid>");
		//print("<OPTION value=".$sql->f("groupid").">".group_to_name($sql->f("groupid")));
		foreach($groups as $g) {
			if ($g[0]==$sql->f("groupid")) {
				print("<OPTION value=$g[0] selected>$g[1]</option>\n");
			} else {
				print("<OPTION value=$g[0]>$g[1]</option>\n");
			}
		}
		print("</SELECT></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");
        //*******************************
        // Display the Language dropdown
        //*******************************

        /*ccedillo: Aqui voy a quitar el POPUP del idioma*/
        /*print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_userlang</TD><TD align=left><SELECT name=newlanguage>");
		print("<OPTION value=".$sql->f("language").">".$sql->f("language"));
                $dir = dir($default->scg_LangDir);
                $dir->rewind();

                while($file=$dir->read())
                {
                     if ($file != "." and $file != "..")
                     {
			//janu's change BEGIN
			print("<OPTION value=$file");
			if ($file == $default->scg_lang)
				print (" SELECTED");
			print(">$file");
			//janu's change END
                     }
                }
                $dir->close();
		print("</SELECT></TD><td><br></td></TR>");*/
		/*ccedillo: Ahora sustituyo el POPUP del idioma por un hidden y entonces TODO estará en ESPAÑOL siempre*/
		print("<input type=hidden name=newlanguage value='Spanish'>");


                // Bozz Change  begin
                //This is to allow a user to be part of more than one group

                print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_groupmember</TD><TD align=left>");
                $i=0;
                $sqlmemgroup = new scg_DB;
                foreach($groups as $g) {
                        $is_set_gid = $g[0];
                        $sqlmemgroup->query("select userid from $default->scg_users_grpmem_table where userid = '$id' and groupid = '$is_set_gid'");
                        $sqlmemgroup->next_record();
                        if ($sqlmemgroup->num_rows($sqlmemgroup) > 0) {
                             print("<input type='checkbox' name='group$i' value=$g[0] checked>$g[1]<BR>");
                        }
                        else {
                             print("<input type='checkbox' name='group$i' value=$g[0]>$g[1]<BR>");
                        }
                        $i++;
                }
                // This hidden field is to store the nubmer of displayed groups for future use
                // when the records are saved to the db


                print("<input type=hidden name=no_groups_displayed value=$i>");
                // Bozz Change End

                print("</td><td><br></td></tr><TR valign=top><TD BGCOLOR='#8EB08A' ALIGN=RIGHT>$lang_username</TD><TD align=left><input type=TEXT name=loginname value='".$sql->f("username")."'></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");
		print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_quota</TD><TD align=left>".$sql->f("quota_current")." / <input type=TEXT name=quota value=".$sql->f("quota_max")."></TD><td><br></td></TR>");
		print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_password</TD><TD align=left><input type=PASSWORD name=password value='".$sql->f("password")."'></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");
                print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_email</TD><TD align=left><input type=TEXT name=email value='".$sql->f("email")."'></TD><td><br></td></TR>");
                if ( $sql->f("notify") == 1)
                    print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_notification</TD><TD align=left><input type=CHECKBOX name=notify value=1 checked></TD><td><font face=Arial size=1 color=black>$lang_notify_explanation</font></td></TR>");
                else
                    print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_notification</TD><TD align=left><input type=CHECKBOX name=notify value=1></TD><td><font face=Arial size=1 color=black>$lang_notify_explanation</font></td></TR>");
                if ( $sql->f("disabled") == 1)
                    print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_disableuser</TD><TD align=left><input type=CHECKBOX name=disabled value=1 checked></TD><td><font face=Arial size=1 color=black>$lang_disable_explanation</font></td></TR>");
                else
                    print("<TR valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_disableuser</TD><TD align=left><input type=CHECKBOX name=disabled value=1></TD><td><font face=Arial size=1 color=black>$lang_disable_explanation</font></td></TR>");
		print("</TABLE><BR><input type=SUBMIT value=$lang_change>");
		if($id != 1 && $id != 999) print("<input type=SUBMIT name=action value='$lang_deleteuser'>");
		print("</FORM>");
	}
}

function printgroup($id) {
	global $sess,$change,$lang_group_tag,$lang_change,$lang_deletegroup,$lang_saved,$default;
	if(isset($change)) print("$lang_saved<BR>");
	$sql = new scg_DB;
	$sql->query("select id,name from $default->scg_groups_table where id = '$id'");
	while($sql->next_record()) {
		print("<FORM action='admin_dbmodify.php' method=POST>");
		print("<input type=hidden name=id value=".$sql->f("id").">");
		print("<input type=hidden name=sess value=$sess>");
		print("<input type=hidden name=action value=group>");
		print("<TABLE><TR><TD BGCOLOR='#8EB08A'>$lang_group_tag</TD><TD><input type=text name=name value='".$sql->f("name")."'></TD></TR></TABLE>");
		print("<BR><input type=SUBMIT value=$lang_change>");
		if($sql->f("id") != 0) print("<input type=SUBMIT name=action value='$lang_deletegroup'>");
		print("</FORM>");
	}
}

function printnewgroup() {
	global $sess,$lang_group_tag,$lang_add;
	print("<FORM action='admin_dbmodify.php' method=post>");
	print("<input type=hidden name=action value=add>");
	print("<input type=hidden name=type value=group>");
	print("<input type=hidden name=sess value=$sess>");
	print("<TABLE BORDER=0><TR><TD BGCOLOR='#8EB08A'>$lang_group_tag</TD><TD><input type=TEXT name=name></TD></TR></TABLE><BR><input type=SUBMIT value=$lang_add></FORM>");
}

function printnewuser() {
	global $sess,$lang_user_tag,$lang_username,$lang_group,$lang_password,$lang_add,$default, $lang_quota,$lang_groupmember;
    global $lang_email, $lang_notification, $lang_disableuser, $lang_userlang, $lang_required, $lang_notify_explanation;
	$sql = new scg_DB;
	$sql->query("select id,name from $default->scg_groups_table");
	$i=0;
	while($sql->next_record()) {
		$groups[$i][0] = $sql->f("id");
		$groups[$i][1] = $sql->f("name");
		$i++;
	}
	print("<form name='admin_user' action='admin_dbmodify.php' method=post target='_self' onsubmit='return regform_Validator(this);'>");
	print("<input type=hidden name=action value=add>");
	print("<input type=hidden name=type value=user>");
	print("<input type=hidden name=sess value=$sess>");
	print("<table border=0 cellspacing=2 cellpadding=2><tr valign=top><TD BGCOLOR='#8EB08A' align=right width=50%>$lang_user_tag</TD><TD align=left width=20%><input type=TEXT name=name></TD><td width=30%><font face=Arial size=1 color=black>$lang_required</font></td></tr>");
	print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_username</TD><TD align=left><input type=TEXT name=loginname></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");
	print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_group</TD><TD align=left><SELECT name=groupid>");
	foreach($groups as $g) {
		print("<OPTION value=$g[0]>$g[1]");
	}
	print("</SELECT></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");

	//*******************************
	// Display the Language dropdown
	//*******************************
	/*ccedillo: Aqui voy a quitar el POPUP del idioma*/
	/*print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_userlang</TD><TD align=left><SELECT name=newlanguage>");
	$dir = dir($default->scg_LangDir);
	$dir->rewind();
	while($file=$dir->read()) {
		if ($file != "." and $file != "..") {
			print("<OPTION value=$file>$file");
		}
	}
	$dir->close();
	print("</SELECT></TD></TR>");*/
	/*ccedillo: Ahora sustituyo el POPUP del idioma por un hidden*/
	print("<input type=hidden name=newlanguage value='Spanish'>");
	// Bozz Change  begin
	//This is to allow a user to be part of more than one group

	print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_groupmember</TD><TD align=left>");
	$i=0;
	foreach($groups as $g) {
		print("<input type='checkbox' name='group$i' value=$g[0]>$g[1]<BR>");
		$i++;
	}
	// This hidden field is to store the nubmer of displayed groups for future use
	// when the records are saved to the db
	print("<input type=hidden name=no_groups_displayed value=$i>");
	// Bozz Change End
	//print("</TD><td><br></td></TR><tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_quota</TD><TD align=left><input type=TEXT name=quota value=0></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");

	print("</TD><td><br></td></TR><tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_quota</TD><TD align=left>");
	print("<select name=quota>\n");
	print("<option value=5120000 selected>5Mb.</b>\n");
	print("<option value=10240000>10Mb.</b>\n");
	print("<option value=15360000>15Mb.</b>\n");
	print("<option value=20480000>20Mb.</b>\n");
	print("</select>\n");
	print("</TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");

	print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_password</TD><TD align=left><input type=PASSWORD name=password></TD><td><font face=Arial size=1 color=black>$lang_required</font></td></TR>");
	print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_email</TD><TD align=left><input type=TEXT name=email></TD><td><br></td></TR>");
	print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_notification</TD><TD align=left><input type=CHECKBOX name=notify value=1></TD><td><font face=Arial size=1 color=black>$lang_notify_explanation</font></td></TR>");
	//print("<tr valign=top><TD BGCOLOR='#8EB08A' align=right>$lang_disableuser</TD><TD align=left><input type=CHECKBOX name=disabled value=1></TD><td><br></td></TR>");
	print("<input type=hidden name=disabled value=0>");
	print("</TABLE><BR><input type=SUBMIT value=$lang_add></FORM>");
}

if($action) {
	print("<table width=$default->table_expand_width border=0 bgcolor='#8EB08A' cellspacing=0 cellpadding=0><tr><td width=50% valign=top align=left>\n");
	//print("$lang_scg_admin");
	print("<a href='../index.php?login=logout&sess=$sess'><img src='$default->scg_root_url/locale/$default->scg_lang/graphics/exit.gif' border=0></a>&nbsp;&nbsp;");
	print("</td><td width=50% valign=top align=right><a href='../browse.php?sess=$sess'><IMG SRC='$default->scg_root_url/locale/$default->scg_lang/graphics/back_repository.gif' border=0></a>");
	print("</td></tr></table>\n");
	//print("<hr width=90%>\n");
	print("<TABLE WIDTH=$default->table_expand_width><TR><TD WIDTH=250 VALIGN=TOP>\n");
	print("<TABLE BORDER=0><TR><TD align=left>\n");
	print("<A HREF='index.php?sess=$sess&action=newuser'>$lang_newuser</A><BR>\n");
	print("<A HREF='index.php?sess=$sess&action=newgroup'>$lang_newgroup</A><BR><BR>\n");
	//ccedillo: ya no tiene caso encriptar passwords si esto sucede cada vez que se capturan. print("<A HREF='upgrade-users.php?sess=$sess'>$lang_upg_MD5</A><BR><BR>\n");
	printusers();
	print("<BR><BR>\n");
	printgroups();
	print("</TD></TR></TABLE>\n");
	print("</TD><TD VALIGN=TOP>\n");
	if(isset($user)) printuser($user);
	if(isset($group)) printgroup($group);
	if($action == "newgroup") printnewgroup();
	if($action == "newuser") printnewuser();
	print("</TD></TR></TABLE>\n");
} else {
	exit("$lang_err_general");
}

print("<BR><HR WIDTH=$default->table_expand_width>");
?>
<!-- BEGIN BUG FIX: #448241 HTML-Syntax-Error in admin/index.php  -->
</BODY>
</HTML>
<!-- BEGIN BUG FIX: #448241 HTML-Syntax-Error in admin/index.php  -->
