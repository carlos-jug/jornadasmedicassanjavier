<?php
// Comprobar si se accedio correctamente
if ( strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false )
{
	header("Location: ./");
	exit;
}
// Comprobar que el paso anterior se completo
if ( !$_SESSION['Paso3'] )
{
	header("Location: ?s=3");
	exit;
}

// Configuracion
$Transferencia = '?s=Ficha';
$Tarjeta = 'sender.php';
$MsjError = array('Tarjeta'=>'', 'Codigo'=>'');
$_SESSION['Paso4'] = false;

/*** Verificar procedencia de datos ***/
$phpSelf = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$phpReferer = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/'));
$site = str_replace('/', '', strrchr(str_replace($phpSelf, '', $phpReferer), '/'));
/*** ~ ***/

if ( isset($_POST['Continuar']) && $site == $_SERVER['HTTP_HOST'] )
{
  if ( $_POST['TipoPago'] == 'Transferencia' )
  {
	  $_SESSION['Paso4'] = true;
	  $_SESSION['IdReg'] = $_POST['IdReg'];

		header("Location: {$Transferencia}");
		exit;
  }
  elseif ( $_POST['TipoPago'] == 'Tarjeta' )
  {
	if ( !is_numeric($_POST['Tarjeta']) || strlen(str_replace(' ','',$_POST['Tarjeta'])) != 16 )
	{
		$error = true;
		$MsjError['Tarjeta'] = 'Introduzca el Numero de su Tarjeta, sin espacios';
	}
	if ( !is_numeric($_POST['Codigo']) || strlen(str_replace(' ','',$_POST['Codigo'])) < 3 )
	{
		$error = true;
		$MsjError['Codigo'] = 'Introduzca correctamente su Código de Seguridad';
	}

	if ( !$error )
	{
		$_SESSION['Paso4'] = true;
		$_SESSION['ErrorPW2'] = false;

		$_SESSION['Titular'] = $_POST['Titular'];
		$_SESSION['TipoTarjeta'] = $_POST['TipoTarjeta'];
		$_SESSION['Tarjeta'] = $_POST['Tarjeta'];
		$_SESSION['MM'] = $_POST['MM'];
		$_SESSION['YY'] = $_POST['YY'];
		$_SESSION['Codigo'] = $_POST['Codigo'];
		$_SESSION['IdReg'] = $_POST['IdReg'];
		
		header("Location: {$Tarjeta}");
		exit;
	}
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
<form method="post" autocomplete="off">
    <table width="100%" cellpadding="2" cellspacing="2">
	  <tbody>

	  <tr>
		<td class="td_tt_form">
		  <div id="gt-res-content">
			<div dir="ltr">Opción 1</div>
		  </div>
		</td>
	  </tr>
	  <tr>
		<td><table width="800" cellpadding="2" cellspacing="2">
		  <tbody>
			<tr>
			  <td width="155" align="right" class="tx_small_text"><input type="radio" name="TipoPago" value="Transferencia" <?php echo $_POST['TipoPago']=='Transferencia'?'checked':'';?> /></td>
			  <td width="629"><em>Deseo hacer el pago por medio de transferencia bancaria o depósito en sucursal.</em></td>
			</tr>
			<tr>
			  <td colspan="2" align="right" class="tx_small_text">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" align="right"></td>
			</tr>
		  </tbody>
		</table></td>
	  </tr>
	  <tr>
		<td class="td_tt_form">
		  <div id="gt-res-content">
			<div dir="ltr">Opción 2</div>
		  </div>
		</td>
	  </tr>
	  <tr>
		<td><table width="800" border="0">
          <tr>
            <td colspan="2" style="color:#D00;">
            <?php
			  if ( $_SESSION['Error3DSecure'] )
			  	echo 'La transacción ha sido cancelada por el usuario, si usted no ha realizado dicha cancelación comuníquese con su Banco y vuelva a intentarlo.';
			  elseif ( $_SESSION['Fail3DSecure'] != '' )
			  	echo 'Ha surgido un problema al intentar autentificar su tarjeta ('.$_SESSION['Fail3DSecure'].') y la transacción no puede continuar.
				<br />
				No se han generado cargos a su tarjeta.
				<br />
				Por favor inténtelo de nuevo dentro de un momento; si el problema persiste comuníquese con su Banco.';
			  elseif ( $_SESSION['ErrorPW2'] )
			  {
				  switch ( $_SESSION['ErrorPW2'] )
				  {
					  case 'D':
					  case 'R':
					  	echo 'Su tarjeta ha sido rechazada o su banco a declinado la transacción.
						<br />
						No se han generado cargos a su tarjeta.';
						break;
					  case 'T':
					  	echo 'No se obtuvo respuesta por parte del Banco de su tarjeta; si el problema persiste comuníquese con su Banco.
						<br />
						No se han generado cargos a su tarjeta.';
					  default:
					  	echo 'Hubo un error inesperado durante la transacción y ha sido cancelada.
						<br />
						No se han generado cargos a su tarjeta.';
					  	break;
				  }
			  }
			  $_SESSION['Error3DSecure'] = false;
			  $_SESSION['Fail3DSecure'] = '';
			  $_SESSION['ErrorPW2'] = '';
			?>
            </td>
          </tr>
		  <tr>
			<td width="155" align="right" class="tx_small_text"><input type="radio" name="TipoPago" value="Tarjeta" <?php echo $_POST['TipoPago']=='Tarjeta'?'checked':'';?> /></td>
			<td width="629"><em>Tarjeta de Crédito <span style="font-size:10px;">Visa y MasterCard</span></em></td>
		  </tr>
		  <tr>
			<td align="right" class="tx_small_text"><strong>Titular de la tarjeta:</strong></td>
			<td><input name="Titular" type="text" size="30" /></td>
		  </tr>
          <tr>
            <td align="right" class="tx_small_text"><strong>Tipo de tarjeta:</strong></td>
            <td><input type="radio" name="TipoTarjeta" value="VISA" /> Visa</td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="TipoTarjeta" value="MC" /> MasterCard</td>
          </tr>
		  <tr>
			<td width="155" align="right" class="tx_small_text"><strong>Tarjeta de Crédito No.:</strong></td>
			<td width="635">
				<input name="Tarjeta" type="text" maxlength="16" size="30" />
				<span class="error">
				  <?php
                  if ( $MsjError['Tarjeta'] != '' )
				  {
					echo '<img src="errorsmall.gif" />';
					echo "<span>{$MsjError['Tarjeta']}</span>";
				  }
				  ?>
				</span>
			</td>
		  </tr>
		  <tr>
			<td align="right" class="tx_small_text"><strong>Fecha de expiración:</strong></td>
			<td>
			  <select name="MM">
			  <?php for( $i=1;$i<=12;$i++ ) { ?>
				<option value="<?php printf('%02d',$i);?>"><?php printf('%02d',$i);?></option>
			  <?php } ?>
			  </select>
			   / 
			  <select name="YY">
			  <?php for( $i=date('Y');$i<=(date('Y')+12);$i++ ) { ?>
				<option value="<?php echo substr($i,-2);?>"><?php echo $i;?></option>
			  <?php } ?>
			  </select>
			</td>
		  </tr>
		  <tr>
			<td align="right" class="tx_small_text"><strong>Código de seguridad</strong>:</td>
			<td>
				<input name="Codigo" type="text" maxlength="4" style="width:40px; text-align:center;" />
				<span class="error">
				  <?php
                  if ( $MsjError['Codigo'] != '' )
				  {
					echo '<img src="errorsmall.gif" />';
					echo "<span>{$MsjError['Codigo']}</span>";
				  }
				  ?>
				</span>
			</td>
		  </tr>
		  <tr>
			<td align="right" valign="top" class="tx_small_text"><strong>¿Cuál es su código?:</strong></td>
			<td valign="top" class="tx_small_text">El código de seguridad son los 3 últimos digitos que encontrará en la parte trasera de su tarjeta de crédito o los 4 digitos de la parte frontal de las tarjetas American Express.</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
		</table></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td width="199" align="right" class="td_option_form">
		  <input type="hidden" name="IdReg" value="<?php echo $_SESSION['IdRegistrado'];?>" />
		  <p>
            Para cualquier asistencia, porfavor contactenos en <a href="mailto:ensenanz@sanjavier.com.mx">ensenanz@sanjavier.com.mx</a>
            <br /><br />
            <strong>Seguridad:</strong> Por seguridad su dirección IP ha sido guardada.
          </p>
		  <br />
		  <input type="submit" name="Continuar" value="Continuar" />
		</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>

	  </tbody>
	</table>
</form>
  </div>
</div>

<div id="foot_1_form">
  <div id="foot_form">
	<div id="foot_tx_form">JORNADAS DE ANIVERSARIO Hospital San Javier © Derechos Reservados 2015</div>
  </div>
</div>

</body>
</html>