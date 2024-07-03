<?php
  include_once(dirname(__FILE__)."/config.inc.php");
  include_once(dirname(__FILE__)."/db_connect.inc.php");
/*
 * db_funcs.inc.php
 * 
 * $link es una variable global que tiene el enlace de la base de datos, queda definida en el archivo conectadb.inc.php
 */


/*
 * Ejecuta una consulta
 *
 * Parámetros:
 *  query: el SQL de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: un recurso
 *  Error: FALSE
 */
function db_query($query, $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$res = $enlace->query($query);
   
   if ($error = $enlace->error) {
      echo("FUNCTION: db_query()<br/>ERROR: $error<br/>QUERY: $query");
	}
   
   return $res;
}


/*
 * Cierra una conexión
 *
 * Parámetros:
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: TRUE
 *  Error: FALSE
 */
function db_close($enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$enlace->close();
   
   if ($error = $enlace->error) {
      echo("FUNCTION: db_close()<br/>ERROR: $error");
      return FALSE;
	} else {
      return TRUE;
   }
}


/*
 *	Obtiene el valor del campo de una tabla	
 *
 * Parámetros:
 *  field: el campo de la tabla
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: el valor del campo, si se obtienen más de 1 resultado, regresa sólo el primero.
 *  Error: FALSE
*/
function db_get_value($field, $table, $condition = "", $order = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	if ($condition != "") {
		$condition = "WHERE $condition";
	}
	
	if ($order != "") {
		$order = "ORDER BY $order";
	}
	
   $query = "SELECT $field FROM $table $condition $order LIMIT 1";
   
	$res = $enlace->query($query);
	$row = $res->fetch_assoc();
	
   if ($error = $enlace->error) {
      echo("FUNCTION: db_get_value()<br/>ERROR: $error<br/>QUERY: $query");	
      return FALSE;
	} else {
      return $row[$field];
   }
}


/*
 *	Obtiene valores del campo de una tabla
 *
 * Parámetros:
 *  field: el campo de la tabla
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: una matriz unidimensional con el valor o los valores
 *  Error: FALSE
 */
function db_get_values($field, $table, $condition = "", $order = "", $distintc = false, $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$values = array();
	
	if ($condition != "") {
		$condition = "WHERE $condition";
	}
	if ($order != "") {
		$order = "ORDER BY $order";
	}
	
	if ( $distintc ) {
	  $query = "SELECT DISTINCT $field FROM $table $condition $order";
	} else {
	  $query = "SELECT $field FROM $table $condition $order";
	}
   
	$res = $enlace->query($query);
	while ($row = $res->fetch_assoc()) {
		$values[] = $row[$field];
	}
	
   if ($error = $enlace->error) {
      echo("FUNCTION: db_get_values()<br/>ERROR: $error<br/>QUERY: $query");
      return FALSE;
	} else {
      return $values;
   }	
}


/*
 *	Obtiene el registro de una tabla
 *
 * Parámetros:
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: un arreglo asociativo con los valores del registro
 *  Error: FALSE
 */
function db_get_row($table, $condition = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}

	if ($condition != "") {
		$condition = "WHERE $condition";
	}
	
  $query = "SELECT * FROM $table $condition";
   
	$res = $enlace->query($query);
	if ($row = $res->fetch_assoc()) {
		return $row;
	}
   
   if ($error = $enlace->error) {
      echo("FUNCTION: db_get_row()<br/>ERROR: $error<br/>QUERY: $query");
	}
   
   return FALSE;
}


/*
 *	Obtiene registros de una tabla
 *
 * Parámetros:
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
function db_get_rows($table, $condition = "", $order = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$values = array();

	if ($condition != "") {
		$condition = "WHERE $condition";
	}
	if ($order != "") {
		$order = "ORDER BY $order";
	}
	
   $query = "SELECT * FROM $table $condition $order";
   
	$res = $enlace->query($query);
	while ($row = $res->fetch_assoc()) {
		$values[] = $row;
	}

   if ($error = $enlace->error) {
      echo("FUNCTION: db_get_rows()<br/>ERROR: $error<br/>QUERY: $query");
      return FALSE;
	} else {
      return $values;
   }
}


function db_get_rows_fields($fields, $table, $condition="", $order="", $enlace="") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$values = array();
	
	if ($condition != "") {
		$condition = "WHERE $condition";
	}
	if ($order != "") {
		$order = "ORDER BY $order";
	}
  
  $res = $enlace->query("SELECT " . implode(",", $fields) . " FROM $table $condition $order", $enlace);
  while ($row = $res->fetch_assoc($result)) {
    $values[] = $row;
  }

	return $values;
}


/*
 *	Obtiene n registros de una tabla
 *
 * Parámetros:
 *  table: la tabla 
 *  first: el número del primer registro deseado del resultado
 *  length: el número máximo de registros por obtener
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
function db_get_nrows($table, $first, $length, $condition = "", $order = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}

	$values = array();
		
	if ($condition != "") {
		$condition = "WHERE $condition";
	}
   if ($order != "") {
		$order = "ORDER BY $order";
	}
	
   $query = "SELECT * FROM $table $condition $order LIMIT $first, $length";
   
	$res = $enlace->query($query);
	while ($row = $res->fetch_assoc()) {
      $values[] = $row;
	}
	
	if ($error = $enlace->error) {
      echo("FUNCTION: db_get_nrows()<br/>ERROR: $error<br/>QUERY: $query");
      return FALSE;
	} else {
      return $values;
   }
}

function db_get_nrows_fields($fields, $table, $first, $length, $condition = "", $order = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}

	$values = array();
		
	if ($condition != "") {
		$condition = "WHERE $condition";
	}
   if ($order != "") {
		$order = "ORDER BY $order";
	}
	
   $query = "SELECT " . implode(",", $fields) . " FROM $table $condition $order LIMIT $first, $length";
   
	$res = $enlace->query($query);
	while ($row = $res->fetch_assoc()) {
      $values[] = $row;
	}
	
	if ($error = $enlace->error) {
      echo("FUNCTION: db_get_nrows_fields()<br/>ERROR: $error<br/>QUERY: $query");
      return FALSE;
	} else {
      return $values;
   }
}


/*
 *	Obtiene registros de la relación de 2 o más tablas
 *
 * Parámetros:
 *  fields_str: los campos de las tablas separados por comas, ejemplo: t1.campo1, t2.campo2
 *  tables: las tablas separadas por comas, ejemplo: tabla1 AS t1, tabla2 AS t2
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
function db_get_rows_mult($fields_str, $tables, $condition, $order = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$fields = explode(",", $fields_str);
	$values = array();
	
	if ($order != "") {
		$order = "ORDER BY $order";
	}
	
   $query = "SELECT $fields_str FROM $tables WHERE $condition $order";
   
	$res = $enlace->query($query);
	while ($row = $res->fetch_assoc()) {
		$values[] = $row;
	}
	
   if ($error = $enlace->error) {
      echo("FUNCTION: db_get_rows_mult()<br/>ERROR: $error<br/>QUERY: $query");
      return FALSE;
	} else {
      return $values;
   }
}


/*
 *	Obtiene n registros de la relación de 2 o más tablas
 *
 * Parámetros:
 *  fields_str: los campos de las tablas separados por comas, ejemplo: t1.campo1, t2.campo2
 *  tables: las tablas separadas por comas, ejemplo: tabla1 AS t1, tabla2 AS t2
 *  condition: la condicion de la consulta 
 *  first: el número del primer registro deseado del resultado
 *  length: el número máximo de registros por obtener 
 *  order: el orden del resultado de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
function db_get_nrows_mult($fields_str, $tables, $condition, $first, $length, $order = "", $enlace = "") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	$values = array();
	
   if ($order != "") {
		$order = "ORDER BY $order";
	}
	
   $query = "SELECT $fields_str FROM $tables WHERE $condition $order LIMIT $first, $length";
   
	$res = $enlace->query($query);
	while ($row = $res->fetch_assoc()) {
      $values[] = $row;
	}
	
	if ($error = $enlace->error) {
      echo("FUNCTION: db_get_nrows_mult()<br/>ERROR: $error<br/>QUERY: $query");
      return FALSE;
	} else {
      return $values;
   }
}


/*
 * Verifica que exista una cuenta de usuario
 *
 * Parámetros:
 *  table: la tabla de la base de datos
 *  login: el nombre de usuario
 *  password: la contraseña
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: un arreglo asociativo del registro de la base de datos de la cuenta
 *  Error: FALSE
 * 
 */
function login($table, $login, $password, $enlace="") {
 	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}

   $row = db_get_row($table, "login='$login' AND DECODE(password, 'acceso')='$password'", $enlace);
   if (count($row) > 0) {
      return $row;
   } else {
      return FALSE;
   }
}


/*
 * Cuenta el número de registros en una tabla
 *
 * Parámetros:
 *  table: la tabla de la base de datos
 *  condition: la condición de la consulta
 *  enlace: enlace de la base de datos
 *
 * Regresa:
 *  Éxito: el número de registros
 *  Error: FALSE
 */
function db_count($table, $condition="", $enlace="") {
	global $link;
	
	if ($enlace == "") {
		$enlace = $link;
	}
	
	if ($condition != "") {
		$condition = "WHERE $condition";
	}
   
	$query = "SELECT COUNT(*) AS n FROM $table $condition";
   
	$num_registros = 0;
	$res = $enlace->query($query);
	if ($res) {
		$row = $res->fetch_assoc();
		$num_registros = (int)$row['n'];
	}
   
	if ($error = $enlace->error) {
		echo("FUNCTION: db_count()<br/>ERROR: $error<br/>QUERY: $query");
		return FALSE;
	} else {
		return $num_registros;
	}
}


function can_delete($owner, $module) {
   $group = db_get_value("id_grupo", TBL_USUARIO, "id=$owner");
   if ( ($owner == $_SESSION['sgid_usuario']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x800) ||
		($group == $_SESSION['sgid_grupo']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x080) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x008) ) {
         
         return TRUE;
         
   } else {
      return FALSE;
   }
}


function can_add($module) {
   if ( (hexdec($_SESSION['sgpermisos'][$module]) & 0x200) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x020) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x002) ) {
      
         return TRUE;
         
   } else {
         return FALSE;
   }
}


function can_update($owner, $module) {
   $group = db_get_value("id_grupo", TBL_USUARIO, "id=$owner");
   if ( ($owner == $_SESSION['sgid_usuario']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x400) ||
		($group == $_SESSION['sgid_grupo']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x040) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x004) ) {
      return TRUE;
   } else {
      return FALSE;
   }
}
?>
