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
						<a href="index.php">Inicio</a> / <a href="http://jornadasmedicassanjavier.com/Reg_costos.php"> Registro</a> / Inscripciones
					</div>
				</div>
				
				<form method="post" action="Reg_procesando.php" style="padding:27px;">
					<label class="red">*Obligatorio</label>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Dirección de correo electrónico <span class="red">*</span></label>
								<input type="email" name="email" class="form-control email" id="email" required="required" placeholder="Tu dirección de correo electrónico">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="confirmar_email">Confirmar e-mail <span class="red">*</span></label>
								<input type="text" name="confirmar_email" class="form-control confirmar_email" required="required" id="confirmar_email">
							</div>
						</div>
						<div class="col-md-6">
							<label for="nombre">Titulo - Nombre <span class="red">*</span></label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<select class="form-control titulo" id="titulo" name="titulo" required="required">
										<option value="">Elegir</option>
										<option value="Dr.">Dr.</option>
										<option value="Dra.">Dra.</option>
										<option value="Enfermero">Enfermero</option>
										<option value="Enfermera">Enfermera</option>
										<option value="Residente">Residente</option>
									</select>
								</div>
								<input type="text" name="nombre" class="form-control nombre" required="required" id="nombre">
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="apellido">Apellido <span class="red">*</span></label>
								<input type="text" name="apellido" class="form-control apellido" required="required" id="apellido">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="institucion">Institución / Compañia <span class="red">*</span></label>
								<input type="text" name="institucion" class="form-control institucion" required="required" id="institucion">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="departamento">Departamento</label>
								<input type="text" name="departamento" class="form-control departamento" id="departamento">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="especialidad">Especialidad <span class="red">*</span></label>
								<select class="form-control especialidad" required="required" id="especialidad" name="especialidad">
									<option value="">Elegir</option>
									<option value="Oncologia">Oncologia</option>
									<option value="Otra">Otra</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="especialdiad_otra">...otra, especifique</label>
								<input type="text" name="especialdiad_otra" class="form-control especialdiad_otra" id="especialdiad_otra">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="evento">Evento <span class="red">*</span></label>
								<select class="form-control evento" required="required" id="evento" name="evento">
									<option value="">Elegir</option>
									<option value="Oncología al limite VII">Oncología al limite VII</option>
									<option value="Enfermería Oncológica">Enfermería Oncológica</option>
									<option value="Dolor y Paliativos en Oncología">Dolor y Paliativos en Oncología</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">&nbsp;</label>
								<input type="text" readonly="readonly" name="precio" class="form-control precio" id="precio">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="direccion">Dirección (Calle, número) <span class="red">*</span></label>
								<input type="text" name="direccion" class="form-control direccion" required="required" id="direccion">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cp">Código Postal <span class="red">*</span></label>
								<input type="text" name="cp" class="form-control cp" required="required" id="cp">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="ciudad">Ciudad <span class="red">*</span></label>
								<input type="text" name="ciudad" class="form-control ciudad" required="required" id="ciudad">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="telefono">Teléfono <span class="red">*</span></label>
								<input type="text" name="telefono" class="form-control telefono" required="required" id="telefono">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="fax">Fax</label>
								<input type="text" name="fax" class="form-control fax" id="fax">
							</div>
						</div>						
					</div>
					<button type="submit" class="btn btn-green">Pagar</button>
				</form>
			</div>
			<?php include("includes/banner_sj.html");?>

		</div>
		<?php include("includes/pie.html");?>
		<style>
			.red{color:#FF0000;}
			.btn-green{background:#106941;border-color:#106941;color:#FFFFFF;}
		</style>
		<script>
			$(document).ready(function(){
				$("#evento").change(function(){
					var evento=$(this).val();
					const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
					const d = new Date();
					var mes=monthNames[d.getMonth()];
                    if(evento=="Oncología al limite VII"){
                        if(mes=="Enero" || mes=="Febrero" || mes=="Marzo" || mes=="Abril" || mes=="MAyo" || mes=="Junio" || mes=="Julio" || mes=="Agosto" || mes=="Septiembre" || mes=="Octubre"){
                            $("#precio").val("$2,500.00");
                        }else if(mes=="Noviembre" || mes=="Diciembre"){
                            $("#precio").val("$3,000.00");
                        }
					}else if(evento=="Enfermería Oncológica"){
                        if(mes=="Enero" || mes=="Febrero" || mes=="Marzo" || mes=="Abril" || mes=="MAyo" || mes=="Junio" || mes=="Julio" || mes=="Agosto" || mes=="Septiembre" || mes=="Octubre"){
                            $("#precio").val("$700.00");
                        }else if(mes=="Noviembre" || mes=="Diciembre"){
                            $("#precio").val("$750.00");
                        }
                    }else if(evento=="Dolor y Paliativos en Oncología"){
                        if(mes=="Enero" || mes=="Febrero" || mes=="Marzo" || mes=="Abril" || mes=="MAyo" || mes=="Junio" || mes=="Julio" || mes=="Agosto" || mes=="Septiembre" || mes=="Octubre"){
                            $("#precio").val("$2,500.00");
                        }else if(mes=="Noviembre" || mes=="Diciembre"){
                            $("#precio").val("$3,000.00");
                        }
                    }
			    });
			});
		</script>
	</body>
</html>
