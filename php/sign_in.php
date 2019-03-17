<?php

/*
sign_in.php requires est_connect.php to establish a valid connection with the database
*/
require_once "est_connect.php";

/*
	This service checks if there is an existing session using the user id, if there is , the 
	session should be unset. 
		** This situation can occur if user signs in and clicks the back button,
		the session is not un set or disabled since the user did not invoke the sign
		out button. Thus the user returns to the login page with an active session.
		By clicking the sign in button without providing credentials, access can be granted since the session is still active.
			** Access will not be granted for two reasons:
			1. Client side validation using HTML requires that the username and password be provided
			before the sign in will work.
			2. Our PHP code ensures that any session that is set while the user is still in the 
			sign in page per adventure will be unset.

	On the other side, if no session has been identified but a request to sign in has been issued,
		**The system does two things:
			a. Check if username has been provided by the user: if 
			username has been sent via the request, possibly the password has also been sent.
			Store the username and password inside their respective variables.
			**THen check if truly the user is who they say they are: This done by querying
			the database if the username exits and that the password corressponds with the username

			Note that the password is encrypted, thus the query has to be well formed to ressemble the 
			encrypted password in the database.

			If there is a match, a row will be retrieved, a session will be created using the user id and
			there is re-direction using the header to the patient registration page. At this point, 
			the user can access all pages without restrictions until they log out.
			b. If username has not been found, or username has been found but the password does not 
			match, the user is not allowed access. A notification message is issued for user to 
			attempt again.There is no limit to how long/many times a user can attempt login.
*/

//Start/Resume sessions
session_start();
//if the user is logged in, the user_id in the session will be set
if (!isset($_SESSION['user_id'])) {

	//see if a login form was submitted with a username for login
	if (isset($_POST['username'])) {
	//Try and log the user in
	$username = mysqli_real_escape_string($connect, trim($_REQUEST['username']));
	$password = mysqli_real_escape_string($connect, trim($_REQUEST['password']));

	//Look up the user
	$query = sprintf("SELECT user_id, username FROM users " .
					"WHERE username = '%s' AND " .
					"      password = '%s';",
					$username, crypt($password, $username));
	$results = mysqli_query($connect, $query);

	if (mysqli_num_rows($results) == 1) {
		$result = mysqli_fetch_array($results);
		$user_id = $result['user_id'];
		//setting sessions
		$_SESSION['user_id'] = $user_id;
		header("Location: ../sites/registration.php?user_id={$user_id}");
		exit();
	}
	else {
	//if user not found, issue an error
	$error_message = "Your username/password combination was invalid.";
  header("Location: ../index.php?error={$error_message}");
  exit();
	}
	}
} else {
//if user has already logged in but still finds himself/herself at the login screen, allow user in
/*or we can unset all sessions and ask user to re-login for security reasons*/
session_start();

unset($_SESSION['user_id']);

header("Location: ../index.php");
exit();
}
	?>
