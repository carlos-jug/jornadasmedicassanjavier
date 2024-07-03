<?php

include_once("admin/config.inc.php");
include_once("admin/utils.inc.php");

$contador = $db->get_row(TBL_CONTADOR, "id=1");
$ip = GetRealIP();

// Reinicar contador cada mes
/*
list($cy, $cm, $cd) = explode('-', $db->db_get_value("fecha", TBL_CONTADOR, "id={$contador['id']}"));
if ( mktime(0,0,0,$cm,1,$cy) != mktime(0,0,0,date('m'),1,date('Y')) ) {
  $nFecha = date("Y-m-d");
  $db->query("UPDATE ".TBL_CONTADOR." SET numero=0, fecha='$nFecha' WHERE id={$contador['id']}");
  $db->query("DELETE FROM ".TBL_CONTADOR_IP." WHERE rLock!=1");
}
*/

// Aumentar conteo
$nFechaHora = date("Y-m-d H:i:s");
$vFechaHora = date("Y-m-d H:i:s", time()-3*60*60);

$db->pquery("DELETE FROM ".TBL_CONTADOR_IP." WHERE fecha < '$vFechaHora' AND rLock!=1");
if ( $db->count(TBL_CONTADOR_IP, "ip='{$ip}'") == 0 ) {
	$db->pquery("INSERT INTO " . TBL_CONTADOR_IP . " VALUES('{$ip}', '$nFechaHora', 0)");
	$numero = $contador['numero'] + 1;
	$db->pquery("UPDATE ".TBL_CONTADOR." SET numero=$numero WHERE id={$contador['id']}");
}
printf("%0".$contador['digitos']."d", $db->get_value("numero", TBL_CONTADOR, "id=1"));
?>