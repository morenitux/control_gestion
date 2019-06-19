<?
$tope="02/01/2019 12:40";
if (!$fin) $fin=0;
if (date("d/m/Y H:i")!=$tope) echo '<META HTTP-EQUIV="refresh" content="1">';
?>
<body >
<?
echo "<br>".date("d/m/Y H:i:s")."<br><br>Las Bases de Datos resetearan su folios para el ".substr($tope,6,4)." el $tope<br>";
$anio=substr($tope,8,2);
$bases=array( "SGCTL1", "SGCTL3", "SGDGGSII", "SGDGSGMT",
              "SGDGSGOP", "SGDOCICS", "SGDOCIDO",
              "SGDOJEFA","SGDTGL25","SGDTGL34",
              "SGDTGL78","SGDTSGCC","SGSBGL13");

$fol = array( "C1/", "C3/", "GSI", "SGM",
              "SGO","MGI","CSI",
              "DT","G2/","G1/",
              "G7/","SCC", "S1/");

$count = count($bases);
$user="postgres";
$pass="d4746a53d7";
$host1="50.192.92.16";

if (date("d/m/Y H:i")==$tope){
  for ($i = 0; $i < $count; $i++) {
    $db=$bases[$i];
    $conn = pg_Connect("host=$host1 port=5432 dbname=$db user=$user password=$pass");
    $l=7-strlen($fol[$i]);
    $l=$l*-1;
    $folio=$fol[$i].$anio."-".substr("0000001",$l);
    echo "<br>$db:<br>";

    $query="update folio set fol_sig='$folio'";
    $query2="select fol_sig from folio";
    $result=pg_exec($conn,$query2);
    echo "&nbsp;&nbsp;Original: ". pg_result($result,0,fol_sig)."<br>";

    $result=pg_exec($conn,$query);
    $result=pg_exec($conn,$query2);
    echo "Acualizado: ". pg_result($result,0,fol_sig)."<br><br>";

    $fin=1;
  }
}
?>
</body>
