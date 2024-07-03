<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Jornadas Médicas Hospital San Javier</title>
		<link href="style_neuro.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="http://www.jornadasmedicassanjavier.com/hsj.ico" type="image/x-icon" />
		<script type="text/javascript">
			<!--
			function MM_swapImgRestore() {//v3.0
				var i,x,a=document.MM_sr;
				for ( i = 0; a && i < a.length && ( x = a[i]) && x.oSrc; i++)
					x.src = x.oSrc;
			}

			function MM_preloadImages() {//v3.0
				var d = document;
				if (d.images) {
					if (!d.MM_p)
						d.MM_p = new Array();
					var i,j=d.MM_p.length,a=MM_preloadImages.arguments;
					for ( i = 0; i < a.length; i++)
						if (a[i].indexOf("#") != 0) {
							d.MM_p[j] = new Image;
							d.MM_p[j++].src = a[i];
						}
				}
			}

			function MM_findObj(n, d) {//v4.01
				var p,i,x;
				if (!d)
					d = document;
				if (( p = n.indexOf("?")) > 0 && parent.frames.length) {
					d = parent.frames[n.substring(p + 1)].document;
					n = n.substring(0, p);
				}
				if (!( x = d[n]) && d.all)
					x = d.all[n];
				for ( i = 0; !x && i < d.forms.length; i++)
					x = d.forms[i][n];
				for ( i = 0; !x && d.layers && i < d.layers.length; i++)
					x = MM_findObj(n, d.layers[i].document);
				if (!x && d.getElementById)
					x = d.getElementById(n);
				return x;
			}

			function MM_swapImage() {//v3.0
				var i,j=0,x,a=MM_swapImage.arguments;
				document.MM_sr = new Array;
				for(i=0;i<(a.length-2);i+=3){
					if((x=MM_findObj(a[i]))!=null){
						document.MM_sr[j++]=x;
						if(!x.oSrc)
							x.oSrc=x.src;
						x.src=a[i+2];
					}					
				}
			}

			//-->
		</script>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
	</head>

	<body onload="MM_preloadImages('img/bt_home_f2.gif','img/bt_contact_f2.gif','img/bt_sponsors_f2.gif','img/mn_accommodation_f2.jpg','img/mn_social_f2.jpg','img/mn_previous_f2.jpg')">

		<?php include("includes/barra_fechador.php");?>
		<?php include("includes/encabezado.php");?>
		<?php include("includes/menu.php");?>

		<!-- div sombra -->
		<div id="body_sombra"></div>
		<!-- /div sombra -->
		<div id="body_2">
			<div id="cont_body_left">
				<div id="li_cont">
					<div id="tt_cont">Sistema de inscripción en línea</div>
					<div id="tx_cont_nav">
						<a href="index.php">Inicio</a> / <a href="http://jornadasmedicassanjavier.com/Reg_costos.php"> Registro</a> / <a href="http://jornadasmedicassanjavier.com/Reg_inscripcion.php">Inscripciones</a> / Declinada
					</div>
				</div>
				<br /><br /><br /><br /><br />
					
				<?php
				if(isset($_GET['idInscripcion'])){
					$servername = "192.254.236.54";
					$username = "sanjavie_jug";
					$password = "F@ra_2018!";
					$dbname = "sanjavie_jornadasmedicas_2018";
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if(!$conn){die("Connection failed: " . mysqli_connect_error());}
					$now=date("Y-m-d H:i:s");
					$sql = "SELECT * FROM inscripciones_2018 WHERE idInscripcion=".$_GET['idInscripcion']." and email='".$_GET['email']."'";
					if($result = mysqli_query($conn, $sql)) {
					    if(mysqli_num_rows($result) > 0){
					    	$row = mysqli_fetch_assoc($result);
					    	$now=date("Y-m-d H:i:s");
					    	$sql = "UPDATE inscripciones_2018 SET estatus='Completa', fecha_pago='".$now."', numero_autorizacion='".$_GET["tx"]."' WHERE idInscripcion='".$_GET['idInscripcion']."'";
							if(mysqli_query($conn, $sql)){
								require('/PHPMailer2/PHPMailerAutoload.php');
								$mail = new PHPMailer(true);
								$mail->IsSMTP();
								$mail->SMTPAuth= true;
								
								$mail->Host = 'mail.jornadasmedicassanjavier.com';
								$mail->Username = 'contacto@jornadasmedicassanjavier.com';
								$mail->Password = 'yva?5d6kwXobsuJhgrpztielqxjm%f';
								$mail->SMTPSecure = '';
								$mail->Port = '587';
								$mail->IsHTML(true);
								$mail->CharSet = "UTF-8";
								$mail->addAddress('contacto@jornadasmedicassanjavier.com');
								$mail->addAddress($_GET['email']);
								$mail->addBCC('francisco@faracomunicacion.com');
								$mail->addBCC('carlos.jug@juiceweb.mx');
								$mail->setFrom('contacto@jornadasmedicassanjavier.com', 'Jornadas 2018 Aniversario Hospital San Javier');
								$mail->addReplyTo($_GET['email']);
								$mail->Subject = 'Inscripcion Jornadas Medicas';

								$contenido = '<html><body><div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">'.
											'<table width="600px" border="0" cellpadding="2">'.
											'<tr><td colspan="2"><img width="100%" src="http://jornadasmedicassanjavier.com/img/Encabezado_2018.jpg"></td></tr>'.
											'<tr>'.
											'<td>Id Pedido: </td>'.
											'<td>'.$row['idInscripcion'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>E-mail: </td>'.
											'<td>'.$row['email'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Nombre: </td>'.
											'<td>'.$row['titulo'].' '.$row['nombre'].' '.$row['apellido'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Institucion / Departamento: </td>'.
											'<td>'.$row['institucion'].' / '.$row['departamento'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Especialidad: </td>'.
											'<td>'.$row['especialidad'].' - '.$row['especialdiad_otra'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Evento: </td>'.
											'<td>'.$row['evento'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Precio: </td>'.
											'<td>'.$row['precio'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Direccion: </td>'.
											'<td>'.$row['direccion'].', CP: '.$row['cp'].', '.$row['ciudad'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Teléfono / Fax: </td>'.
											'<td>'.$row['telefono'].' / '.$row['fax'].'</td>'.
											'</tr>';
								$contenido.= '<tr>'.
											'<td>Numero de transaccion PayPal: </td>'.
											'<td>'.$_GET["tx"].'</td>'.
											'</tr>';
								$contenido.= '</table>'.
											'</div></body></html>';
								$mail->msgHTML($contenido);
								
								
								if($mail->send()){
									header('Location: http://jornadasmedicassanjavier.com/Reg_completo.php');
								}
							}else{
							    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
							}
						}						
					}else{
					    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
					mysqli_close($conn);
				}else{ ?>
					<section class="well blue" style="padding:27px;">
						<br /><br />
						<h1 align="center">Orden en proceso de autorizacion</h1>
						<hr />
						<br />
						Tu orden esta completa, te mandamos un correo con los datos de tu orden.
						<br /><br />
						<hr />
						<br /><br />
					</section>
				<?php } ?>
			</div>
			<?php include("includes/banner_sj.html");?>
		</div>
		<?php include("includes/pie.html");?>
	</body>
</html>
