<?php
/**
 * Model Delete User
* @author     Jason Ebbers [ebbers@gmail.com]
* @package    Model
* @subpackage User
*/
class mdlDeleteUser{
	/**
	 * Delete User
	 * Page Logic
	 *
	 * @param  array Arguments
	 * @return array results
	 * @throws Exception
	 */
	public static function deleteUser($args){
		include_once PATH_CLASS . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "userDao.php";
		$aQuery = self::validateData($args);
		$checkUser = userDao::getUser($aQuery);
		if($checkUser["totalRecs"] == 0){
			throw new Exception("No User with userId " . $aQuery["userId"] . " found");
		}
		return userDao::deleteUser($aQuery);
	}
	/**
	 * Validate Data
	 * Validate and Normalize data. Normally I would run this through a validator class.
	 * Only giving options to query for username and userid for now
	 *
	 * @param  array Arguments
	 * @return array Query Params
	 * @throws Exception
	 */
	protected static function validateData($args){
		$aQuery = array();
		if(isset($args["userId"]) && is_numeric(trim($args["userId"]))){
			$aQuery["userId"] = trim($args["userId"]);
		} else {
			throw new Exception("UserId is required but was not passed, or is not of type numeric");
		}
		return $aQuery;
	}
}