<?php
/**
 * MySQL Connection Factory
 *
 * @author     Jason Ebbers [ebbers@gmail.com]
 * @package    MySql
 * @subpackage Factory
 */

class mySqlFactory {
	/**
	 * Container for all connections
	 * @var array
	 */
	protected static $_connections = array();
	
	/**
	 * Connection Strings
	 * @var array
	 */
	protected static $_connectionStrings = array(
		"DEVELOPMENT" => array(
			"host"		=> "127.0.0.1",
			"username"	=> "php",
			"password"	=> "s3cr3t",
			"dbname"	=> "sample"
		)
	);
	
	/**
	 * Get Connection Object
	 *
	 * @param  string Application Environment
	 * @return MySQLi Connection
	 * @throws Exception
	 */
	public static function getConnection($env = APPLICATION_ENV){
		if(!isset(self::$_connectionStrings[$env])){
			throw new Exception("Error in Application Configuration: Unknown Application Environment: $env");
		}
		
		if(!isset(self::$_connections[$env])){
			$mysqli = new mysqli(
				self::$_connectionStrings[$env]["host"], 
				self::$_connectionStrings[$env]["username"], 
				self::$_connectionStrings[$env]["password"],
				self::$_connectionStrings[$env]["dbname"]
			);
			if($mysqli->connect_error){
				throw new Exception($mysqli->connect_error, $mysqli->connect_errno);
			}
			self::$_connections[$env]= $mysqli;
		}
		return self::$_connections[$env];
	}
}