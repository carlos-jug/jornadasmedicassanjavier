<?php
// Comprobar si se accedio correctamente
if ( strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false )
{
	header("Location: ./");
	exit;
}
// Comprobar que el paso anterior se completo
if ( !$_SESSION['Paso4'] )
{
	header("Location: ./");
	exit;
}

require_once("../admin/config.inc.php");
require_once("../admin/utils.inc.php");

// Configuracion
$tabla = TBL_REGISTROS;

if ( $_POST['RESULTADO_PAYW'] == 'A' )
{
	$IdReg = $_SESSION['IdRegistrado'];
	if ( $_POST['FECHA_RSP_AUT'] != '' )
		$Pago = preg_replace(array('/(\d{4})(\d{2})(\d{2})/','/(\..*)/'),array('\1-\2-\3',''),$_POST['FECHA_RSP_AUT']);
	else
		$Pago = date("Y-m-d H:i:s");

	if ( $IdReg == (int)preg_replace(array('/I/','/D.*/'),'',$_POST['NUMERO_CONTROL']) )
	{
		$db->pquery("UPDATE {$tabla} SET Pago=?, NumeroControl=?, CodigoAutorizacion=?, Referencia=?, Banco=? WHERE id=?",array('sssssi'=>array($Pago,$_POST['NUMERO_CONTROL'],$_POST['CODIGO_AUT'],$_POST['REFERENCIA'],$_POST['BANCO_EMISOR'],$IdReg)));
	}
	else
	{
		$db->pquery("UPDATE {$tabla} SET Pago=?, NumeroControl=?, CodigoAutorizacion=?, Referencia='ErrorID', Banco='ErrorID' WHERE id=?",array('sssi'=>array($Pago,$_POST['NUMERO_CONTROL'],$_POST['CODIGO_AUT'],$IdReg)));
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Jornadas Médicas Hospital San Javier</title>
  <link rel="shortcut icon" href="http://www.jornadasmedicassanjavier.com/hsj.ico" type="image/x-icon" />
  <link href="../form_style.css" rel="stylesheet" type="text/css" />
  <link href="error.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
</head>

<body>

<div id="hd_fecha">
	<div id="hd_form_tx_fechador">
  <?php
	$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	echo "".$dias[date('w')]." ".date('j')." , ".$mes[date('n')]." , <strong>".date('Y')."</strong>";
	echo ' | '.date("H").':'.date("i");
  ?>
	</div>
</div>

<div id="hd_form"></div>
<div id="hd_tt_form">
  <div id="form_tt">Sistema de inscripción en línea</div>
</div>


<div id="body_form">

  <div>
    <table width="100%" cellpadding="2" cellspacing="2">
      <tbody>

      <tr>
        <td class="td_tt_form">
          <div id="gt-res-content">
            <div dir="ltr">¡Gracias, su registro se ha realizado con éxito!</div>
          </div>
        </td>
      </tr>
      <tr>
        <td class="td_option_form">
          <p>&nbsp;</p>
          <p>Gracias por registrarse a las Jornadas de Aniversario de Hospital San Javier.</p>      
          <p>Para cualquier asistencia, porfavor contáctenos en <a href="mailto:ensenanz@sanjavier.com.mx">ensenanz@sanjavier.com.mx</a></p>
          <p>&nbsp;</p>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

      </tbody>
    </table>
  </div>
</div>

<div id="foot_1_form">
  <div id="foot_form">
	<div id="foot_tx_form">JORNADAS DE ANIVERSARIO Hospital San Javier © Derechos Reservados 2015</div>
  </div>
</div>

</body>
</html>
<?php
$_SESSION = array();
if ( ini_get("session.use_cookies") )
{
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}
session_destroy();
?>