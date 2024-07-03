<?php
// Comprobar si se accedio correctamente
if ( strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false )
{
	header("Location: ./");
	exit;
}

// Configuracion
$NextStep = '?s=2';

if ( $_SESSION['Paso3'] )
{
	header("Location: {$NextStep}");
	exit;
}

$MsjError = array('Titulo'=>'', 'Apellido'=>'', 'Nombre'=>'', 'Compania'=>'', 'Especialidad'=>'', 'Direccion'=>'', 'Telefono'=>'', 'Email'=>'', 'ConfirmEmail'=>'');

/*** Verificar procedencia de datos ***/
$phpSelf = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$phpReferer = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/'));
$site = str_replace('/', '', strrchr(str_replace($phpSelf, '', $phpReferer), '/'));
/*** ~ ***/

if ( isset($_POST['Continuar']) && $site == $_SERVER['HTTP_HOST'] )
{
	$_POST['Pais'] = 'México';
	if ( $_POST['Titulo'] == '' )
	{
		$error = true;
		$MsjError['Titulo'] = 'Seleccione su título de la lista';
	}
	if ( $_POST['Apellido'] == '' )
	{
		$error = true;
		$MsjError['Apellido'] = 'Por favor, ingrese su Apellido';
	}
	if ( $_POST['Nombre'] == '' )
	{
		$error = true;
		$MsjError['Nombre'] = 'Por favor, ingrese su Nombre';
	}
	if ( $_POST['Compania'] == '' )
	{
		$error = true;
		$MsjError['Compania'] = 'Por favor, ingrese su Institución / Compañía';
	}
	if ( $_POST['Especialidad'] == '' )
	{
		$error = true;
		$MsjError['Especialidad'] = 'Seleccione su Especialidad';
	}
	if ( $_POST['Direccion'] == '' || $_POST['CP'] == '' || $_POST['Ciudad'] == '' || $_POST['Pais'] == '' )
	{
		$error = true;
		$MsjError['Direccion'] = 'Rellene los espacios relacionados con su Direccion';
	}
	if ( $_POST['Telefono'] == '' )
	{
		$error = true;
		$MsjError['Telefono'] = 'Por favor, ingrese su numero Telefonico';
	}
	if ( $_POST['Email'] == '' )
	{
		$error = true;
		$MsjError['Email'] = 'Por favor, ingrese su Email';
	}
	elseif ( !filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL) )
	{
		$error = true;
		$MsjError['Email'] = 'Por favor, ingrese un Email valido';
	}
	if ( $_POST['ConfirmEmail'] == '' || $_POST['ConfirmEmail'] != $_POST['Email'] )
	{
		$error = true;
		$MsjError['ConfirmEmail'] = 'El Email y la Confirmación no coinciden';
	}

	if ( !$error )
	{
		if ( $_POST['RFC'] != '' )
		{
			if ( $_POST['DireccionFactura'] == '' )
				$_POST['DireccionFactura'] = $_POST['Direccion'];
			if ( $_POST['CPFactura'] == '' )
				$_POST['CPFactura'] = $_POST['CP'];
			if ( $_POST['CiudadFactura'] == '' )
				$_POST['CiudadFactura'] = $_POST['Ciudad'];
			if ( $_POST['TelefonoFactura'] == '' )
			{
				$_POST['TelefonoClaveFactura'] = $_POST['TelefonoClave'];
				$_POST['TelefonoFactura'] = $_POST['Telefono'];
			}
			if ( $_POST['FaxFactura'] == '' )
			{
				$_POST['FaxClaveFactura'] = $_POST['FaxClave'];
				$_POST['FaxFactura'] = $_POST['Fax'];
			}
		}
		else
		{
			$_POST['DireccionFactura'] = '';
			$_POST['CPFactura'] = '';
			$_POST['CiudadFactura'] = '';
			$_POST['TelefonoClaveFactura'] = '';
			$_POST['TelefonoFactura'] = '';
			$_POST['FaxClaveFactura'] = '';
			$_POST['FaxFactura'] = '';
		}
		$_SESSION['Paso1'] = true;
		foreach ($_POST as $key => $value) { $_SESSION[$key] = addslashes(trim(mb_convert_case($value,MB_CASE_TITLE,"UTF-8"))); }
		$_SESSION['Email'] = mb_convert_case($_SESSION['Email'],MB_CASE_LOWER);
		$_SESSION['ConfirmEmail'] = mb_convert_case($_SESSION['ConfirmEmail'],MB_CASE_LOWER);
		
		header("Location: {$NextStep}");
		exit;
	}
}
if ( isset($_GET['editar']) )
	foreach ($_SESSION as $key => $value) { $_POST[$key] = $value; }
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
<form method="post">
  <div>
    <table border="0">
      <tr>
        <td><p>Usted está a punto de iniciar su proceso de registro en 4 etapas, la última mostrará un resumen de la información donde una vez revisados sus datos accesará al portal del banco en línea.</p>
      <p>Por favor llene todos los campos requeridos como obligatorios, de lo contrario su registro no podrá proceder y quedará automáticamente cancelado.</p></td>
      </tr>
    </table> 
    <div id="titulo_apartado">
       <div id="titulo_tx_apartado">Paso 1 de 4: Datos generales</div>
       <div id="titulo_esq_apartado"><img src="../img/esq_tt_ficha_form.jpg" width="16" border="0" height="15"></div>
    </div>
    <table width="100%" cellpadding="2" cellspacing="2">

      <tbody>
      <tr>
        <td>Por favor proporcione la siguiente información:</td>
      </tr>
      <tr>
        <td class="td_option_form"><table width="800" cellpadding="2" cellspacing="2">
          <tbody>
            <tr>
              <td align="right">Título:</td>
              <td>
                <select name="Titulo">
                  <option value="" style="color:#999;">Elija su título</option>
                  <option value="Dr." <?php echo $_POST['Titulo']=='Dr.'?'selected':'';?>>Dr.</option>
                  <option value="Dra." <?php echo $_POST['Titulo']=='Dra.'?'selected':'';?>>Dra.</option>
                </select>
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Titulo'] != '' ) { echo "<span>{$MsjError['Titulo']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td width="155" align="right">Apellido:</td>
              <td width="629">
                <input type="text" size="50" maxlength="50" name="Apellido" value="<?php echo $_POST['Apellido'];?>" /> 
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Apellido'] != '' ) { echo "<span>{$MsjError['Apellido']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td align="right">Nombre:</td>
              <td>
                <input type="text" size="50" maxlength="50" name="Nombre" value="<?php echo $_POST['Nombre'];?>" />
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Nombre'] != '' ) { echo "<span>{$MsjError['Nombre']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td align="right">Institución / Compañía:</td>
              <td>
                <input type="text" size="70" maxlength="50" name="Compania" value="<?php echo $_POST['Compania'];?>" />
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Compania'] != '' ) { echo "<span>{$MsjError['Compania']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td align="right">Departamento:</td>
              <td>
                <input type="text" maxlength="50" name="Departamento" value="<?php echo $_POST['Departamento'];?>"/>
              </td>
            </tr>
            <tr>
              <td align="right">Especialidad:</td>

              <td>
                <select name="Especialidad">
                  <option value="" style="color:#999;">Elija su especialidad</option>
                  <?php /*<option value="Neurología" <?php echo $_POST['Especialidad']=='Neurología'?'selected':'';?>>Neurología</option>*/?>
                  <option value="Oncología" <?php echo $_POST['Especialidad']=='Oncología'?'selected':'';?>>Oncología</option>
                  <?php /*<option value="Radiocirugía" <?php echo $_POST['Especialidad']=='Radiocirugía'?'selected':'';?>>Radiocirugía</option>*/?>
                  <option value="Otra" <?php echo $_POST['Especialidad']=='Otra'?'selected':'';?>>Otra</option>
                </select>
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Especialidad'] != '' ) { echo "<span>{$MsjError['Especialidad']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td align="right">Otra,  especifique:</td>
              <td>
                <input type="text" size="70" maxlength="100" name="OtraEspecialidad" value="<?php echo $_POST['OtraEspecialidad'];?>" />
              </td>
            </tr>
            <tr>
              <td align="right">Dirección:</td>
              <td>
                <input type="text" size="70" name="Direccion" value="<?php echo $_POST['Direccion'];?>" />
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Direccion'] != '' ) { echo "<span>{$MsjError['Direccion']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left"><table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="97" class="tx_small_text">Calle</td>
                  <td width="262" class="tx_small_text">Número</td>
                  <td width="41" class="tx_small_text">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
                <input type="text" size="10" maxlength="10" name="CP" value="<?php echo $_POST['CP'];?>" /> 
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Direccion'] != '' ) { echo "<span>{$MsjError['Direccion']}</span>"; } ?>
                </span> <img src="../img/spacer.gif" width="9" height="10" />
                <input type="text" size="40" maxlength="50" name="Ciudad" value="<?php echo $_POST['Ciudad'];?>" /> 
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Direccion'] != '' ) { echo "<span>{$MsjError['Direccion']}</span>"; } ?>
                </span> <img src="../img/spacer.gif" width="9" height="10" />
                <input type="text" size="8" value="M&eacute;xico" disabled style="text-align:center;" />
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left"><table width="500" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="103" class="tx_small_text">Código Postal</td>
                  <td width="277" class="tx_small_text">Ciudad</td>
                  <td width="120" class="tx_small_text">País</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td align="right">Teléfono:</td>
              <td>
                <input type="text" size="5" maxlength="5" style="text-align:center;" name="TelefonoClave" value="<?php echo $_POST['TelefonoClave'];?>" />
                <input type="text" maxlength="20" name="Telefono" value="<?php echo $_POST['Telefono'];?>" /> 
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Telefono'] != '' ) { echo "<span>{$MsjError['Telefono']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td align="right">Fax:</td>
              <td>
                <input type="text" size="5" maxlength="5" style="text-align:center;" name="FaxClave" value="<?php echo $_POST['FaxClave'];?>" />
                <input type="text" maxlength="20" name="Fax" value="<?php echo $_POST['Fax'];?>" />
              </td>
            </tr>
            <tr>
              <td align="right">E-mail:</td>
              <td>
                <input type="text" size="70" name="Email" value="<?php echo $_POST['Email'];?>" /> 
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['Email'] != '' ) { echo "<span>{$MsjError['Email']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td align="right">Confirme e-mail:</td>
              <td>
                <input type="text" size="70" name="ConfirmEmail" value="<?php echo $_POST['ConfirmEmail'];?>" /> 
                <span class="error">
                  <img src="../img/req_form.jpg" width="20" height="12" />
                  <?php if ( $MsjError['ConfirmEmail'] != '' ) { echo "<span>{$MsjError['ConfirmEmail']}</span>"; } ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
          </tbody></table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </tbody></table>
  </div>
  <div>
    <table width="100%" border="0">
      <tr>
        <td class="td_tt_form">
        <div id="gt-res-content">
            <div dir="ltr">Facturación</div>
          </div>
        
        </td>
      </tr>
      <tr>
        <td>Por favor proporcione la siguiente información para efectos fiscales:</td>
      </tr>
      <tr>
        <td class="td_option_form"><table width="700" cellpadding="2" cellspacing="2">
          <tbody>
            <tr>
              <td width="150" align="right">R.F.C.:</td>
              <td width="534">
                <input type="text" size="70" name="RFC" value="<?php echo $_POST['RFC'];?>" />
              </td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <tr>
                <td>Sólo si la información es diferente a su información general:</td>
      </tr>
      <tr>
        <td class="td_option_form"><table width="800" cellpadding="2" cellspacing="2">
          <tbody>
            <tr>
              <td width="155" align="right">Dirección:</td>
              <td width="629">
                <input type="text" size="70" name="DireccionFactura" value="<?php echo $_POST['DireccionFactura'];?>" />
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left"><table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="97" class="tx_small_text">Número</td>
                  <td width="262" class="tx_small_text">Calle</td>
                  <td width="41" class="tx_small_text">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
                <input type="text" size="10" maxlength="10" name="CPFactura" value="<?php echo $_POST['CPFactura'];?>" /> 
                <img src="../img/spacer.gif" width="9" height="10" />
                <input type="text" size="40" maxlength="50" name="CiudadFactura" value="<?php echo $_POST['CiudadFactura'];?>" /> 
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left"><table width="500" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="103" class="tx_small_text">Código Postal</td>
                  <td width="277" class="tx_small_text">Ciudad</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="right">Teléfono:</td>
              <td>
                <input type="text" size="5" maxlength="5" style="text-align:center;" name="TelefonoClaveFactura" value="<?php echo $_POST['TelefonoClaveFactura'];?>" />
                <input type="text" maxlength="20" name="TelefonoFactura" value="<?php echo $_POST['TelefonoFactura'];?>" />
              </td>
            </tr>
            <tr>
              <td align="right">Fax:</td>
              <td><input type="text" size="5" maxlength="5" style="text-align:center;" name="FaxClaveFactura" value="<?php echo $_POST['FaxClaveFactura'];?>" />
                <input type="text" maxlength="20" name="FaxFactura" value="<?php echo $_POST['FaxFactura'];?>" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tbody></table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <div>
    <table width="100%" border="0">
      <tr>
        <td width="199" align="right" class="td_option_form">
          <div style="margin-left:165px;">
            <input type="submit" name="Continuar" value="Continuar" />
          </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="tx_small_text"><img src="../img/bllt_flecha_form.gif" width="9" height="10" /> <a href="#">Términos Generales JORNADAS DE ANIVERSARIO Hospital San Javier</a></td>
      </tr>
    </table>
  </div>
</form>
</div>

<div id="foot_1_form">
  <div id="foot_form">
	<div id="foot_tx_form">JORNADAS DE ANIVERSARIO Hospital San Javier © Derechos Reservados 2015</div>
  </div>
</div>

</body>
</html>