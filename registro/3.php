<?php
// Comprobar si se accedio correctamente
if ( strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false )
{
	header("Location: ./");
	exit;
}
// Comprobar que los pasos anterior se completaron
if ( !$_SESSION['Paso1'] || !$_SESSION['Paso2'] )
{
	header("Location: ./");
	exit;
}

require_once("../admin/config.inc.php");
require_once("../admin/utils.inc.php");

/*** Configuracion costos y actividades ***/
$NextStep = '?s=4';
$LastStep = '?s=5';
$Paso1 = './';
$Paso2 = '?s=2';
$FechasCambioPrecios = array('2015-11-20');
$Precios =			array(2500, 2500);
$actividadExtra =	array(
					'4 de diciembre 2015 / Desayuno conferencia: <i>Inmuno oncología</i>.',
					'5 de diciembre 2015 / Desayuno conferencia: <i>Cáncer de pulmón</i>.',
					'Paquete Desayunos 4 y 5 de diciembre 2015 / Conferencias: <i>Inmuno oncología y Cáncer de pulmón</i>.'
					);
$precioExtras =		array(
					100,
					100,
					150
					);
// Encontrar index de precio basado en las fechas de cambio.
$indexPrecios=0;
for ( ; $indexPrecios<count($FechasCambioPrecios); $indexPrecios++ )
{
	if ( date('Y-m-d')<$FechasCambioPrecios[$indexPrecios] )
		break;
}
$tabla = TBL_REGISTROS;
/*** ~ ***/

if ( $_SESSION['Paso3'] )
{
	header("Location: {$NextStep}");
	exit;
}

$MsjError = array('Acepta'=>'');

/*** Verificar procedencia de datos ***/
$phpSelf = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$phpReferer = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/'));
$site = str_replace('/', '', strrchr(str_replace($phpSelf, '', $phpReferer), '/'));
/*** ~ ***/

if ( isset($_POST['Continuar']) && $site == $_SERVER['HTTP_HOST'] )
{
	if ( isset($_POST['Acepta']) )
	{
		// Revisar Precio
		if ( $_SESSION['Asistencia'] != 'Residente' && $_SESSION['Asistencia'] != 'Becario' )
			$_SESSION['Precio'] = $Precios[$indexPrecios];
		else
			$_SESSION['Precio'] = 0;

		if ( $indexPrecios==0 )
			$_SESSION['Extras'] =  count($actividadExtra);
		else
		{
			if ( is_numeric($_SESSION['Extras']) && $_SESSION['Extras']>0 )
				$_SESSION['Precio'] += $precioExtras[($_SESSION['Extras']-1)];
			else
				$_SESSION['Extras'] = 0;
		}
		// Revisar Becario
		if ( $_SESSION['Laboratorio'] != '' )
			$NoBecario = $db->count($tabla,"Laboratorio=?",array('s'=>array($_SESSION['Laboratorio'])))+1;
		// Variables
		$Registrado = date('Y-m-d H:i:s');
		$IP = GetRealIP();

		if ( $db->pquery("INSERT INTO {$tabla} VALUES (0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, NULL, NULL, NULL, NULL)",array('sssssssssssssssssssssssssssssss'=>array($_SESSION['Titulo'],$_SESSION['Apellido'],$_SESSION['Nombre'],$_SESSION['Compania'],$_SESSION['Departamento'],$_SESSION['Especialidad'],$_SESSION['OtraEspecialidad'],$_SESSION['Direccion'],$_SESSION['CP'],$_SESSION['Ciudad'],$_SESSION['Pais'],$_SESSION['TelefonoClave'],$_SESSION['Telefono'],$_SESSION['FaxClave'],$_SESSION['Fax'],$_SESSION['Email'],$_SESSION['RFC'],$_SESSION['DireccionFactura'],$_SESSION['CPFactura'],$_SESSION['CiudadFactura'],$_SESSION['TelefonoClaveFactura'],$_SESSION['TelefonoFactura'],$_SESSION['FaxClaveFactura'],$_SESSION['FaxFactura'],$_SESSION['Extras'],$_SESSION['Asistencia'],$_SESSION['Precio'],$_SESSION['Laboratorio'],$NoBecario,$Registrado,$IP))) )
		{
			$_SESSION['IdRegistrado'] = $db->insert_id();
			$_SESSION['Paso3'] = true;

			if ( $_SESSION['Asistencia'] == 'Residente' || $_SESSION['Asistencia'] == 'Becario' )
			{
				$_SESSION['Paso4'] = true;
				header("Location: {$LastStep}");
			}
			else
				header("Location: {$NextStep}");
			exit;
		}
	}
	else
		$MsjError['Acepta'] = 'Debe aceptar los términos y condiciones para poder continuar.';
}

if ( $_SESSION['Asistencia'] != 'Residente' && $_SESSION['Asistencia'] != 'Becario' )
	$_SESSION['Precio'] = $Precios[$indexPrecios];
else
	$_SESSION['Precio'] = 0;
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
  <script type="text/javascript">$(document).ready(function(){ $('[name="Acepta"]:checkbox').click(function(){ if($(this).prop("checked")){ $(':submit').prop("disabled",false); }else{ $(':submit').prop("disabled",true); } }).triggerHandler("click"); });</script>
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
    <div id="titulo_apartado">
       <div id="titulo_tx_apartado">Paso 3 de 4: Resumen de registro</div>
       <div id="titulo_esq_apartado"><img src="../img/esq_tt_ficha_form.jpg" width="16" border="0" height="15"></div>
    </div>
    <table width="100%" cellpadding="2" cellspacing="2">
      <tbody>

      <tr>
        <td>Por favor revise la información final para su registro:</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="td_tt_form">
          <div id="gt-res-content">
            <div dir="ltr">Paso 1 de 4: Información general</div>
          </div>
        </td>
      </tr>
      <tr>
        <td><table width="800" cellpadding="2" cellspacing="2">
          <tbody>
            <tr>
              <td colspan="2" align="right">
                <div id="edit_form"><a href="<?php echo "{$Paso1}?editar";?>"><img src="../img/ic_edit_form.gif" width="15" height="15" border="0" /> Editar</a></div>
              </td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Título:</strong></td>
              <td><em><?php echo $_SESSION['Titulo'];?></em></td>
            </tr>
            <tr>
              <td width="155" align="right" class="tx_small_text"><strong>Apellido:</strong></td>
              <td width="629"><em><?php echo $_SESSION['Apellido'];?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Nombre:</strong></td>
              <td><em><?php echo $_SESSION['Nombre'];?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Institución / Compañía:</strong></td>
              <td><em><?php echo $_SESSION['Compania'];?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Departmento:</strong></td>
              <td><em><?php echo $_SESSION['Departamento'];?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Especialidad:</strong></td>
              <td><em><?php echo $_SESSION['Especialidad'];?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Dirección:</strong></td>
              <td><em><?php echo "{$_SESSION['Direccion']}, {$_SESSION['CP']}. {$_SESSION['Ciudad']}, {$_SESSION['Pais']}";?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Teléfono:</strong></td>
              <td><em><?php echo "{$_SESSION['TelefonoClave']} {$_SESSION['Telefono']}";?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>Fax:</strong></td>
              <td><em><?php echo "{$_SESSION['FaxClave']} {$_SESSION['Fax']}";?></em></td>
            </tr>
            <tr>
              <td align="right" class="tx_small_text"><strong>E-mail:</strong></td>
              <td><em><?php echo $_SESSION['Email'];?></em></td>
            </tr>
            <tr>
              <td colspan="2" align="right" class="tx_small_text">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td class="td_tt_form">
          <div id="gt-res-content">
            <div dir="ltr">Paso 2 de 4: Registro Jornadas de Aniversario Hospital San Javier</div>
          </div>
        </td>
      </tr>
      <tr>
        <td><table width="800" border="0">
          <tbody>
            <tr>
              <td colspan="2" align="right">
                <div id="edit_form"><a href="<?php echo "{$Paso2}";?>"><img src="../img/ic_edit_form.gif" width="15" height="15" border="0" /> Editar</a></div>
              </td>
            </tr>
            <tr>
              <td width="155" align="right" class="tx_small_text"><strong>$ <?php echo is_numeric($_SESSION['Precio'])?number_format($_SESSION['Precio'],2):"0.00";?></strong></td>
              <td width="630" style="padding-left:5px;"><em>Jornadas de Aniversario Hospital San Javier</em></td>
            </tr>
            <tr>
              <td colspan="2" style="padding-left:155px;" class="tx_small_text"><strong><?php echo $_SESSION['Precio']==0?"/ {$_SESSION['Asistencia']} {$_SESSION['Laboratorio']}":'';?></strong></td>
            </tr>
		<?php
			if ( is_numeric($_SESSION['Extras']) && $_SESSION['Extras']>0 )
			{
		?>
            <tr>
              <td width="155" align="right" class="tx_small_text"><strong>$ <?php echo $indexPrecios==0  ?'0.00' : number_format($precioExtras[$_SESSION['Extras']-1],2);?></strong></td>
              <td width="630" style="padding-left:5px;"><em><?php echo $actividadExtra[$_SESSION['Extras']-1];?></em></td>
            </tr>
		<?php
			}
		?>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td class="td_tt_form">
          <div id="gt-res-content">
            <div dir="ltr">Paso 3 de 4: Resumen del registro</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>He leido y acepto los <a href="#">Términos Generales JORNADAS DE ANIVERSARIO Hospital San Javier</a></td>
      </tr>
      <tr>
        <td><table width="800" border="0">
          <tr>
            <td width="150" align="right"><input type="checkbox" name="Acepta" /></td>
            <td>
              Acepto términos y condiciones.
              <span class="error">
                <img src="../img/req_form.jpg" width="20" height="12" />
                <?php if ( $MsjError['Acepta'] != '' ) { echo "<span>{$MsjError['Acepta']}</span>"; } ?>
              </span>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

      </tbody>
    </table>
  </div>
  <div>
    <table width="100%" border="0">
      <tr>
        <td width="199" align="right" class="td_option_form">
          <input type="submit" name="Continuar" value="Continuar" />
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