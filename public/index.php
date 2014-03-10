<?php
	/**
	 * PHP Code Sample Bootstrap
	 *
	 * @author     Jason Ebbers [ebbersj@gmail.com]
	 * @package    Bootstrap
	 */

	/**
	 * Include Globals
	 */
	include_once(".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "globals.php");
	/**
	 * Initialize the Epiphany Framework
	 */
	include_once(PATH_FRAMEWORK . DIRECTORY_SEPARATOR . "Epi.php");
	/**
	 * Initalize Epiphany Routes Module
	 */
	chdir('..');
	Epi::setPath('base', PATH_FRAMEWORK);
	Epi::setPath('view',PATH_VIEW);
	Epi::init("route","template");
	
	/**
	 * Define Routes
	 */
	include_once(PATH_CONTROLLER . DIRECTORY_SEPARATOR . "index.php");
	/**
	 * Let's Go!
	 */
	getRoute()->run();