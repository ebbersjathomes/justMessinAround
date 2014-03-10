<?php
	/**
	 * PHP Code Sample Global Config
	 * 
	 * @author     Jason Ebbers [ebbers@gmail.com]
	 * @package    Bootstrap
	 * @subpackage Globals
	 */

	/**
	 * Define Paths
	 */
	define('PATH_ROOT', realpath(dirname(dirname(__FILE__))));
	    define('PATH_PUBLIC', realpath(PATH_ROOT . DIRECTORY_SEPARATOR . 'public'));
	    define('PATH_LOG', realpath(PATH_ROOT . DIRECTORY_SEPARATOR . 'log'));
	    define('PATH_LIBRARY', realpath(PATH_ROOT . DIRECTORY_SEPARATOR . 'lib'));
	    	define('PATH_CLASS', realpath(PATH_LIBRARY . DIRECTORY_SEPARATOR . 'class'));
	    	define('PATH_CONTROLLER', realpath(PATH_LIBRARY . DIRECTORY_SEPARATOR . 'controller'));
	    	define('PATH_FRAMEWORK', realpath(PATH_LIBRARY . DIRECTORY_SEPARATOR . 'epiphany' . DIRECTORY_SEPARATOR . 'src'));
	        define('PATH_MODEL', realpath(PATH_LIBRARY . DIRECTORY_SEPARATOR . 'model'));
	       	define('PATH_VIEW', realpath(PATH_LIBRARY . DIRECTORY_SEPARATOR . 'view'));
	define("PATH_TO_CSS", "/resources/css/");
	define("PATH_TO_JS", "/resources/js/");
	/**
	 * Set App Environment
	 */
	define("APPLICATION_ENV", strtoupper($_SERVER["APPLICATION_ENV"]));