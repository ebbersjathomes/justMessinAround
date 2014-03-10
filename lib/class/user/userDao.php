<?php
/**
 * User DAO
 * Handles DB interaction for the user table
 * 
 * @author     Jason Ebbers [ebbersj@gmail.com]
 * @extends	   daoBase
 * @package    class
 * @subpackage user
 */
include_once PATH_CLASS . DIRECTORY_SEPARATOR . "mySql" . DIRECTORY_SEPARATOR . "daoBase.php";
class userDao extends daoBase{
	
	/**
	 * Update User
	 * @param array $queryParams
	 * @return array
	 */
	public static function updateUser($queryParams){
		$aQueryData = self::buildUpdateUserQuery($queryParams);
		return array(
				"status"	=> true,
				"rs"		=> self::executeCommand($aQueryData["query"], $aQueryData["parms"])
		);
	}
	
	/**
	 * Build Update User Query
	 * @param array $queryParams
	 * @return array
	 */
	protected static function buildUpdateUserQuery($queryParams){
		$aOut = array(
			"query" => "UPDATE USER SET d_update = now()",
			"parms"	=> array()		
		);
		
		if(isset($queryParams["password"])){
			$aOut["query"] .= ", hash = ?";
			$aOut["parms"][] = array(
					"type" 	=> "s",
					"value"	=> hash("sha512",$queryParams["password"], false)
			);
		}
		
		if(isset($queryParams["first"])){
			$aOut["query"] .= ", first = ?";
			$aOut["parms"][] = array(
				"type" 	=> "s",
				"value"	=> $queryParams["first"]		
			);
		}
		
		if(isset($queryParams["last"])){
			$aOut["query"] .= ", last = ?";
			$aOut["parms"][] = array(
					"type" 	=> "s",
					"value"	=> $queryParams["last"]
			);
		}
		
		if(isset($queryParams["email"])){
			$aOut["query"] .= ", email = ?";
			$aOut["parms"][] = array(
					"type" 	=> "s",
					"value"	=> $queryParams["email"]
			);
		}
		
		$aOut["query"] .= " WHERE pk_user_id = ?";
		$aOut["parms"][] = array(
				"type" 	=> "i",
				"value"	=> $queryParams["userId"]
		);
		
		return $aOut;
	}
	
	
	/**Delete User
	 * 
	 * @param array $queryParams
	 * @return array
	 */
	
	public static function deleteUser($queryParams){
		$aQueryData = self::buildDeleteUserQuery($queryParams);
		return array(
			"status"	=> true,
			"rs"		=> self::executeCommand($aQueryData["query"], $aQueryData["parms"])		
		);
	}
	
	/**
	 * Build Delete User Query
	 * @param array $queryParams
	 * @return array
	 */
	protected static function buildDeleteUserQuery($queryParams){
		return array(
			"query"	=> "UPDATE USER set status = 'X', d_update = now() where PK_USER_ID = ?",
			"parms"	=> array(
				0 => array(
					"type"	=> "i",
					"value"	=> 	$queryParams["userId"]
				)
			)
		);
	}
	
	/**
	 * Insert User
	 * @param array $queryParams
	 * @return array
	 */
	public static function insertUser($queryParams){
		$aQueryData = self::buildInsertUserQuery($queryParams);
		return array(
				"status"	=> true,
				"rs"		=> self::executeInsert($aQueryData["query"], $aQueryData["parms"])
		);
	}
	
	/**
	 * Build Insert User Query
	 * @param array $queryParams
	 * @return array
	 */
	protected static function buildInsertUserQuery($queryParams){
		$aOut = array(
			"query"	=> "",
			"parms"	=> array(
				0	=> array(
					"type" 	=> "s",
					"value"	=> $queryParams["username"]		
				),
				1	=> array(
					"type"	=> "s",
					"value"	=> hash("sha512",$queryParams["password"], false)		
				)		
			)		
		);
		$aOut["query"] = "
			INSERT INTO
			user
			(
				username,
				hash,
				d_update,
				d_created,
				status";
		if(isset($queryParams["first"])){
			$aOut["query"] .= ", first";
		}
		if(isset($queryParams["last"])){
			$aOut["query"] .= ", last";
		}
		if(isset($queryParams["email"])){
			$aOut["query"] .= ", email";
		}
		$aOut["query"] .=	
			") VALUES (
			?,
			?,
			now(),
			now(),
			'A'";
		if(isset($queryParams["first"])){
			$aOut["query"] .= ", ?";
			$aOut["parms"][] = array(
				"type"	=> "s",
				"value"	=> $queryParams["first"]
			);
		}
		if(isset($queryParams["last"])){
			$aOut["query"] .= ", ?";
			$aOut["parms"][] = array(
					"type"	=> "s",
					"value"	=> $queryParams["last"]
			);
		}
		if(isset($queryParams["email"])){
			$aOut["query"] .= ", ?";
			$aOut["parms"][] = array(
					"type"	=> "s",
					"value"	=> $queryParams["email"]
			);
		}
		$aOut["query"] .=
		")";
		
		return $aOut;
	}
	
	/**
	 * 
	 * @param array $queryParams
	 * @throws Exception
	 * @return array
	 */
	public static function getUser($queryParams){
		$queryParams["perPage"] = 10;
		$aQueryData = self::buildGetUserQuery($queryParams);
		
		$aOut = array(
			"rs"		=> self::executeQuery($aQueryData["query"][0], $aQueryData["parms"][0]),
			"status"	=> true
		);
		
		$totalRecs = self::executeQuery($aQueryData["query"][1], $aQueryData["parms"][1]);
		$aOut["totalRecs"] = $totalRecs[0]["totalRecs"];
		$aOut["totalPages"] = ceil($aOut["totalRecs"] / 10);
		return $aOut;
	}
	/**
	 * Build User Query
	 * @param array $queryParams
	 * @return array
	 */
	protected static function buildGetUserQuery($queryParams){
		$aOut = array(
			"query" => array(),
			"parms" => 
				array(
					0	=> array(),
					1	=> array()	
				)
		);

		if(!isset($queryParams["page"])){
			$queryParams["page"] = 1;
		}
		if(!isset($queryParams["perPage"])){
			$queryParams["perPage"] = 10;
		}
		$aOut["query"][0] =
		"SELECT
			SQL_CALC_FOUND_ROWS
			pk_user_Id,
			username,
			first,
			last,
			email
			FROM
			user
		WHERE
			status = ?";
		$aOut["parms"][0][] = array(
			"type"	=> "s",
			"value"	=> "A"		
		);
		if(isset($queryParams["userId"])){
			$aOut["query"][0] .=
			"	AND
			pk_user_Id = ?";
			$aOut["parms"][0][] = array(
				"type" => "i", 
				"value" => $queryParams["userId"]
			);
		}
		if(isset($queryParams["username"])){
			$aOut["query"][0] .=
			"	AND
			username = ?";
			$aOut["parms"][0][] = array(
				"type"	=> "s",
				"value"	=> $queryParams["username"]
			);
		}
		$aOut["query"][0] .=
		"	LIMIT " . self::buildLimit($queryParams["page"], $queryParams["perPage"]) . ",10";
		
		$aOut["query"][1] = "SELECT FOUND_ROWS() as totalRecs";
		return $aOut;
	}
	/**
	 * Build Limit
	 * Calculates the Offset portion of the limit for Pagination
	 * @param int $page
	 * @param int $perPage
	 * @return int
	 */
	protected static function buildLimit($page = 1, $perPage = 10){
		return ($page - 1) * $perPage;
	}
}