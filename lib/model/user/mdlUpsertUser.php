<?php
/**
 * Model Upsert User
* @author     Jason Ebbers [ebbers@gmail.com]
* @package    Model
* @subpackage User
*/
class mdlUpsertUser{
	/**
	 * Upsert User
	 * @param array $args
	 * @return array results
	 * @throws Exception
	 */
	public static function upsertUser($args){
		include_once PATH_CLASS . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "userDao.php";
		if(isset($args["userId"])){
			$aQuery = self::validateUpdate($args);
			$checkUser = userDao::getUser($aQuery);
			if($checkUser["totalRecs"] == 0){
				throw new Exception("No User with userId " . $aQuery['userId'] . " found");
			}
			if(count($aQuery) > 1){
				return userDao::updateUser($aQuery);
			}
			return array(
				"status"	=> true,
				rs			=> array()
			);
			
		} else {
			$aQuery = self::validateInsert($args);
			return userDao::insertUser($aQuery);
		}
	}
	/**
	 * Validate Update
	 * Validte and normalize data. Normally I would run this through a validator class.
	 * @param array $args
	 * @throws Exception
	 */
	protected static function validateUpdate($args){
		if(isset($args["password1"]) && strLen(trim($args["password1"]))){
			if(strlen(trim($args["password1"])) > 6){
				$aQuery["password"] = trim($args["password1"]);
			} else {
				throw new Exception("Password must be 7 Characters or more");
			}
		}
		if(isset($args["first"])){
			$aQuery["first"] = trim($args["first"]);
		}
		
		if(isset($args["last"])){
			$aQuery["last"] = trim($args["last"]);
		}
		
		if(isset($args["email"]) && filter_var($args["email"], FILTER_VALIDATE_EMAIL)){
			$aQuery["email"] = $args["email"];
		}
		if(isset($args["userId"])){
			$aQuery["userId"] = $args["userId"];
		}
		return $aQuery;
	}
	
	/**
	 * Validate Insert
	 * Validate and Normalize data. Normally I would run this through a validator class.
	 * UserName, Password, First, Last and Email are required
	 *
	 * @param  array Arguments
	 * @return array Query Params
	 * @throws Exception
	 */
	protected static function validateInsert($args){
		$aQuery = array();
		if(isset($args["username"])){
			if(strlen(trim($args["username"])) > 6){
				$aQuery["username"] = trim($args["username"]);
			} else {
				throw new Exception("Username must be 7 Characters or more");
			}
		} else {
			throw new Exception("Username is required but was not passed");
		}
		
		if(isset($args["password1"])){
			if(strlen(trim($args["password1"])) > 6){
				$aQuery["password"] = trim($args["password1"]);
			} else {
				throw new Exception("Password must be 7 Characters or more");
			}
		} else {
			throw new Exception("Password is required but was not passed");
		}
		
		if(isset($args["first"])){
			$aQuery["first"] = trim($args["first"]);
		} else {
			throw new Exception("First is required but was not passed");
		}
		
		if(isset($args["last"])){
			$aQuery["last"] = trim($args["last"]);
		} else {
			throw new Exception("last is required but was not passed");
		}
		
		if(isset($args["email"]) && filter_var($args["email"], FILTER_VALIDATE_EMAIL)){
			$aQuery["email"] = $args["email"];
		} else {
			throw new Exception("Email is required but was not passed, or is not in a recognized format");
		}
		return $aQuery;
	}
}