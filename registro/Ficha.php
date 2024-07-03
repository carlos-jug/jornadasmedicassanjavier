<?php
// Comprobar si se accedio correctamente
if ( strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false )
{
	header("Location: ./");
	exit;
}
/*** Verificar procedencia de datos ***/
$phpSelf = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$phpReferer = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/'));
$site = str_replace('/', '', strrchr(str_replace($phpSelf, '', $phpReferer), '/'));
/*** ~ ***/
if ( $site != $_SERVER['HTTP_HOST'] || !$_SESSION['Paso4'] )
{
	header("Location: ?s=4");
	exit;
}
// Comprobar que el paso anterior se completo
if ( !is_numeric($_SESSION['IdReg']) || $_SESSION['IdReg'] != $_SESSION['IdRegistrado'] )
{
	header("Location: ./");
	exit;
}

require_once("../admin/config.inc.php");
require_once("../admin/utils.inc.php");

// Configuracion
$tabla = TBL_REGISTROS;

// Variables
$IdReg = $_SESSION['IdReg']; $_SESSION['IdReg'] = '';
$Precio = $db->get_value('Precio', $tabla, "id=?", '', array('i'=>array($IdReg)));
$NumeroControl = sprintf("I%03d",$IdReg).'D'.strtotime(date('Y-m-d H:i:s'));

$db->pquery("UPDATE {$tabla} SET NumeroControl=?, CodigoAutorizacion='Transfer', Referencia='Transfer', Banco='Transfer' WHERE id=?", array('si'=>array($NumeroControl,$IdReg)));
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
  <script type="text/javascript">$(document).ready(function(){ $("input[value=Imprimir]").bind('click', function(){ window.print(); }); $("input[value=Continuar").bind('click', function(){ if(confirm('Antes de continuar asegúrese de haber impreso esta ficha o guardado los datos de la misma.\n¿Esta seguro que desea continuar?')){ window.location='./?s=5'; } }) });</script>
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
		<td width="199" class="td_tt_form">
		  <div id="gt-res-content">
			<div dir="ltr">TRANSFERENCIA ELECTRÓNICA O DEPÓSITO BANCARIO</div>
		  </div>
		</td>
	  </tr>
	  <tr>
		<td><table width="800" cellpadding="2" cellspacing="2">
		  <tbody>
            <tr>
			  <td align="right" class="tx_small_text">NUMERO DE CONTROL:</td>
			  <td><?php echo $NumeroControl;?></td>
			</tr>
			<tr>
			  <td align="right" class="tx_small_text">CONCEPTO:</td>
			  <td>Inscripcion a las Jornadas Médicas del XX aniversario de Hospital San Javier</td>
			</tr>
			<tr>
			  <td align="right" class="tx_small_text">MONTO:</td>
			  <td>$ <?php echo number_format($Precio,2);?> MX</td>
			</tr>
			<tr>
			  <td align="right" class="tx_small_text">&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td align="right" class="tx_small_text">&nbsp;</td>
			  <td><strong>DATOS BANCARIOS</strong></td>
			</tr>
			<tr>
			  <td width="155" align="right" class="tx_small_text">&nbsp;</td>
			  <td width="629">Jornadas de Aniversario<br />
			    Banorte<br />
			    <strong>Cta. 126872352<br />
			    Clabe 072320001268723522</strong><br />
			    Suc. 1159 Yaquis<br />
			    Guadalajara, Jal</td>
			</tr>
			<tr>
			  <td colspan="2" class="tx_small_text">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2">
                UNA VEZ REALIZADO EL PAGO FAVOR DE MANDAR EL COMPROBANTE JUNTO CON ESTA FICHA, O NUMERO DE CONTROL, A:
                <br />
                <a href="mailto:contacto@jornadasmedicassanjavier.com">contacto@jornadasmedicassanjavier.com</a> o vía fax al <strong>(33) 3642 6623</strong>
              </td>
			</tr>
			<tr>
			  <td colspan="2" align="right"></td>
			</tr>
		  </tbody>
		</table></td>
	  </tr>
	  <tr>
	    <td class="td_tt_form">
          <br/>
          <input type="button" value="Imprimir" />
          <input type="button" value="Continuar" />
          <br/><br/>
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