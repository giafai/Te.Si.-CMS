<?php
/************************************************************************
  			conn.php - Copyright giafai


**************************************************************************/


/**
 * class conn
 * 
 */
class conn
{

	/** Aggregations: */

	/** Compositions: */

	/*** Attributes: ***/

	/**
	 * 
	 * @access private
	 */
	var $dbname;
	/**
	 * 
	 * @access private
	 */
	var $dbhost;
	/**
	 * 
	 * @access private
	 */
	var $dbuser;
	/**
	 * 
	 * @access private
	 */
	var $dbpwd;
	/**
	 * 
	 * @access private
	 */
	var $dbtipo;
	/**
	 * 
	 * @access private
	 */
	var $connessione;
	/**
	 * 
	 * @access private
	 */
	var $q; //la query in sql
	/**
	 * 
	 * @access private
	 */
	var $result; //conterr� il risultato

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function __construct( )
	{
//	require_once('./includes/config.define.inc.php');
		global $dbname, $dbhost, $dbuser, $dbpass, $dbtipo;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpwd  = $dbpass;
		$this->dbtipo = $dbtipo;
		
		$this->connect();
		
	} // end of member function _construct
	
	function __destruct  ()
	{
	//	$this->
	}

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function connect( )
	{
			switch($this->dbtipo){
				case "MySql":
					$cn = mysql_connect($this->dbhost, $this->dbuser , $this->dbpwd) or Die("Non � stato possibile connettersi al Database. Si � verificato l'errore ".mysql_errno());
					$sl = mysql_select_db ( $this->dbname);
					if ($sl == false){
						echo mysql_error();
						registraError("connect", mysql_error());
						exit;
					}
				break;
				case "MsSql":
					$cn = mssql_connect($this->host, $this->user , $this->pwd); // or Die("Errore di connessione al Server SQL");
	//	@mssql_select_db ( $this->dbname);
				break;
				case "PostgreSql":
//		echo "Funzionalit� non ancora testata";
//	$cn = pg_connect ("dbname='' user={$this->user} password={$this->pwd}");
				break;
				case "Oracle":
					echo "Funzionalit� non ancora realizzata";
	//	@oracle_connect($this->host, $this->user , $this->pwd); // or Die("Errore di connessione al Server SQL");
	//	@oracle_select_db ( $this->dbname);
				break;
				default:
					echo "Errore Connect: non � stato impostato il tipo di DataBase a cui collegarsi. E' necessario impostare il parametro corretto nel file di configurazione config.define.inc.php";
					exit;
				break;
			}
		if ($cn== false)
			return false;
	} // end of member function connect

	/**
	 * 
	 *
	 * @param int query 
	 * @return void
	 * @access public
	 */
	function exec_query( $query )
	{
		switch($this->dbtipo){
			case "MySql":
				$this->result = @mysql_query($query);

				if($this->result==false){
					echo "Errore nella query: $query";
					echo mysql_error();
					registraError("exec_query", mysql_error(), $query);
				}
			break;
			case "MsSql":
				return mysql_query($query);
			break;
			case "PostgreSql":
				return pg_query($query);
			break;
			case "Oracle":
				// $this->connessione rappresenta il cursore, non la connessione!!
				return ora_do($this->connessione, $query);
			break;
		}
	} // end of member function exec_query

	/**
	 * 
	 *
	 * @param int tipo S=select I=insert U=update D=delete
	 * @param array table Tabella/e su cui lavorare, � un array
	 * @param array column Array delle colonne su cui operare con: Tipo=S => i campi da selezionare Tipo=I
=> i campi da inserire Tipo=U => i campi da aggiornare, array nella forma ('colonna1 = valore1','colonna2 = valore2')
Tipo=D => il valore � ignorato
	 * @param array where con Tipo=S => le condizioni per selezionare (string) Tipo=I => i valori da
inserire (Array) Tipo=U => le condizioni per aggiornare i record
(Array) Tipo=D => le condizioni per eliminare i record
	 * @param array order Valido solo con Tipo=S Rappresenta l'ordine dei record selezionati
	 * @param array limit Valido solo con Tipo=S Limita la query ad un numero determinato di righe $limit(valoreInizio, valoreFine)
	 * @return void
	 * @access public
	 */
	function query( $tipo,  $table,  $column,  $where,  $order ='', $limit = '' )
	{
		switch($this->dbtipo){
			case "MySql":
				$q = $this->myQuery( $tipo,  $table,  $column,  $where,  $order, $limit );
			break;
			case "MsSql":
				$q = $this->msQuery( $tipo,  $table,  $column,  $where,  $order, $limit );
			break;
			case "PostgreSql":
				$q = $this->pgQuery( $tipo,  $table,  $column,  $where,  $order, $limit );
			break;
			case "Oracle":
				$q = $this->oraQuery( $tipo,  $table,  $column,  $where,  $order, $limit );
			break;
		}
		$this->q = $q;
		$this->exec_query($q);
	} // end of member function query



	/**
	 * 
	 *
	 * @param int query 
	 * @return void
	 * @access public
	 */
	function fetch_array( )
	{
		switch($this->dbtipo){
			case "MySql":
				if( $this->result == false ){
				echo mysql_error();
					registraError("fetch_array", mysql_error(), $this->getQuery());
				}
				$r = @mysql_fetch_array($this->result);
			break;
			case "MsSql":
				return mysql_query($query);
			break;
			case "PostgreSql":
				return pg_query($query);
			break;
			case "Oracle":
				// $this->connessione rappresenta il cursore, non la connessione!!
				return ora_do($this->connessione, $query);
			break;
		}
		return $r;
	} // end of member function fetch_array

    
	/**
	 * 
	 *
	 * @param int query 
	 * @return void
	 * @access public
	 */
	function fetch_row( )
	{
		switch($this->dbtipo){
			case "MySql":
			if( $this->result == false ){
				echo mysql_error();
					registraError("fetch_row", mysql_error(), $this->query);
				}
				$r = mysql_fetch_row($this->result);
			break;
			case "MsSql":
				return mysql_query($query);
			break;
			case "PostgreSql":
				return pg_query($query);
			break;
			case "Oracle":
				// $this->connessione rappresenta il cursore, non la connessione!!
				return ora_do($this->connessione, $query);
			break;
		}
		return $r;
	} // end of member function exec_query
	
	function fetch(){
		return $this->fetch_array();
	}

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function myQuery( $tipo,  $table,  $column,  $where,  $order, $limit )
	{
		switch($tipo){
			case "S":
				$q = "SELECT ";
				if($column == ""){
					$q .= "*";
				} else {
					$i = 0;
					foreach( $column as $value ){
						$q .= ($i > 0) ? ", " : "";
						$q .= $value;
						$i++;
					}
				}
				
				$q .= " FROM ";
				$i = 0;
				foreach( $table as $value ){
					$q .= ($i > 0) ? ", " : "";
					$q .= $value;
					$i++;
				}
				
				if($where == ""){
					$q .= "";
				} else {
					$q .= " WHERE ";
					foreach( $where as $value ){
						$q .= $value;
					}
				}
				
				if($order == ""){
					$q .= "";
				} else {
					$q .= " ORDER BY ";
					foreach( $order as $value ){
						$q .= $value;
					}
				}
				
				if($limit == ""){
					$q .= "";
				} else {
					$q .= " LIMIT {$limit[0]},{$limit[1]}";
				}
			break;
			case "I":
				$q = "INSERT INTO ";
				$i = 0;
				foreach( $table as $value ){
					$q .= ($i > 0) ? ", " : "";
					$q .= "`".$value."`";
					$i++;
				}
				
				$q .= " (";
				if($column == ""){
					$q .= "";
				} else {
					$i = 0;
					foreach( $column as $value ){
						$q .= ($i > 0) ? "," : "";
						$q .= "`".$value."`";
						$i++;
					}
				}
				$q .= ") VALUES(";
				
				
				if($where == ""){
					$q .= "";
				} else {
					$i = 0;
					foreach( $where as $value ){
						$q .= ($i > 0) ? "," : "";
						$q .= $value;
						$i++;
					}
				}
				$q .= ")";
			break;
			case "D":
				$q = "DELETE FROM ";
				$i = 0;
				foreach( $table as $value ){
					$q .= ($i > 0) ? ", " : "";
					$q .= $value;
					$i++;
				}
				

				if($where == ""){
					$q .= "";
				} else {
					$q .= " WHERE ";
					foreach( $where as $value ){
						$q .= $value;
					}
				}
			break;
			case "U":
				$q = "UPDATE ";
				
				$i = 0;
				foreach( $table as $value ){
					$q .= ($i > 0) ? "," : "";
					$q .= $value;
					$i++;
				}
				
				$q .= " SET ";
				
				if($column == ""){
					echo "<div>Attenzione: l'array column deve essere valorizzato con una coppia colonna-valore da aggiornare!</div>";
					exit;
				} else {
					$i = 0;
					foreach( $column as $value ){
						$q .= ($i > 0) ? ", " : " ";
						$q .= $value;
						$i++;
					}
				}

				if($where == ""){
					$q .= "";
				} else {
					$q .= " WHERE ";
					foreach( $where as $value ){
						$q .= $value;
					}
				}
			break;
		}
		return $q;
	} // end of member function myQuery

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function msQuery( )
	{
		
	} // end of member function msQuery

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function pgQuery( )
	{
		
	} // end of member function pgQuery

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function oraQuery( )
	{
		
	} // end of member function oraQuery

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function numrows( )
	{
		switch($this->dbtipo){
			case "MySql":
				$n = mysql_num_rows($this->result);
			break;
			case "MsSql":
				return mysql_query($query);
			break;
			case "PostgreSql":
				return pg_query($query);
			break;
			case "Oracle":
				// $this->connessione rappresenta il cursore, non la connessione!!
				return ora_do($this->connessione, $query);
			break;
		}
		return $n;
	} // end of member function numrows

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function lastMsg( )
	{
		
	} // end of member function lastMsg

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function lastID( )
	{
		switch($this->dbtipo){
			case "MySql":
				$id = mysql_insert_id();
			break;
			case "MsSql":

			break;
			case "PostgreSql":

			break;
			case "Oracle":

			break;
		}
		return $id;
	} // end of member function lastMsg
	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function echoSql( ) // stampa la query
	{
		echo $this->q;
	} // end of member function echoSql
	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function getQuery( ) // stampa la query
	{
		return $this->q;
	} // end of member function getQuery
	
	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function close( )
	{
		
	} // end of member function close





} // end of conn
?>