<?php
/*
 * Session Management for PHP3
 *
 * Copyright (c) 1998-2000 NetUSE AG
 *                    Boris Erdmann, Kristian Koehntopp
 *
 * Adapted from db_mysql.inc by Sascha Schumann <sascha@schumann.cx>
 *
 * metadata() contributed by Adelino Monteiro <adelino@infologia.pt>
 *
 * $Id: db_sybase.inc,v 1.2 2001/10/10 03:16:23 bozz Exp $
 *
 */ 

class DB_Sql {
  var $Host     = "";
  var $Database = "";
  var $User     = "";
  var $Password = "";

  var $Link_ID  = 0;
  var $Query_ID = 0;
  var $Record   = array();
  var $Row;

  var $Auto_Free = 0;     ## Set this to 1 for automatic sybase_free_result()

  /* public: constructor */
  function DB_Sql($query = "") {
      $this->query($query);
  }

  function connect() {
    if ( 0 == $this->Link_ID ) {
      $this->Link_ID=sybase_pconnect($this->Host,$this->User,$this->Password);
      if (!$this->Link_ID) {
        $this->halt("Link-ID == false, pconnect failed");
      }
	  if(!sybase_select_db($this->Database, $this->Link_ID)) {
        $this->halt("cannot use database ".$this->Database);
      }
    }
  }

  function query($Query_String) {


    /* No empty queries, please, since PHP4 chokes on them. */
    if ($Query_String == "")
      /* The empty query string is passed on from the constructor,
       * when calling the class without a query, e.g. in situations
       * like these: '$db = new DB_Sql_Subclass;'
       */
      return 0;

    $this->connect();

#   printf("Debug: query = %s<br>\n", $Query_String);

    $this->Query_ID = sybase_query($Query_String,$this->Link_ID);
    $this->Row   = 0;
    if (!$this->Query_ID) {
      $this->halt("Invalid SQL: ".$Query_String);
    }

    return $this->Query_ID;
  }

  function next_record() {
    $this->Record = sybase_fetch_array($this->Query_ID);
    $this->Row   += 1;

    $stat = is_array($this->Record);
    if (!$stat && $this->Auto_Free) {
      sybase_free_result($this->Query_ID);
      $this->Query_ID = 0;
    }
    return $stat;
  }

  function seek($pos) {
    $status = sybase_data_seek($this->Query_ID, $pos);
    if ($status)
      $this->Row = $pos;
    return;
  }

  function metadata($table) {
	  $count = 0;
	  $id    = 0;
	  $res   = array();

	  $this->connect(); 
	  $result = $this->query("exec sp_columns $table");
	  if ($result < 0) {
		  $this->Errno = 1;
		  $this->Error = "Metadata query failed";
		  $this->halt("Metadata query failed.");
	  }
	  $count = sybase_num_rows($result);

	  for ($i=0; $i<$count; $i++) {
		  $res[$i]["table"] = $table ;
		  $res[$i]["name"]  = sybase_result ($result, $i, "COLUMN_NAME");
		  $res[$i]["type"]  = sybase_result ($result, $i, "TYPE_NAME");
		  $res[$i]["len"]   = sybase_result ($result, $i, "LENGTH");
		  $res[$i]["position"] = sybase_result ($result, $i, "ORDINAL_POSITION");
		  $res[$i]["flags"] = sybase_result ($result, $i, "REMARKS");

	  }
  }

  function affected_rows() {
	return sybase_affected_rows($this->Query_ID);
  }

  function num_rows() {
    return sybase_num_rows($this->Query_ID);
  }

  function num_fields() {
    return sybase_num_fields($this->Query_ID);
  }

  function nf() {
    return $this->num_rows();
  }

  function np() {
    print $this->num_rows();
  }

  function f($Name) {
    return $this->Record[$Name];
  }

  function p($Name) {
    print $this->Record[$Name];
  }
  
  function halt($msg) {
    printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
    printf("<b>Sybase Error</b><br>\n");
    die("Session halted.");
  }
}
?>
