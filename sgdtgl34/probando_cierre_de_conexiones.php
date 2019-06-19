<?php
   $pgsql_conn = pg_connect("dbname='SCG01' host='localhost' user='SCG01' password='SCG01'");
   if ($pgsql_conn) {
       print "Successfully connected to: " . pg_host($pgsql_conn) . "<br/>\n";
   } else {
     print pg_last_error($pgsql_conn);
     exit;
   }

  // Do database stuff here.

   if(!pg_close($pgsql_conn)) {
      print "Failed to close connection to " . pg_host($pgsql_conn) . ": " .
      pg_last_error($pgsql_conn) . "<br/>\n";
   } else {
       print "Successfully disconnected from database";
  }
?>
