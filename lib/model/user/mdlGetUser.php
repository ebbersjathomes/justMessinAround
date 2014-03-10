<?php
/**
 * Model Get User
 * @author     Jason Ebbers [ebbers@gmail.com]
 * @package    Model
 * @subpackage User
 */
class mdlGetUser{
	/**
	 * Get User
	 * Page Logic
	 *
	 * @param  array Arguments
	 * @return array results
	 * @throws Exception
	 */
	public static function getUser($args){
		include_once PATH_CLASS . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "userDao.php";
		$aQuery = self::validateData($args);
		return userDao::getUser($aQuery);
	}
	/**
	 * Validate Data
	 * Validate and Normalize data. Normally I would run this through a validator class.
	 * Only giving options to query for username and userid for now 
	 *
	 * @param  array Arguments
	 * @return array Query Params
	 */
	protected static function validateData($args){
		$aQuery = array();
		if(isset($args["userId"]) && is_numeric(trim($args["userId"]))){
			$aQuery["userId"] = trim($args["userId"]);
		}
		if(isset($args["username"]) && strlen(trim($args["username"]))){
			$aQuery["username"] = trim($args["username"]);
		}
		if(isset($args["page"]) && is_numeric(trim($args["page"]))){
			$aQuery["page"] = trim($args["page"]);
		}
		return $aQuery;
	}
}