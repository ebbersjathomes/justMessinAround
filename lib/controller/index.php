<?php
	/**
	 * PHP Code Sample  External Routes
	 *
	 * @author     Jason Ebbers [ebbersj@gmail.com]
	 * @package    Bootstrap
	 * @subpackage Routes
	 */
	include_once(PATH_CONTROLLER . DIRECTORY_SEPARATOR . "apiUser.php");
	//This is meant to be called via JS since some browsers don't support the delte method creating a seperate route
	getRoute()->post("/ajax/user/delete",array("apiUser","deleteUser"));
	getRoute()->get("/ajax/user",array("apiUser", "getUser"));
	getRoute()->post("/ajax/user",array("apiUser","upsertUser"));
	getRoute()->get("/editUser",array("apiUser","editUserHTML"));