<?php
date_default_timezone_set('America/Mexico_City');
session_start();
/*** Verificar procedencia de datos ***/
$phpSelf = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$phpReferer = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/'));
$site = str_replace('/', '', strrchr(str_replace($phpSelf, '', $phpReferer), '/'));
/*** ~ ***/
if ( $site != $_SERVER['HTTP_HOST'] )
{
	if ( $_SESSION['Paso4'] )
		$_SESSION['Error3DSecure'] = true;
	header("Location: ./?s=4");
	exit;
}
// Comprobar que el paso anterior se completo
if ( !$_SESSION['Paso4'] || !is_numeric($_SESSION['IdReg']) || $_SESSION['IdReg'] != $_SESSION['IdRegistrado'] )
{
	header("Location: ./");
	exit;
}

include_once("../admin/config.inc.php");
include_once("../admin/utils.inc.php");

// Configuracion
$tabla = TBL_REGISTROS;

// Variables
$IdReg = $_SESSION['IdReg']; $_SESSION['IdReg'] = '';
$Precio = $db->get_value('Precio', $tabla, "id=?", '', array('i'=>array($IdReg)));
$Nombre = $db->get_value('Titulo', $tabla, "id=?", '', array('i'=>array($IdReg))).' '.$db->get_value('Apellido', $tabla, "id=?", '', array('i'=>array($IdReg))).' '.$db->get_value('Nombre', $tabla, "id=?", '', array('i'=>array($IdReg)));

$Titular = $_SESSION['Titular']; $_SESSION['Titular'] = '';
$TipoTarjeta = $_SESSION['TipoTarjeta']; $_SESSION['TipoTarjeta'] = '';
$Tarjeta = $_SESSION['Tarjeta']; $_SESSION['Tarjeta'] = '';
$Fecha = $_SESSION['MM'].'/'.$_SESSION['YY']; $_SESSION['MM'] = ''; $_SESSION['YY'] = '';
$Codigo = $_SESSION['Codigo']; $_SESSION['Codigo'] = '';
?>
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">$(document).ready(function(){ $("form").submit(); });</script>
<form method="post" action="https://eps.banorte.com/secure3d/Solucion3DSecure.htm">
  <input type="hidden" name="Card" value="<?php echo $Tarjeta;?>" />
  <input type="hidden" name="Expires" value="<?php echo $Fecha;?>" />
  <input type="hidden" name="Total" value="<?php echo number_format($Precio,2);?>" />
  <input type="hidden" name="CardType" value="<?php echo $TipoTarjeta;?>" />
  <input type="hidden" name="MerchantId" value="7622866" />
  <input type="hidden" name="MerchantName" value="HOSP SAN JAVIER I" />
  <input type="hidden" name="MerchantCity" value="GUADALAJARA" />
  <input type="hidden" name="ForwardPath" value="https://jornadasmedicassanjavier.com/registro/response.php" />
  <input type="hidden" name="Cert3D" value="03" />

  <input type="hidden" name="CVV" value="<?php echo $Codigo;?>" />
  <input type="hidden" name="Titular" value="<?php echo $Titular;?>" />
  <input type="hidden" name="IdReg" value="<?php echo $IdReg;?>" />
  <input type="hidden" name="Nombre" value="<?php echo $Nombre;?>" />
</form>