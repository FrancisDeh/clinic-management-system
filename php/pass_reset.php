<?php
require_once "est_connect.php";

/*this page resets password for users who have forgotten their password
First, password is stored in password if is set. if username and surname is set, that is if the condition is
true for both, store each value in the variables. Verify if the username and surname exist. if they exist,
go ahead and update the password. Then send a success message to index.php. If they do not exist,
send a not successful message to index.php

*/
$password = trim($_REQUEST['password']);

if(isset($_POST['verUsername']) && isset($_POST['surname'])) {
//Verify if username and surname exits, if they exist, update password and send a confirmation message
$username = mysqli_real_escape_string($connect, trim($_REQUEST['verUsername']));
$surname = mysqli_real_escape_string($connect, trim($_REQUEST['surname']));

//Look up the user
$query = sprintf("SELECT surname, username FROM users " .
        "WHERE surname = '%s' AND " .
        "      username = '%s';",
        $surname,
        $username);
$results = mysqli_query($connect, $query);

if (mysqli_num_rows($results) == 1) {
  $update_query = sprintf("UPDATE users SET password = '%s' WHERE username = '%s' AND surname = '%s'; ",
  crypt($password, $username),
  $username,
  $surname);

  $update_result = mysqli_query($connect, $update_query);
  if($update_query){
   
    header('Location: ../index.php?notification=Password has been succesfully updated');
    exit();
  }
} else {
  
  header('Location: ../index.php?notification=Surname or Username is invalid');
  exit();
}


}
else {
	/*echo "Things didn't go on well";*/
}
?>