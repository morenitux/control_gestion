<?
/*--------------------------------------------------------------------------------------
|	Archivo:        connect.php
|       Autor:          Alfredo Morales Becerra (alfmorales@metro.df.gob.mx)
|       Fecha:          Marzo 2006
|
|       Sistema de Transporte Colectivo
|       Dirección de Transportación
|       Proyecto: "Sistema de Gestión"
|
|       Última adaptación para Transportación:   09/10/2007
|
--------------------------------------------------------------------------------------*/
$user = $User;
$pass = $Password;
$db0 = $Database;
$host="localhost";
if ($host=="10.15.20.134"){
   $conn_s = pg_Connect("host=$host port=5432 dbname=$db0 user=$user password=$pass");
  }else{
   $conn_s = pg_Connect("host=$host port=5432 dbname=$db0 user=$user");
}
if (!$conn_s) {
	printf("Error al abrir la base de datos '%s'.\n", $db0);
	exit;
}
?>

