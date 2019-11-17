<?php
/**
* @author Alexis Sánchez Sanz <alsansa6@gmail.com> 
* @version 2.6.0
* @package trackbag
* @abstract  Clase general de comunicacion con la base de datos MySQLpara usar de plantilla
* @copyright 2019-actualidad, Alexis Sánchez Sanz
*
* Las funciones disponibles son (se recomienda buscarlas para mas información):
* 
* PUBLIC FUNCTIONS
*  __construct
*  __destruct
*  freeQuery
*  getRows
*  setRow
*  searchRows
*  getRowsDetails
*  updateRow
*  eraseRow
*  errors
*  close
*  obtainDistinctValuesFromOneColumn
* 
* PRIVATE FUNCTIONS
*  setRows
*  executeQueryAndSaveResult
*  queryColumns
*  queryForSearching
*  saveMySQLError
*  obtainBooleanColumns
*  obtainColumnNames
*  obtainEnumCases
*/

/*
ini_set("display_errors", 1);
error_reporting(E_ALL);
*/

/*Datos de la tabla a la que hay que conectarse*/
require_once $_SERVER["DOCUMENT_ROOT"].'/locFolders.php';
require_once $LOC_DB_CONFIG."db_config.php";
if (!isset($LOC_DB_CONFIG)) {
  global $LOC_DB_CONFIG;
}

class dbCommunication {
  /* Informacion sobre la base de datos MySQL*/
  private $_valoresPosiblesColumnas= array(); 
  private $_nT="TravelMiss"; //El nombre de la tabla
  private $_errors="";

  /**
  * @abstract
  *   Esta función se ejecuta cuando la variable se crea, y sirve para conectar con la base de datos
  */
  function __construct() {
    // Crear una conexion a la base de datos mediante MySQLi
    $this->_mysqli = mysqli_init();  
    //Cuando se quiere usar un .cnf distinto 
    //$test = $this->_mysqli->options(MYSQLI_EAD_DEFAULT_FILE,'myother.cnf'); 
    //Para hacer la conexion sobre SSL
    $this->_mysqli->ssl_set(NULL,NULL, 'ca.pem',NULL,NULL); 
    $this->_mysqli->real_connect(
      DB_SERVER, 
      DB_USERNAME, 
      DB_PASSWORD, 
      DB_DATABASE,
      DB_PORT,
      NULL,
      MYSQLI_CLIENT_SSL
    );

    // Ajustar los caracteres a utf8, para que se vean correctamente acentos, emojis y demás
    $this->_mysqli->set_charset("utf8mb4");

    // Comprobar que se ha creado correctamente. Si no es así, se acabó lo que se daba
    if ($this->_mysqli->connect_error) {
      $this->saveMySQLError(__METHOD__, $query);
      die("Conexión fallida: " . $this->_errors);
    }

    $this->_valoresPosiblesColumnas = $this->obtainColumnNames($this->_nT);
  }

  /**
  * @abstract
  *   Esta función se ejecuta cuando la variable se destruye, y sirve para hacer reporte de fallos
  */
  function __destruct(){
    if ($this->_errors!=='') {
      /*Report with syslog*/
    }
  }  

  /**
  * @abstract
  *    Esta funcion obtiene registros de la base de datos según una query libre. 
  * @return array|boolean $rows
  */
  public function freeQuery($query) {
    $array_keys = NULL;
    $rows = $this->executeQueryAndSaveResult($query, $array_keys);
    return $rows; 
  }


  /**
  * @abstract
  *    Esta funcion obtiene registros de la base de datos ordenados por la columna elegida de forma ascendente o descendente. Se comprueba que el valor para ordenar sea correcto y en caso de que no lo sea o que se produzca algún fallo en la consulta sql, devuelve false y el error se queda registrado en $this->_errors. Si todo ha ido bien, devuelve los registros en un array. 
  * @return array|boolean $rows
  *  Devuelve un array con la siguiente estructura o false en caso de que algo haya ido mal. (Los errores se guardan en $this->_errors).
  *   array { 
  *     0=> array {
  *         'id'=> string
  *         'version_control'=> string
  *     }
  *   } 
  * @param array $order_by
  *  Nombres de las columnas por la cuales se quieren ordenar los resultados de forma ascendente (asc) o descendente (desc) con la siguiente estructura:
  * array (
  *   'column_name1' => 'ASC',
  *   'column_name2' => 'DESC'
  * )
  * @param array $only_colums
  *  Un array que indica las columnas que se quieren recibir. Si está vacío, se recibiran todas.
  * @param array $specification_array
  *  Un array con la siguiente estructura
  *   array ( 
  *     0=> array (
  *       'column'=> string
  *       'operator'=> string ('=' o '=>' o '<' o ...)
  *       'value'=> mixed
  *     ),
  *     1=> array (
  *       'column'=> string
  *       'operator'=> string ('=' o '=>' o '<' o ...)
  *       'value'=> mixed
  *     ),
  *     ...
  *   ) 
  * @param string|null $array_keys
  *  Con este parámetro se indica si se quiere que el array devuelto tenga alguna clave concreta como índice. En caso de que sea null, se creará un array ordenado de forma numérica
  * @param int|null $limit
  *  Número que indica cual es el límite de resultados que se quieren. Si es null, aparecerán todos los resultados
  */    
  public function getRows(
    $specification_array=array(),
    $order_by=array(),
    $only_columns=array(),
    $array_keys=null,
    $limit=null 
  ) {
    $order_by = (empty($order_by)) ? array('customerId'=>'DESC') : $order_by;
    $rows = array();
    $query = '';
    $query .= 'SELECT ';

    $columns = $this->queryColumns($only_columns);
    $query .= $columns;

    $query .= ' FROM `'.$this->_nT.'`';

    if (!empty($specification_array)) {
      $query .= ' WHERE ';
      if (is_string($specification_array)) {
        $query .= $specification_array;
      } else {
        reset($specification_array); //Ver array_key_first() cuando se use PHP >= 7.3
        $first_index = key($specification_array);
        foreach ($specification_array as $index => $restriction_detail) {
          if ($first_index!==$index) {
            $query.=' AND';
          }
          $query .= ' `'.$restriction_detail['column'].'` ';
          $query .= $restriction_detail['operator'];
          $query .= " '".$restriction_detail['value']."'";
        }
      }
    }  
    $query .= ' ORDER BY ';
    reset($order_by);//Ver array_key_first() cuando se use PHP >= 7.3
    $firstkey = key($order_by);
    foreach ($order_by as $column => $order) {
      if (!in_array($column, $this->_valoresPosiblesColumnas, true)){
        $this->_errors.= " | Error en ".__METHOD__.". El valor para ordenar no era correcto. Era ($column)";
        return false;
      }      
      if ($column!==$firstkey) {
        $query .= ', ';
      }
      $order = strtolower($order);
      $order = ($order==="desc" || $order==="descendente") ? 'DESC' : 'ASC' ;        
      $query .= '`'.$column.'` '.$order;
    }
    $query .= (!is_null($limit)) ? ' LIMIT '.$limit : '' ;
    $query .= '; ';

    $rows = $this->executeQueryAndSaveResult($query, $array_keys);
    return $rows;     
  }

  /**
    * @abstract
    *   Inserta en una tabla los datos de un array de la forma:
    *       array('nombre_de_la_columna'=>'dato_de_la_columna',
    *           'nombre_de_la_columna1'=>'dato_de_la_columna1',
    *           'nombre_de_la_columna2'=>'dato_de_la_columna2',
    *           'nombre_de_la_columna3'=>'dato_de_la_columna3',
    *            ...);
    * @return int|boolean
    *  Devuelve el identificador con el cual se ha guardado o false si no se ha guardado
    * @param array $data_array
    *   array que contiene los datos de la forma:
    *   array('nombre_de_la_columna'=>'dato_de_la_columna',
    *           'nombre_de_la_columna1'=>'dato_de_la_columna1',
    *           'nombre_de_la_columna2'=>'dato_de_la_columna2',
    *           'nombre_de_la_columna3'=>'dato_de_la_columna3',
    *            ...);
    * @param string $table_name
    *  Nombre de la tabla en la cual insertar los datos
  */
  public function setRow($data_array, $table_name=null) {
    $table_name = (is_null($table_name)) ? $this->_nT : $table_name ;
    /**************************************************************************
                  CREAR LA PETICION PARA LA BASE DE DATOS
    **************************************************************************/     
    //Creo la petición que voy a hacerle a la base de datos
    $query = 'INSERT INTO '.$table_name.' ';
    $cols='(';
    $values='(';
    reset($data_array);
    $first_key = key($data_array);
    $possible_columns = $this->obtainColumnNames($table_name);
    foreach ($data_array as $key => $val) {
      if (in_array($key, $possible_columns, true)){
        if ($first_key!==$key) {
          $cols.=', ';
          $values.=', ';
        }
        $cols.= '`'.$key.'`';
        $values.= "'".$val."'";
      } else {
        $this->_errors.= " | Warning ('$key' was not a column in this table) ";
      }
    }
    $cols.=')';
    $values.=')';

    $query.= $cols.' VALUES '.$values.';';
    if ($this->_mysqli->query($query) !== true) {
      $this->saveMySQLError(__METHOD__, $query);
      return false; //Se ha producido algun error en MySQL
    }
    $id = $this->_mysqli->insert_id; //Pedir el id que se ha puesto 
    return $id;
  }

  /**
    * @abstract
    *  Actualiza una fila de la base de datos
    * @return boolean
    *  True si se ha actualizado o false si no se ha guardado
    * @param array $data_array
    *   Contiene los datos a actualizar de la forma:
    *     array(
    *       'nombre_de_la_columna'=>'dato_de_la_columna',
    *       'nombre_de_la_columna1'=>'dato_de_la_columna1',
    *       'nombre_de_la_columna2'=>'dato_de_la_columna2'
    *     );
    * @param string $table_name
    *  Nombre de la tabla en la cual insertar los datos
  */
  public function updateRow($data_array, $specification_array, $table_name=null) {
    $table_name = (is_null($table_name)) ? $this->_nT : $table_name ;
    $query = "UPDATE `".$this->_nT."` SET ";

    reset($data_array);
    $first_key = key($data_array);
    $possible_columns = $this->obtainColumnNames($table_name);
    foreach ($data_array as $key => $val) {
      if (in_array($key, $possible_columns, true)){
        if ($first_key!==$key) {
          $query.=', ';
        }
        $query.= '`'.$key.'`=\''.$val.'\'';
      } else {
        $this->_errors.= " | Warning ('$key' was not a column in this table) ";
      }
    }

    if (!empty($specification_array)) {
      $query .= ' WHERE ';
      if (is_string($specification_array)) {
        $query .= $specification_array;
      } else {
        $itsFirstTime = true;
        foreach ($specification_array as $restriction_detail) {
          if (!$itsFirstTime) {
            $query.=' AND';
          } else {
            $itsFirstTime = false;
          }
          $query .= ' `'.$restriction_detail['column'].'` ';
          $query .= $restriction_detail['operator'];
          $query .= " '".$restriction_detail['value']."'";
        }
      }
    } 

    if ($this->_mysqli->query($query) !== true) {
      $this->saveMySQLError(__METHOD__, $query);
      return false; //Se ha producido algun error en MySQL
    }
    return true;
  }

  /**
  * @abstract
  *  Obtener todos los errores producidos en la variable creada desde que se creó.
  * @return string
  *  Devuelve una string que contiene todos los errores producidos por una variable.
  */
  public function errors() {
    return $this->_errors;
  }

  /**
  * @abstract
  *  Cerrar la conexión MySQL.
  * @return boolean
  *  Devuelve un valor booleano que indica si la conexion se ha cerrado o no
  */
  public function close() {
    return $this->_mysqli->close();
  }

  /**
  * @abstract
  *  Esta función ejecuta y guarda el resultado de forma standard de una query
  * @param string $query
  *  Una cadena de texto que será la solicitud SQL enviada a la base de datos
  * @param string|null $array_keys
  *  Con este parámetro se indica si se quiere que el array devuelto tenga alguna clave concreta como índice. En caso de que sea null, se creará un array ordenado de forma numérica
  * @return array $rows
  *  Array que contiene arrays de los valores de la query, con los nombres de las columnas como key y los valores como values
  */
  private function executeQueryAndSaveResult($query, $array_keys=null) {
    $rows = array();
    $todoOK = $this->_mysqli->real_query($query); //Realizamos la peticion
    if ($todoOK!==true) {
      $this->saveMySQLError(__METHOD__, $query);
      return false;
    }            
    $res = $this->_mysqli->use_result(); //guardamos el resultado 
    while ($fila = $res->fetch_array(MYSQLI_ASSOC)) {
      if (!is_null($array_keys)) {
        $rows[$fila[$array_keys]] = $fila;
      } else {
        array_push($rows, $fila);
      }
    }
    $res->free();
    return $rows;
  }

  /**
  * @abstract
  *  Obtiene los valores en una string de las columnas.
  * @return string
  *  Devuelve una string que contiene las columnas separadas por comas.
  */
  private function queryColumns($columns_array){
    $columns = '';
    if (empty($columns_array)) {
      $columns .= '*';   
    } else {
      reset($data_array);
      $first_index = key($columns_array);
      foreach ($columns_array as $index => $column) {
        if ($first_index!==$index) {
          $columns .= ', ';                        
        }
        $columns .= $column;
      }
    }
    return $columns;
  }

  /**
  * @abstract
  *  Guarda un error de MySQL en la propia variable
  * @param $context
  *  Dónde (documento, o carpeta, o directorio....) se encontraba el código cuando falló
  * @param $sql_query
  *  Petición a la base de datos que se había realizado
  * @return void
  */
  private function saveMySQLError($context, $sql_query=""){
    $this->_errors.= '||Error in '.__FILE__.'<br>'.$context.', class: '.__CLASS__;
    $this->_errors.= '<br>Error code ('.$this->_mysqli->errno.'): '.$this->_mysqli->error;
    $this->_errors.= "<br>Query was: $sql_query<br><br>";
  }

  /**
  * @abstract
  *  Obtiene un array con los nombres de las columnas de una tabla.
  * @param string $table_name
  *  Nomnre de la tabla de la cual se quieren obtener los nombres de sus columnas
  * @return array $columnNames
  *  Devuelve un array que contiene los nombres de las columnas de la tabla indicada
  */
  private function obtainColumnNames($table_name){
    $columnNames = array();
    $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' and TABLE_SCHEMA != 'information_schema'";
    $todoOK = $this->_mysqli->real_query($query); 
    if ($todoOK!==true) {
      $this->saveMySQLError(__METHOD__, $query);
      die('Imposible recabar la informnación de las columnas de la tabla');
    }
    $res = $this->_mysqli->use_result();
    while ($fila = $res->fetch_array(MYSQLI_ASSOC)) {
      array_push($columnNames, $fila['COLUMN_NAME']); 
    }
    $res->free();
    return $columnNames;
  }

  /**
  * @abstract
  *   Obtiene los posibles valores de una enumeración disponibles en la base de datos
  * @return variying array|false|Exception
  *   Devuelve un array con las opciones disponibles de la enumeración de la columna dada si todo ha ido bien, un error false si halgo ha fallado con la base de datos o una axcepción si se ha producido alguna.
  * @param string $column_name
  *  Nombre de la columna que es una enumeración de la cual se quieren obtener los valores que son posibles
  */
  private function obtainEnumCases($column_name) {
    try {
      $query = 'SHOW COLUMNS FROM '.$this->_nT.' LIKE "'.$column_name.'"';
      $todoOK=$this->_mysqli->real_query($query); //Realizamos la solicitud de arriba
      if ($todoOK) {
        $res = $this->_mysqli->use_result(); //guardamos el resultado de la solicitud como un objeto
        $resArray = mysqli_fetch_array($res); 
        $res->free();
        $cadena = substr($resArray[1], 5); //Quito el -"set(-
        $longitud_cadena = strlen($cadena);
        $cadena = substr($cadena, -$longitud_cadena, $longitud_cadena-2); //quito el -)"- del final
        $cadena = preg_replace("/'/", "", $cadena); //Elimino las -'- (comillas simples)
        return explode(',', $cadena);
      } else {
        $this->saveMySQLError(__METHOD__, $query);
      }
    } catch (Exception $e) {
      $this->_errors.= " | Excepción producida en obtainEnumCases: ".$e;
      return false; 
    }
    return false;
  }

  /**
  * @abstract
  *   Obtiene los posibles valores distintos de una columna disponibles en la base de datos
  * @return variying array|false
  *   Devuelve un array con llos valores distintos de la columna dada si todo ha ido bien o un error false si algo ha fallado con la base de datos.
  * @param string $column_name
  *  Nombre de la columna de la cual se quieren obtener los valores distintos que se encientran en la base de datos
  */
  public function obtainDistinctValuesFromOneColumn($column_name) {
    $query = 'SELECT DISTINCT `'.$column_name.'` AS "distinct_values" FROM `'.$this->_nT.'`';
    if ($this->_mysqli->real_query($query) !== true) {
      $this->saveMySQLError(__METHOD__, $query);
      return false;
    }
    $distinct_values = array();
    $res = $this->_mysqli->use_result();
    while ($fila = $res->fetch_array(MYSQLI_ASSOC)) {
      array_push($distinct_values, $fila['distinct_values']); 
    }    
    $res->free();
    return $distinct_values;
  }

}