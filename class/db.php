<?php

//class db{

	function connessione($dbuser=false, $dbpass=false, $dbname=false, $dbhost = false, $dbport = false){
		if(empty($dbuser))
			global $dbuser, $dbpass, $dbname, $dbhost;
			
			
		if (empty($dbhost)) $dbhost = 'localhost';
		if (empty($dbport)) $dbport = '3306';
		
		$Connection = "host=$dbhost;port=$dbport;dbname=$dbname";

		try
	    {
	        $dbh     = new PDO("mysql:$Connection"
	                                  ,  $dbuser, $dbpass);
	    }
	    catch (PDOException $e)
	    {
	        return $e->getMessage();
	    }
	    return $dbh;
		
	}
	
	function prepareSelect($table, $column, $where, $order='', $limit=''){
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
					foreach( $where as $key=>$value ){
						if($key > 0){
						if(substr($value, 0, 1) != ' ')
							$value = " " . $value;
							
						if(substr(strtoupper($value), 0, 3) != ' OR' OR substr(strtoupper($value), 0, 4) != ' AND')
							$value = " AND " . $value;
						}
							
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
		return $q;
	}
	function prepareInsert($table, $column, $where){
	
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
		return $q;
	}
	function prepareDelete($table, $where){
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
		return $q;
	}
	function prepareUpdate($table, $column, $where){
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
		return $q;
	}
	
	function preparaSql($tipo, $table, $column='', $where='', $order='', $limit=''){
		global $dbprefix;
		
		for($i = 0; $i < count($table); $i++)
			$table[$i] = $dbprefix . $table[$i];
	
		switch($tipo){
			case "S":
				$q = prepareSelect($table, $column, $where, $order, $limit);
			break;
			case "I":
				$q = prepareInsert($table, $column, $where);
			break;
			case "D":
				$q = prepareDelete($table, $where);
			break;
			case "U":
				$q = prepareUpdate($table, $column, $where);
			break;
		}
		return $q;
	
	}

//}

	

//pppppppppppppppppppppppppppppppppppppppppppppppppppppppppppp
//
//  Creates a new mySQL database connection
//
//  Returns a PDO object or an error message 
//  Use: is_object()  to verify the result
//
//
//  If $DBHost starts with a '/' then it is treated as a Socket
//
//  if $DBHost is empty it will default to LOCALHOST which is NOT the
//  same as 127.0.0.1
//
//  $DBPort is optional and will use the standard mySQL default if not
//  specified
//
//  The database name ($DBName) is optional, but if it is specified
//  it must exist or an error results
//
//  2009-03-11  Created: by codeslinger at compsalot.com
//
//          Released to the Public Domain free to use and modify
//
//
function dbPDO_Connect_mySQL($DBUser, $DBPass, $DBName = false,
                            $DBHost = false, $DBPort = false)
{

    $DBNameEq = empty($DBName) ? '' : ";dbname=$DBName";
   
    if (empty($DBHost)) $DBHost = 'localhost';
   
    If ($DBHost[0] === '/')
    {
        $Connection = "unix_socket=$DBHost";
    }
    else
    {
        if (empty($DBPort)) $DBPort = 3306;
        $Connection = "host=$DBHost;port=$DBPort";
    }
   
    //======================
   
    try
    {
        $dbh     = new PDO("mysql:$Connection$DBNameEq"
                                  ,  $DBUser, $DBPass);
    }
    catch (PDOException $e)
    {
        return $e->getMessage();
    }

    return $dbh;
}

//================================
//================================
//
//Example of use:
/*
  //connects to the default (localhost)

  $dbh = dbPDO_Connect_mySQL('user', 'password', 'database');

  //............................................................
  //error handler goes here

  if (!is_object($dbh)) trigger_error("Failed to connect to 'database' "
       ." | Error = $dbh", E_USER_ERROR);

  //............................................................
  //get a record

  $sql = "select * from SomeTable limit 1;";
   
  $dbRS = $dbh->query($sql);
  $row = empty($dbRS) ? false : $dbRS->fetch(PDO::FETCH_ASSOC);
  if (!empty($dbRS)) $dbRS->closeCursor();

  //............................................................
  //do something with the data

  if (!empty($row)) print_r($row);   
  else echo "Error? no data found\n";
*/
?>