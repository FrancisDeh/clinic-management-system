<?php
session_start();

/*This section starts a session to end a session.
	a. When user clicks sign out option, the current session is disabled using the unset command.
	b. The user id is disabled from authorization.
	c. The user is re-directed to the user login page; index.php
*/
unset($_SESSION['user_id']);

header("Location: ../index.php");
?>
