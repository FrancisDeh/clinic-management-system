<?php
require_once "est_connect.php";

session_start();

 /*Page authentication, this function does not allow access to any page unless you are signed in.
 By using URL manipulation techniques to manually access pages will result in redirection to the 
 index.php page. This function is invoked in all pages before the function can be executed.

 	a. The function checks if a session has been created using the user id.
 	b. If a session has been created, is the user id greater than 0? 
 Both conditions have to be met before access can be granted, else the user is re-directed to 
 the index.php page to login before authorization can be granted. Re-direction is done using the 
 header method in PHP*/
 //Function authorize_user()
	function authorize_user() {
		if ((!isset($_SESSION['user_id'])) || (!strlen($_SESSION['user_id']) > 0)) {
      
			header('Location: ../index.php?message=You have to be signed in to view this page.');
		exit();
	}
	}


?>
