<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Jornadas 20 Aniversario Hospital San Javier</title>
		<link href="style_neuro.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="http://www.jornadasmedicassanjavier.com/hsj.ico" type="image/x-icon" />
		<script type="text/javascript">
			<!--
			function MM_swapImgRestore() {//v3.0
				var i,x,a = document.MM_sr;
				for ( i = 0; a && i < a.length && ( x = a[i]) && x.oSrc; i++)
					x.src = x.oSrc;
			}

			function MM_preloadImages() {//v3.0
				var d = document;
				if (d.images) {
					if (!d.MM_p)
						d.MM_p = new Array();
					var i,j = d.MM_p.length,a = MM_preloadImages.arguments;
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
				var i,j = 0,x,a = MM_swapImage.arguments;
				document.MM_sr = new Array;
				for ( i = 0; i < (a.length - 2); i += 3)
					if (( x = MM_findObj(a[i])) != null) {
						document.MM_sr[j++] = x;
						if (!x.oSrc)
							x.oSrc = x.src;
						x.src = a[i + 2];
					}
			}

			//-->
		</script>
	</head>
	<body onload="MM_preloadImages('img/bt_home_f2.gif','img/bt_contact_f2.gif','img/bt_sponsors_f2.gif','img/bt_ifne_f2.gif','img/mn_accommodation_f2.jpg','img/mn_social_f2.jpg','img/mn_previous_f2.jpg','img/bt_send_abs_f2.jpg')">
		<?php include("includes/barra_fechador.php"); ?>
		<?php include("includes/encabezado.php"); ?>
		<?php include("includes/menu.php"); ?>
		<!-- div sombra -->
		<div id="body_sombra"></div>
		<!-- /div sombra -->
		<div id="body_2">
			<div id="cont_body_left">
				<div id="li_cont">
					<div id="tt_cont">Posters Enviados</div>
					<div id="tx_cont_nav"><a href="Index.php">Inicio</a> / Programa Académico / Poster Listado</div>
				</div>
				<div id="cont_home_tx">
					<!--  <p>* Desayunos incluidos  en registros de inscripción antes del 20 de noviembre de 2015. Después tendrán un costo extra de $100.00 M.N. cada uno o puede adquirirse el paquete de ambos desayunos por $150.00 M.N.<br />
					</p>-->
					<!--  <p>* Desayunos incluidos  en registros de inscripción antes del 20 de noviembre de 2015. Después tendrán un costo extra de $100.00 M.N. cada uno o puede adquirirse el paquete de ambos desayunos por $150.00 M.N.<br />
					</p>-->
					<form id="form_poster" method="post" action="" enctype="multipart/form-data">
			
						<label>Nombre</label><br />
						<input required="required" type="text" name="nombre" /><br /><br />
					
						<label>Correo</label><br />
						<input required="required" type="email" name="correo" /><br /><br />
					
						<label>Especialidad</label><br />
						<input type="text" name="especialidad" /><br /><br />
					
						<label>Subir PDF <small>medidas 80 X 100 (maximo 2mb)</small></label><br />
						<input required="required" type="file" name="archivo" /><br /><br />
					
						<button type="submit">Enviar</button>
					
					</form>
					<p>&nbsp;</p>
				</div>
				<p>&nbsp;</p>
			</div>
			<?php include ("includes/banner_sj.html"); ?>
		</div>
		<?php include ("includes/pie.html"); ?>
		<style>
			#form_poster input {
				width: 100%;
				border: 1px solid #008955;
				padding: 10px 0;
				text-indent: 10px;
				margin-top: 10px;
			}
			#form_poster label{
				font-weight: bold;
			}
			#form_poster button{
				width: 100%;
				background: #008955;
				color: #FFFFFF;
				padding: 15px 0;
				border: 1px solid #ffffff;
				cursor: pointer;
			}
			#form_poster button:hover{
				background: #ffffff;
				color: #008955;
				border: 1px solid #008955;
			}
		</style>
	</body>
</html>