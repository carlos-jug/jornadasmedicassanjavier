<?php require_once(dirname(__FILE__)."/config.inc.php");?>
<?php
/*
 * mysqli_functions.inc.php
 */

class DataBase extends mysqli
{
	private static $Connection;

/*
 * Contructor, genera la conexion a la base de datos
 *
 * Sera privado y se imposibilitara su uso comun
 * para no generar multiples conexiones a la
 * base de datos utilizando el metodo Singleton
 *
 * Parámetros:
 *  host: el servidor donde esta alojada la base de datos
 *  user: el nombre de usario para la conexion
 *  password: la contraseña para la conexion
 *  database: nombre de la base de datos
 *
 */

	private function __construct($host, $user, $password, $database)
	{
    	parent::__construct($host, $user, $password, $database);
    }
/*
 * makeConnection utiliza el metodo Singleton con una
 * variable STATIC para generar la instancia unica, 
 * verificando que no exista una instancia previa de
 * la clase, si esta existiera regresa a la misma
 * instancia ya creada pero si no genera una nueva
 */
	public static function makeConnection($host, $user, $password, $database)
	{
		if ( !self::$Connection instanceof self )
			self::$Connection = new self($host, $user, $password, $database);

		return self::$Connection;
	}

/*
 * Seguridad para evitar que se genere una nueva
 * instancia forzada con las funciones CLONE o UNSERIALIZE
 */

	public function __clone()
	{
		trigger_error("Invalid Operation: Can't make a clone of ". get_class($this) ." class.", E_USER_ERROR);
	}

	public function __wakeup()
	{
		trigger_error("Invalid Operation: Can't unserialize an instance of ". get_class($this) ." class.");
	}

/*
 * Ejecuta una consulta
 *
 * Parámetros:
 *  query: el SQL de la consulta
 *	params: Array bidimensional que contiene los parametros para la consulta teniendo como KEY del array superior el tipo de datos
 *			y el subarreglo conteniendo cada dato.
 *		Sintaxis:	array('TipoDeDatos'=>array('Dato1','Dato2','Dato3'...))
 *		string TipoDeDatos: i - integer, d - double, s - string, b - blob
 *				ejemplo para enviar 2 datos string y 1 integer: 'ssi'
 *		(params sera un parametro opcional en todas las funciones de consulta siguientes con esta misma sintaxis)
 *
 * Regresa:
 *  Éxito: un recurso
 *  Error: FALSE
 */
	function pquery($query, $params = '')
	{
		$res = NULL;
		if ( $consult = $this->prepare($query) )
		{
			if ( $params )
			{
				$typeDef = key($params);
				$bindParams = $params[$typeDef];
				foreach($bindParams as $key => $value)
					$bindParamsReferences[$key] = &$bindParams[$key];
				array_unshift($bindParamsReferences,$typeDef);
				$bindParamsMethod = new ReflectionMethod('mysqli_stmt','bind_param');
				$bindParamsMethod->invokeArgs($consult,$bindParamsReferences);
			}
			$consult->execute();
			if ( $error = $consult->error )
				echo("FUNCTION: pquery()<br/>ERROR: {$error}<br/>QUERY: {$query}<br/>PARAMS: {$params}");
			else
			{
				if ( !$res = $consult->get_result() )
					$res = TRUE;
			}
			$consult->close();
		}
		else
			echo("FUNCTION: pquery()<br/>ERROR: No pudo prepararse la consulta<br/>QUERY: $query");
   
		return $res;
	}


/*
 * Obtiene el valor ID del ultimo registro agregado
 *
 *
 * Regresa:
 *  Éxito: un ID
 *  Error: FALSE
 */
	function insert_id()
	{
		return $this->insert_id;
	}


/*
 *	Obtiene el valor del campo de una tabla	
 *
 * Parámetros:
 *  field: el campo de la tabla
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *
 * Regresa:
 *  Éxito: el valor del campo, si se obtienen más de 1 resultado, regresa sólo el primero.
 *  Error: FALSE
*/
	function get_value($field, $table, $condition = '', $order = '', $params = '')
	{
		if ( $condition != '' )
			$condition = "WHERE $condition";
		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT $field FROM $table $condition $order LIMIT 1";

		$res = $this->pquery($query,$params);
		$row = $res->fetch_assoc();

		if ( $error = $this->error )
		{
			echo("FUNCTION: get_value()<br/>ERROR: $error<br/>QUERY: $query");	
			return FALSE;
		}
		else
			return $row[$field];
	}


/*
 *	Obtiene valores del campo de una tabla
 *
 * Parámetros:
 *  field: el campo de la tabla
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *  distintc: si se obtendran solo resultados distintos (por default, false, obtendra todos)
 *
 * Regresa:
 *  Éxito: una matriz unidimensional con el valor o los valores de un solo campo
 *  Error: FALSE
 */
	function get_values($field, $table, $condition = '', $order = '', $params = '', $distintc = false)
	{
		$values = array();

		if ( $condition != '' )
			$condition = "WHERE $condition";
		if ( $order != '' )
			$order = "ORDER BY $order";

		if ( $distintc )
			$query = "SELECT DISTINCT $field FROM $table $condition $order";
		else
			$query = "SELECT $field FROM $table $condition $order";

		$res = $this->pquery($query,$params);
		while ( $row = $res->fetch_assoc() )
			$values[] = $row[$field];
	
		if ( $error = $this->error )
		{
			echo("FUNCTION: get_values()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $values;
	}


/*
 *	Obtiene el registro de una tabla
 *
 * Parámetros:
 *  table: la tabla
 *  condition: la condicion de la consulta
 *
 * Regresa:
 *  Éxito: un arreglo asociativo con los valores del registro
 *  Error: FALSE
 */
	function get_row($table, $condition = '', $params = '')
	{
		if ( $condition != '' )
			$condition = "WHERE $condition";

		$query = "SELECT * FROM $table $condition";

		$res = $this->pquery($query,$params);
		if ( $row = $res->fetch_assoc() )
			return $row;

		if ( $error = $this->error )
			echo("FUNCTION: get_row()<br/>ERROR: $error<br/>QUERY: $query");

		return FALSE;
	}


/*
 *	Obtiene registros de una tabla
 *
 * Parámetros:
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
	function get_rows($table, $condition = '', $order = '', $params = '')
	{
		$values = array();

		if ( $condition != '' )
			$condition = "WHERE $condition";
		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT * FROM $table $condition $order";

		$res = $this->pquery($query,$params);
		while ( $row = $res->fetch_assoc() )
			$values[] = $row;

		if ( $error = $this->error )
		{
			echo("FUNCTION: get_rows()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $values;
	}


/*
 *	Obtiene los campos especificados de los registros de una tabla
 *
 * Parámetros:
 *  fields: array de campos a seleccionar ej. array(campo1,campo2,...)
 *  table: la tabla
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores de los campos solicitados
 *  Error: FALSE
 */
	function get_rows_fields($fields, $table, $condition = '', $order = '', $params = '')
	{
		$values = array();

		if ( $condition != '' )
			$condition = "WHERE $condition";
		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT " . implode(',', $fields) . " FROM $table $condition $order";

		$res = $this->pquery($query,$params);
		while ($row = $res->fetch_assoc($result))
			$values[] = $row;

		if ( $error = $this->error )
		{
			echo("FUNCTION: get_rows_fields()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
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
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
 	function get_nrows($table, $first, $length, $condition = '', $order = '', $params = '')
	{
		$values = array();

		if ( $condition != '' )
			$condition = "WHERE $condition";
		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT * FROM $table $condition $order LIMIT $first, $length";

		$res = $this->pquery($query,$params);
		while ( $row = $res->fetch_assoc() )
			$values[] = $row;

		if ( $error = $this->error )
		{
			echo("FUNCTION: get_nrows()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $values;
	}


/*
 *	Obtiene los campos especificos de n registros de una tabla
 *
 * Parámetros:
 *  fields: campos a seleccionar
 *  table: la tabla 
 *  first: el número del primer registro deseado del resultado
 *  length: el número máximo de registros por obtener
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores de los campos solicitados
 *  Error: FALSE
 */
	function get_nrows_fields($fields, $table, $first, $length, $condition = '', $order = '', $params = '')
	{
		$values = array();

		if ( $condition != '' )
			$condition = "WHERE $condition";
		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT " . implode(',', $fields) . " FROM $table $condition $order LIMIT $first, $length";

		$res = $this->pquery($query,$params);
		while ( $row = $res->fetch_assoc() )
			$values[] = $row;

		if ( $error = $this->error )
		{
			echo("FUNCTION: get_nrows_fields()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $values;
	}


/*
 *	Obtiene registros de la relación de 2 o más tablas
 *
 * Parámetros:
 *  fields_str: los campos de las tablas separados por comas, ejemplo: t1.campo1, t2.campo2
 *  tables: las tablas separadas por comas, ejemplo: tabla1 AS t1, tabla2 AS t2
 *  condition: la condicion de la consulta
 *  order: el orden del resultado de la consulta
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
	function get_rows_mult($fields_str, $tables, $condition, $order = '', $params = '')
	{
		$fields = explode(',', $fields_str);
		$values = array();

		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT $fields_str FROM $tables WHERE $condition $order";

		$res = $this->pquery($query,$params);
		while ( $row = $res->fetch_assoc() )
			$values[] = $row;

		if ( $error = $this->error )
		{
			echo("FUNCTION: get_rows_mult()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $values;
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
 *
 * Regresa:
 *  Éxito: una matriz bidimensional asociativa con los valores
 *  Error: FALSE
 */
	function get_nrows_mult($fields_str, $tables, $condition, $first, $length, $order = '', $params = '')
	{
		$values = array();

		if ( $order != '' )
			$order = "ORDER BY $order";

		$query = "SELECT $fields_str FROM $tables WHERE $condition $order LIMIT $first, $length";

		$res = $this->pquery($query,$params);
		while ( $row = $res->fetch_assoc() )
			$values[] = $row;
	
		if ( $error = $this->error )
		{
			echo("FUNCTION: get_nrows_mult()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $values;
	}


/*
 * Cuenta el número de registros en una tabla
 *
 * Parámetros:
 *  table: la tabla de la base de datos
 *  condition: la condición de la consulta
 *
 * Regresa:
 *  Éxito: el número de registros
 *  Error: FALSE
 */
	function count($table, $condition = '', $params = '')
	{
		if ( $condition != '' )
			$condition = "WHERE $condition";

		$query = "SELECT COUNT(*) AS n FROM $table $condition";

		$num_registros = 0;
		$res = $this->pquery($query,$params);
		if ( $res )
		{
			$row = $res->fetch_assoc();
			$num_registros = (int)$row['n'];
		}

		if ( $error = $this->error )
		{
			echo("FUNCTION: count()<br/>ERROR: $error<br/>QUERY: $query");
			return FALSE;
		}
		else
			return $num_registros;
	}


/*
 * Verifica permisos de una cuenta de usuario
 *
 * Parámetros:
 *  owner: ID en base de datos del usuario.
 *  module: Modulo del gestor al que se desea verificar permisos.
*
 * Regresa:
 *  Éxito: TRUE, tiene permisos suficientes
 *  Error: FALSE, no tiene permisos suficientes
 * 
 */
	function can_delete($owner, $module)
	{
		$group = $this->get_value("id_grupo", TBL_USUARIO, "id={$owner}");
		if (
		($owner == $_SESSION['sgid_usuario']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x800) ||
		($group == $_SESSION['sgid_grupo']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x080) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x008)
		)
		{
			return TRUE;
		}
		else
			return FALSE;
	}

	function can_add($module)
	{
		if (
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x200) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x020) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x002)
		)
		{
			return TRUE;
		}
		else
			return FALSE;
	}

	function can_update($owner, $module)
	{
		$group = $this->get_value("id_grupo", TBL_USUARIO, "id={$owner}");
		if (
		($owner == $_SESSION['sgid_usuario']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x400) ||
		($group == $_SESSION['sgid_grupo']) && (hexdec($_SESSION['sgpermisos'][$module]) & 0x040) ||
		(hexdec($_SESSION['sgpermisos'][$module]) & 0x004)
		)
		{
			return TRUE;
		}
		else
			return FALSE;
	}

}
?>
<?php require_once(dirname(__FILE__)."/db_connect.inc.php");?>