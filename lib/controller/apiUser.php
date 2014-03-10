<?php
/**
 * API User
 * Controller for User sub section
 *
 * @author     Jason Ebbers [ebbersj@gmail.com]
 * @package    Controller
 * @subpackage User
 */
class apiUser
{
	static public function deleteUser(){
		include_once PATH_MODEL . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "mdlDeleteUser.php";
		
		try{
			$response = json_encode(mdlDeleteUser::deleteUser($_POST));
		} catch (Exception $e){
			$response = json_encode(
					array(
						"status"	=> false,
						"message"	=> $e->getMessage()
					)
			);
		}
		
		header('Content-Type: application/json');
		header('Content-Length:' . strlen($response));
		echo $response;
	}
	
	static public function getUser()
	{
		include_once PATH_MODEL . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "mdlGetUser.php";
		
		try{
			$response = json_encode(mdlGetUser::getUser($_GET));
		} catch (Exception $e){
			$response = json_encode(
				array(
					"status"	=> false, 
					"message"	=> $e->getMessage()
				)
			);
		}
		header('Content-Type: application/json');
		header('Content-Length:' . strlen($response));
		echo $response;
	}
	
	static public function upsertUser(){
		include_once PATH_MODEL . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "mdlUpsertUser.php";
		
		try{
			$response = json_encode(mdlUpsertUser::upsertUser($_POST));
		} catch (Exception $e){
			$response = json_encode(
					array(
							"status"	=> false,
							"message"	=> $e->getMessage()
					)
			);
		}
		
		header('Content-Type: application/json');
		header('Content-Length:' . strlen($response));
		echo $response;
	}
	
	public static function editUserHTML(){
		include_once PATH_MODEL . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "mdlGetUser.php";
		$response = mdlGetUser::getUser(array());
		
		$template = new EpiTemplate();
		$aParams = array(
				"aCSS"		=> array(
					PATH_TO_CSS . "default.css",
					PATH_TO_JS . "fancybox/source/jquery.fancybox.css?v=2.1.5"
				),
				"aJS"		=> array(
					"//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js",
					PATH_TO_JS . "fancybox/source/jquery.fancybox.pack.js?v=2.1.5",
					PATH_TO_JS . "user/editUser.js"
				),
				"pageTitle"	=> "I'm a page title, short and stout.",
				"user"		=> $response["rs"]
		);
		
		$template->display("header.phtml",$aParams);
		$template->display(DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "editUser.phtml",$aParams);
		$template->display("footer.phtml");
	}
}