<?php
error_reporting(E_ALL & ~E_NOTICE);

	require('phpmailer/class.phpmailer.php');
	
	$send = false;
	$msj_error = array('name'=>'', 'email'=>'', 'message'=>'');
	$error = false;

	if ( isset($_POST['contact']) ) {
	
		if ( $_POST['name'] == '' ) {
			$msj_error['name'] = '(Escriba su nombre)';
			$error = true;
		}
		if ( $_POST['email'] == '' ) {
			$msj_error['email'] = '(Escriba su dirección de correo electrónico)';
			$error = true;
		} elseif ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
			$msj_error['email'] = '(Dirección de correo electrónico inválida)';
			$error = true;
		}
		if ( $_POST['message'] == '' ) {
			$msj_error['message'] = '(El mensaje está vacío)';
			$error = true;
		}

	  if ( !$error ) {
		foreach ($_POST as $key => $value) { $_POST[$key] = addslashes(trim($value)); }

// Sending mail
$mail = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'ssl://204.93.216.68';
$mail->Port = '465';
$mail->Username = 'noresponder@jornadasmedicassanjavier.com';
$mail->Password = 'N0R1sponder';

$mail->AddAddress('contacto@jornadasmedicassanjavier.com');
$mail->SetFrom('noresponder@jornadasmedicassanjavier.com', 'Jornadas 20 Aniversario Hospital San Javier');
$mail->AddReplyTo($_POST['email'], $_POST['name']);
$mail->Subject = 'Mensaje de Contacto';

$contenido = '<html><body><div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">'.
			'<table width="100%" border="0" cellpadding="2">'.
			'<tr><td>&nbsp;</td></tr>'.
			'<tr>'.
			'<td colspan="2">INFORMACION</td>'.
			'</tr><tr>'.
			'<td width="20%">Nombre: </td>'.
			'<td>'.$_POST['name'].'</td>'.
			'</tr><tr>'.
			'<td>E-mail: </td>'.
			'<td>'.$_POST['email'].'</td>'.
			'</tr>';
if ( $_POST['subject'] != '' ) { $contenido.= '<tr><td>Asunto: </td><td>'.$_POST['subject'].'</td></tr>'; }
$contenido.= '<tr><td>&nbsp;</td></tr>'.
			'<tr><td>&nbsp;</td></tr>'.
			'<tr>'.
			'<td>Mensaje: </td>'.
			'<td>&nbsp;</td>'.
			'</tr><tr>'.
			'<td colspan="2">'.$_POST['message'].'</td>'.
			'<tr><td>&nbsp;</td></tr>'.
			'</table>'.
			'</div></body></html>';

$mail->MsgHTML($contenido);
if ( $mail->Send() )
	$send = true;
// ~Sending mail
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jornadas 20 Aniversario Hospital San Javier</title>
<link href="style_neuro.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://www.jornadasmedicassanjavier.com/hsj.ico" type="image/x-icon" />
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('img/bt_home_f2.gif','img/bt_contact_f2.gif','img/bt_sponsors_f2.gif','img/bt_ifne_f2.gif','img/mn_accommodation_f2.jpg','img/mn_social_f2.jpg','img/mn_previous_f2.jpg')">

<?php if ($send) { ?>
<form name="formSent" method="post">
	<input type="hidden" name="sent" />
</form>
<script language="javascript">document.formSent.submit();</script>
<?php } ?>

<?php include("includes/barra_fechador.php");?>
<?php include("includes/encabezado.php");?>

<?php include("includes/menu.php");?>

<!-- div sombra -->
	<div id="body_sombra"></div>
<!-- /div sombra -->
<div id="body_2">
<div id="cont_body_left">
    	    	<div id="li_cont">
        	<div id="tt_cont">Contacto</div>
            <div id="tx_cont_nav"><a href="index.php">Inicio</a> / Contacto</div>
    </div>
      <div id="cont_home_tx">
	<form name="formContact" method="post">
        <table width="750" cellspacing="3" cellpadding="3">
          <tr>
            <td width="150" align="right">Nombre:</td>
            <td width="600"><input name="name" type="text" style="width:350px;" value="<?php echo $_POST['name'] ?>" /><span style="color:#D00; font-size:11px; margin-left:15px;"><?php echo $msj_error['name'] ?></span></td>
          </tr>
          <tr>
            <td align="right">E-mail:</td>
            <td><input name="email" type="text" style="width:350px;" value="<?php echo $_POST['email'] ?>" /><span style="color:#D00; font-size:11px; margin-left:15px;"><?php echo $msj_error['email'] ?></span></td>
          </tr>
          <tr>
            <td align="right">T&iacute;tulo:</td>
            <td><input name="subject" type="text" style="width:350px;" value="<?php echo $_POST['subject'] ?>" /></td>
          </tr>
          <tr>
            <td align="right" valign="top">Mensaje:</td>
            <td><span style="float:left"><textarea name="message" style="width:350px;" rows="5"><?php echo $_POST['message'] ?></textarea></span><span style="color:#D00; font-size:11px; float:left; margin-left:15px;"><?php echo $msj_error['message'] ?></span></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td valign="top" style="vertical-align:text-top"><div style="float:left;"><input type="submit" name="contact" value="Enviar" /></div>
            <div style="margin-left:15px; float:left;"><input type="reset" name="reset" value="Borrar" /></div>
            <div style="margin-left:25px; float:left;"><?php echo isset($_POST['sent'])?'<b>>> Su mensaje ha sido enviado, gracias.</b>':''?></div></td>
          </tr>
        </table>
	</form>
      </div>
  </div>

<?php include("includes/banner_sj.html");?>
        



</div>







<?php include("includes/pie.html");?>

</body>
</html>
