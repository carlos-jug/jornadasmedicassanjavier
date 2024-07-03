<?php
date_default_timezone_set('America/Mexico_City');
session_start();
if ( $_POST['Status'] != 200 )
{
	$_SESSION['Fail3DSecure'] = preg_replace('/\d/','x',$_POST['Number'],12);
	header("Location: ./?s=4");
	exit;
}
else
{
?>
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">$(document).ready(function(){ $("form").submit(); });</script>
<?php
}
?>
<form method="post" action="https://via.banorte.com/payw2">
  <input type="hidden" name="NUMERO_TARJETA" value="<?php echo $_POST['Number'];?>" />
  <input type="hidden" name="FECHA_EXP" value="<?php echo str_replace('/','',$_POST['Expires']);?>" />
  <input type="hidden" name="CODIGO_SEGURIDAD" value="<?php echo $_POST['CVV'];?>" />
  <input type="hidden" name="MONTO" value="<?php echo number_format($_POST['Total'],2);?>" />

  <input type="hidden" name="ID_AFILIACION" value="<?php echo $_POST['MerchantId'];?>" />
  <input type="hidden" name="ID_TERMINAL" value="76228661" />
  <input type="hidden" name="USUARIO" value="a7622866" />
  <input type="hidden" name="CLAVE_USR" value="hosp2866" />
  <input type="hidden" name="CMD_TRANS" value="VENTA" />
  <input type="hidden" name="MODO" value="PRD" />
  <input type="hidden" name="MODO_ENTRADA" value="MANUAL" /> 

  <input type="hidden" name="XID" value="<?php echo $_POST['XID'];?>" />
  <input type="hidden" name="CAVV" value="<?php echo $_POST['CAVV'];?>" />
  <input type="hidden" name="ESTATUS_3D" value="<?php echo $_POST['Status'];?>" />
  <input type="hidden" name="ECI" value="<?php echo $_POST['ECI'];?>" />

  <input type="hidden" name="URL_RESPUESTA" value="https://jornadasmedicassanjavier.com/registro/receiver.php" />
  <input type="hidden" name="NUMERO_CONTROL" value="<?php printf("I%03d",$_POST['IdReg']); echo 'D'.strtotime(date('Y-m-d H:i:s'));?>" />
  <input type="hidden" name="REF_CLIENTE1" value="<?php echo $_POST['Titular'];?>" />
  <input type="hidden" name="REF_CLIENTE2" value="<?php echo $_POST['IdReg'];?>" />
  <input type="hidden" name="REF_CLIENTE3" value="<?php echo $_POST['Nombre'];?>" />
</form>