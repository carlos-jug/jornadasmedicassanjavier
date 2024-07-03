<?php
date_default_timezone_set('America/Mexico_City');
session_start();
if ( $_POST['RESULTADO_PAYW'] != '' && $_POST['RESULTADO_PAYW'] != 'A' )
{
	$_SESSION['ErrorPW2'] = $_POST['RESULTADO_PAYW'];
	header("Location: ./?s=4");
	exit;
}
elseif ( $_GET['RESULTADO_PAYW'] != 'A' )
{
	$_SESSION['ErrorPW2'] = $_GET['RESULTADO_PAYW'];
	header("Location: ./?s=4");
	exit;
}
$_SESSION['Paso4'] = true;
?>
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">$(document).ready(function(){ $("form").submit(); /*self.close();*/ });</script>
<form method="post" action="./?s=5">
<?php foreach ($_GET as $key=>$value) { ?>
  <input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
<?php } ?>
<?php foreach ($_POST as $key=>$value) { ?>
  <input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
<?php } ?>
</form>
