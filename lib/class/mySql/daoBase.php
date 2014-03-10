<?php
/**
 * MySQL DAO Base
 * Extendable class for MySQL Interaction
 *
 * @author     Jason Ebbers [ebbersj@gmail.com]
 * @package    mySql
 * @subpackage base
 */
class daoBase{
	/**
	 * Execute Command
	 * Executes a query with no result (updates and deleted)
	 * 
	 * @param array $query
	 * @param array $params
	 * @throws Exception
	 * @return array
	 */
	protected static function executeCommand($query,$parms){
		return self::executeQueryBase($query, $parms, "none");
	}
	
	/**
	 * Execute Insert
	 * Executes a query and returns insert_id()
	 * 
	 * @param unknown_type $query
	 * @param unknown_type $params
	 * @throws Exception
	 * @return array
	 */
	protected static function executeInsert($query,$parms){
		return self::executeQueryBase($query, $parms, "insertId");
	}
	/**
	 *
	 * @param array $query
	 * @param array $parms
	 * @throws Exception
	 * @return array
	 */
	protected static function executeQuery($query,$parms){
		return self::executeQueryBase($query, $parms, "recordSet");
	}
	
	/**
	 * Execute Query Base
	 * Internal method to service all query requests and return data based on the $returnType
	 * 
	 * @param array $query
	 * @param array $parms
	 * @param string $returnType
	 */
	protected static function executeQueryBase($query,$parms,$returnType){
		include_once PATH_CLASS . DIRECTORY_SEPARATOR . "mySql" . DIRECTORY_SEPARATOR . "mySqlFactory.php";
		
		//get connection
		$conn = mySqlFactory::getConnection();
		//Prepare Statement
		if(!($stmt = $conn->prepare($query))){
			throw new Exception($conn->error, $conn->errno);
		}
		
		//Bind Params
		if(count($parms) > 0){
			$params = array(
					0 => ""
			);
			
			for($i=0;$i<count($parms);$i++){
				$params[0] .= $parms[$i]["type"];
				$params[] = &$parms[$i]["value"];
			}
			call_user_func_array(array($stmt, 'bind_param'), $params);
		}
			
		//Run The Query
		if(!$stmt->execute()){
			throw new Exception($stmt->error, $stmt->errno);
		}
		
		
		$aOut = array();
		switch($returnType){
			case "recordSet":
				$result = $stmt->get_result();
					
				while ($row = $result->fetch_assoc()) {
					$aOut[] = $row;
				}
				break;
				
			case "none":
				//nothing to do here
				break;
			
			case "insertId":
				$aOut["insertId"] = $stmt->insert_id;
				break;
		}
		
		//Clean Up
		$stmt->close();
		
		return $aOut;
	}
}