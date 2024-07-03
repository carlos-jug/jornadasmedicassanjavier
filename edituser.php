<?php
session_start();

if ($_SESSION['admin_valida'] != session_id()) {
	session_destroy();
	header("Location: ./");
	exit;
} elseif ($_SESSION['admin_type'] != 1) {
	header("Location: ./");
	exit;
} elseif ($_GET['id'] == 1 && $_SESSION['admin_id'] != 1) {
	header("Location: users.php");
	exit;
}

if (isset($_POST['logout'])) {
	session_destroy();
	header("Location: ./");
	exit;
}

include("includes/admin/config.inc.php");
include("includes/admin/db_connect.inc.php");
include("includes/admin/db_functions.inc.php");

$tabla = 'admin_user';

$types = array(1=>'Administrator', 'Reviewer');
$error = '';

if (isset($_POST['updateuser'])) {
  foreach ($_POST as $key => $value) { $_POST[$key] = addslashes(trim($value)); }

if ($_GET['id'] == 1) {
  $_POST['login'] = $_POST['login_adm'];
  $_POST['type'] = $_POST['type_adm'];
}

// Verifying Data
  if ($_POST['name'] == '') {
	$error = 'Enter the Name';
  } elseif ($_POST['login'] == '') {
	$error = 'Enter the Username';
  } elseif ($_POST['password'] == '') {
	$error = 'Password required';
  } elseif ($_POST['password'] != $_POST['pass_confirm']) {
	$error = "Password and Confirmation don't match";
  }
// ~Verifying Data

  if ($error == '') {
	mysql_query("UPDATE $tabla SET login='{$_POST['login']}', password=encode('{$_POST['password']}', 'acceso'), name='{$_POST['name']}', type={$_POST['type']} WHERE id={$_GET['id']}");
	$_SESSION['smsj'] = "Updated user";
	header("Location: users.php");
	exit; 		
  }
} elseif (isset($_POST['cancel'])) {
  header("Location: users.php");
  exit; 
} else {
  $_POST = db_get_row($tabla, "id={$_GET['id']}");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>6th NEUROENDOSCOPY INTERNATIONAL FEDERATION CONGRESS</title>
<link href="form_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function logout() {
  document.formLogout.submit();
}
</script>
</head>

<body>

<div id="hd_fecha">
  <div id="hd_form_tx_fechador">    <?php
	$dias = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	$mes = array("","January","February","March","April","May","June","July","August","September","October","November","December");
	echo "".$dias[date('w')]." ".date('j')." , ".$mes[date('n')]." , <strong>".date('Y')."</strong>";
	echo ' | '.date("H").':'.date("i");
	?></div>
	<div id="hd_form_close"><a href="javascript:logout();">Log Out</a> <a href="javascript:logout();"><img src="../img/ic_close.gif" width="15" height="13" border="0" /></a></div>
    <form name="formLogout" method="post">
      <input type="hidden" name="logout" value="1" />
    </form>
</div>

<div id="hd_form_abs"></div>

<div id="hd_tt_form" style="background-color: #142B48">
  <div id="form_tt">Users</div>

</div>


<div id="body_form">
  <div>
    <table width="100%">
      <tr>
        <td>&nbsp;</td>
      </tr>
<?php if ($_SESSION['admin_type'] == 1) { ?>
      <tr>
		<td>
		  <table width="500" class="tb_tt_ab_form" style="padding-left:10px;">
			<tr>
			  <td><strong>Edit User</strong></td>
            </tr>
          </table>
        </td>
	  </tr>
      <tr>
        <td>
<form name="formNewUser" method="post">
        <table width="500" cellspacing="2" cellpadding="2" class="td_option_form" style="padding:5px; padding-top:10px;">
			<?php if ($error != '') { ?>
            <tr>
              <td colspan="2" style="color:#E00;"><?php echo '&nbsp;&nbsp;&bull; '.$error ?></td>
            </tr>
            <?php } ?>
            <tr>
              <td width="140">Name:</td>
              <td width="360"><input name="name" type="text" size="50" value="<?php echo $_POST['name']?>" /></td>
            </tr>
            <tr>
              <td>Username:</td>
              <td><input name="login" type="text" size="50" value="<?php echo $_POST['login']?>" <?php echo $_GET['id']==1?'disabled':''?> /></td>
            </tr>
            <tr>
              <td>Password:</td>
              <td><input name="password" type="password" size="50" value="<?php echo $_POST['password']?>" /></td>
            </tr>
            <tr>
              <td>Confirm Password:</td>
              <td><input name="pass_confirm" type="password" size="50" value="<?php echo $_POST['password']?>" /></td>
            </tr>
            <tr>
              <td>User Type:</td>
              <td>
				<select name="type" style="width:180px;" <?php echo $_GET['id']==1?'disabled':''?>>
				<?php foreach ($types as $key=>$type) { ?>
				  <option value="<?php echo $key?>" <?php echo $_POST['type']==$key?'selected':''?>><?php echo $type?></option>
				<?php } ?>
				</select>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" name="updateuser" value="Update" />&nbsp;&nbsp;<input type="submit" name="cancel" value="Cancel" /></td>
            </tr>
        </table>
<?php if ($_GET['id'] == 1) { ?>
<input type="hidden" name="login_adm" value="<?php echo $_POST['login']?>" />
<input type="hidden" name="type_adm" value="<?php echo $_POST['type']?>" />
<?php } ?>
</form>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
<?php } ?>
    </table>

  </div>
</div>




<div id="foot_1_form">
  <div id="foot_form">
   	  <div id="foot_tx_form">6th Neuroendoscopy International Federation Congress © Copyright 2010        </div>
  </div>
</div>

</body>
</html>