<?php
// Datos de la conexión a la base de datos
define("DB_HOST", '204.93.216.11');
define("DB_USER", 'chamery0_testusr');
define("DB_PASSWD", 'pass@123');
define("DB_DATABASE", 'chamery0_jornadas2');

// Datos del servidor
define("SERVER", "localhost");

// Directorios de instalación
define("INDEX_PATH", "");	
define("GESTOR_PATH", "");


// Prefijo de las tablas de la base de datos
define("DB_PREFIX", "admin_");

// Tablas de la base de datos
define("TBL_USUARIO", DB_PREFIX . "usuario");
define("TBL_TIPO_USUARIO", DB_PREFIX . "tipo_usuario");
define("TBL_GRUPO", DB_PREFIX . "grupo");
define("TBL_SITIO", DB_PREFIX . "sitio");
define("TBL_REGISTROS", "registros");
define("TBL_CONTADOR", DB_PREFIX . "contador");
define("TBL_CONTADOR_IP", DB_PREFIX . "contadorIP");

// Directorios  y permisos
define("DIR_USUARIO", "usuario");

// Títulos de página
define("TIT_USUARIO", "Usuarios");
?>
<?php
  require_once(dirname(__FILE__)."/mysqli_functions.inc.php");
  require_once(dirname(__FILE__)."/db_connect.inc.php");
  //include_once(dirname(__FILE__)."/db_functions.inc.php");
?>