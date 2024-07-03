<?php
  require_once(dirname(__FILE__)."/config.inc.php");
  require_once(dirname(__FILE__)."/mysqli_functions.inc.php");

	if ( !isset($db) || !$db->ping() )
	{
		$db = DataBase::makeConnection(DB_HOST, DB_USER, DB_PASSWD, DB_DATABASE);
		if ($db->connect_error)
			die('Error de Conexión ('.$db->connect_errno.')'.$db->connect_error);

		$db->query("SET NAMES 'utf8'");
	}
  //include_once(dirname(__FILE__)."/db_functions.inc.php");
?>
