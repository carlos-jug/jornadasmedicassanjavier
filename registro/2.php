<?php
// Comprobar si se accedio correctamente
if ( strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false )
{
	header("Location: ./");
	exit;
}
// Comprobar que el paso anterior se completo
if ( !$_SESSION['Paso1'] )
{
	header("Location: ./");
	exit;
}

/*** Configuracion costos y actividades ***/
$NextStep = '?s=3';
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
/*** ~ ***/

if ( $_SESSION['Paso3'] )
{
	header("Location: {$NextStep}");
	exit;
}

/*** Verificar procedencia de datos ***/
$phpSelf = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$phpReferer = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], '/'));
$site = str_replace('/', '', strrchr(str_replace($phpSelf, '', $phpReferer), '/'));
/*** ~ ***/

if ( isset($_POST['Continuar']) && $site == $_SERVER['HTTP_HOST'] )
{
	if ( $_POST['Asistencia'] != '' )
	{
		$_SESSION['Paso2'] = true;
		$_SESSION['Extras'] = !$_POST['Extras'] ? ($indexPrecios==0 ? count($actividadExtra) : 0) : $_POST['Extras'];
		$_SESSION['Asistencia'] = $_POST['Asistencia'];
		if ( $_POST['Asistencia'] == 'Becario' )
			$_SESSION['Laboratorio'] = $_POST['Laboratorio'];
		else
			$_SESSION['Laboratorio'] = '';
		header("Location: {$NextStep}");
		exit;
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
  <script type="text/javascript">$(document).ready(function(){ $('[name=Precio]:radio').click(function(){ if($(this).val()=='Becario'){ $('select[name=Laboratorio]').prop("disabled", false); }else{ $('select[name=Laboratorio]').prop("disabled", true); } }).triggerHandler("click"); });</script>
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
       <div id="titulo_tx_apartado">Paso 2 de 4: Registro</div>
       <div id="titulo_esq_apartado"><img src="../img/esq_tt_ficha_form.jpg" width="16" border="0" height="15"></div>
    </div>
    <table width="100%" cellpadding="2" cellspacing="2">
      <tbody>

      <tr>
        <td>
          <p>Los precios publicados incluyen iva y son por persona en pesos mexicanos, aplican dentro de las fecha límite de pago, los registros hechos después de ésta fecha pueden tener cargos adicionales. 
          </p>
          <p>Para mayor información acerca del registro, metodos de pago y cancelaciones, lea cuidadosamente <a href="#">Términos Generales JORNADAS 20 ANIVERSARIO Hospital San Javier</a></p>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="td_option_form"><table width="800" cellpadding="2" cellspacing="2">
          <tbody>
            <tr>
              <td colspan="2" align="left"><strong>COSTO Jornadas de Aniversario Hospital San Javier</strong></td>
            </tr>
            <tr>
              <td width="35" align="right"><input type="radio" name="Asistencia" value="Jornadas" <?php echo $_SESSION['Asistencia']=='Jornadas'?'checked':''?> /></td>
              <td width="749"> $ <?php echo number_format($Precios[$indexPrecios],2);?> <?php echo $indexPrecios==0?'(Jornadas incluye desayunos)':'';?></td>
            </tr>
            <tr>
              <td colspan="2" align="right" class="td_separador_line"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="left"><strong>Residentes</strong> * Favor de acreditar residencia con carta del hospital el d&iacute;a del registro.</td>
            </tr>
            <tr>
              <td width="35" align="right"><input type="radio" name="Asistencia" value="Residente" <?php echo $_SESSION['Asistencia']=='Residente'?'checked':''?> /></td>
              <td width="749"> $ 0.00 </td>
            </tr>
            <tr>
              <td colspan="2" align="right" class="td_separador_line"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="left"><strong>Becario</strong></td>
            </tr>
            <tr>
              <td width="35" align="right"><input type="radio" name="Asistencia" value="Becario" <?php echo $_SESSION['Asistencia']=='Becario'?'checked':''?> /></td>
              <td width="749"> $ 0.00 </td>
            </tr>
            <tr>
              <td width="35"></td>
              <td>
                Laboratorio 
                <select name="Laboratorio">
                  <option></option>
                </select>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>

          </tbody>
        </table></td>
      </tr>
      <tr>
        <td class="td_option_form">
        <table width="800" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3" align="left"><strong>COSTOS actividades extras Jornadas de Aniversario Hospital San Javier</strong></td>
  </tr>
	<?php
		for ($indexExtras=0;$indexExtras<count($actividadExtra);$indexExtras++)
		{
	?>
  <tr>
    <td width="38" align="right"><input type="radio" name="Extras" value="<?php echo $indexExtras+1;?>" <?php echo $indexPrecios==0?'checked disabled':'';?>  <?php echo $_SESSION['Extras']==$indexExtras+1?'checked':''?> /></td>
    <td width="89">$ <?php echo $indexPrecios==0?'0.00':number_format($precioExtras[$indexExtras],2);?></td>
    <td width="653"><?php echo $actividadExtra[$indexExtras];?></td>
  </tr>
  	<?php
		}
	?>
</table>
        </td>
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