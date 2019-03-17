<!--
Author:Francis Deh
Software: Clinic Management System
Date Created: 
Date Ended:
Duration:
Date of Documentaion: 23 February, 2017, Tuesday.

Functionality: The Clinic management system enhances record keeping of patients that report to the clinic on 
daily basis, offers search capability and patient information view page, monthly record print out and 
user authentication system. -->

<!--Page Schematics-->
<!--
Page name is index.php. Offers four major functionalities and few minor functions.
1. Registration: The "Create Account" column offers 6 options to be filled by new user.
				a. Surname b. First Name c.Secret Pin d. Username e. Password f. Confirm Password

				** The Secret Pin is discrete and known by only the staff of the clinic. This is to ensure 
				that unauthorized people can not create an account to have access to the system**

				Validation for the "Create Account" column is both Client Side using JQuery and server side
				using Php.

				Information that meets the standard criteria of the "Create Account" column and is sent 
				as a "request" to this same file. "PHP_SELF" is the technical term for what is at play here.

				**Confirmation message is given for successfull registration**
				**Validation for same username registration is done using php, later spoken--at the 
				bottom of this page.

2. Authentication: For registered users, Username and Password are required to authenticate user. These crede
					-ntials are also used to "Start a Session", without which none of the pages can be acc-
					essed by user. This is
					located at the "Credentials" column.
					Notification message is given if password or username is invalid.
					Sign in credentials are sent as a POST request to "sign_in.php" located inside 
					the php folder. 
					**Auto complete features(username suggestions offered by browser during log in) for username
					is turned off using JQuery. Reason is to keep usernames secured since usernames are used as
					verification protocol for Password Renewal. 

3. Password Renewal: The "Forgot your Password?" button beneath the Credentials column when clicked displays
					a dialog box called "Credentials Verification". The functionalities are basically two,
					they include:
					1. Password Renewal: Users can renew their password.
					2. Password Renewal when Old password is forgotten.
					These functionalities are facilitated by the input types.
					a. Surname b.Username c. New Password d.Confirm Password

					**Note that Old password is not required for Verification process to work. This is for 
					neccessary sake of Password renewal when the old password is forgotten.
					Thus Username and Password are used for verification, server side authentication
					is used before any change is effected. Notification messages are used to prompt user 
					if renewal is successful or not.
					**Submitted info using the submit button sends a POST request to "pass_reset.php" locate
					d inside the php file.

4.Time Notification: Using Javascript, the System Time is displayed indicating either PM or AM.
					**Since this functionality depends largely on the system on which the software is running,
					it is recommended that System Time should be correct in order for The Time Functionality
					to be accurate.

			**Other Funcions Include**
			a. Welcome message to educate users on how to use the software. The Motto of the clinic is indic-
			ated below the message.
			b. Header containing the name of the health institution, "God's Grace Maternal Clinic".
			c. A logo of the clinic--hover events increases the size of the image.

**** The index.php performs all the above mentioned function. Detailed Programmer Informations are provided as follows***


<!--Html submits form values to itself-->
<?php
/*Credentials needed to access the database are required from est_connect.php*/
require_once "php/est_connect.php";


/*When the "Sign In" button is invoked, credentials (username, password) are sent to sign_in.php for 
authentication before authorization is granted. If access is not granted, possibly, either the username or 
password is invalid. Notification message is sent from sign_in.php to this page and displayed to the user.
Other wise, no request is sent, access is granted.*/

//Accept error message from sign_in.php if login credentials are not correct
if(isset($_REQUEST['error'])) {
$invalid = $_REQUEST['error'];
}


/*A valid session is required before any page is accessed by the user. Without a session created using username
, no page can be accessed, not even with url manipulation. **This therefore is also a security measure**
*/
/*If any page is accessed manually, especially using url manipulation, the user is brought back to this page
with a message prompting the user to register/sign in before accessing the pages*/
if(isset($_REQUEST['message'])){
//Accept message if any page is accessed without authorization
$message = $_REQUEST['message'];
}

/*During Password Renewal Process, notification message is always sent by pass_reset.php page to indicate
whether password renewal is successful or not. To read more on this, you can visit pass_reset.php to read more*/
#open dialog to display if password changing was successful or not
if(isset($_REQUEST['notification'])){
$notification = $_REQUEST['notification'];
echo '<p class = "notification">' . $notification . '</p>';
}


/*The PHP functions to validate entries made by users. 
		a. NameVal fuction ensures that only letters and white spaces are the values accepted. An error is
		generated if name does not match the rule/requirements.
		b. inputVal function does a general validation for all entries.
			1. White spaces are removed
			2. Slashes are discarded.
			2. Sql codes are removed. **This is a security measure--purposely agains Sql injection**

			*/

//Function to validate name, if name is not letters, error should be issued.
function nameVal($names){
	if(!preg_match("/^[a-zA-Z]*$/", $names)){
		$nameError = "Only letters and whitespace allowed!";
		return $nameError;
	} else {
		$nameError = "";
		return $nameError;
	}
}
//Function for general validation
function inputVal($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

/*This aspect of the code is responsible to recieve all submitted entries made when the Create Account 
column is used. The entries are accepted by this same page; this is to ensure Instant validation*/
//Execute only when File is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

//array for error--This array holds all potential errors that will be generated when entries are accepted 
// from form submission. **This array will be expected to be empty before any entries are stored into the database.

$error = array();

//Validating names
//First name
$firstname = inputVal($_REQUEST['firstName']);
$error['firstName'] = nameVal($firstname);

/*To ensure that the user undergoing the registration is a staff member, the secret pin provided will be 
checked against the value in the database, if it matches, account creation is executed, that is if no 
other errors are found. Notification message is given if secret pin does not match*/

/*if secret pin is set, retrieve value of secret pin from the database and compare it to user input*/
//secret Pin
$secretPin = inputVal($_REQUEST['secretPin']);
if(isset($_REQUEST['secretPin'])){
	$select_query = sprintf("SELECT secret_pin from user_secret_pin where number = %d", 1);
	$result = mysqli_query($connect, $select_query);
	if($result){
		$row = mysqli_fetch_array($result);
		$pin = $row['secret_pin'];

	if ($secretPin != $pin){
		$error['secretPin'] = "Secret Pin does not Match";
	} else {
		$secretPin = $_REQUEST['secretPin'];
		$error['secretPin'] = "";
	}


	}else {
		$error['secretPin'] = "An error occured, Please try again!";
	}
}//end of secret pin

			/*Surname*/
$surname = inputVal($_REQUEST['surname']);
$error['surname'] = nameVal($surname);/*Validation for surname*/
		/*Username*/
$username = $_REQUEST['username'];

		/*Password*/
$password = $_REQUEST['password'];

	/*Confirm Password*/
/*Since client side validation has been done using JQuery, there will be no validation here.*/
$confirm_password = $_REQUEST['confirmPassword'];
}
?>

<!-- !DOCTYPE html> -->
<html lang = "en">
<head>
	<meta charset = "utf-8">
	<title>Sign in page</title>
	<link href = "css/login.css" rel = "stylesheet">
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src = "js/getTime.js"></script>
	<script src = "js/jquery.validate.min.js"></script>
<script>
$(document).ready(function(){

	//Disable  default autocomplete in inputs.
	$("#username").attr('autocomplete', 'off');
	$(".username").attr('autocomplete', 'off');
	$("#Username").attr('autocomplete', 'off');
	$("#surname2").attr('autocomplete', 'off');
	$("#surname").attr('autocomplete', 'off');
	$(".firstName").attr('autocomplete', 'off');


	//validation for create account
	$("#createAccountForm").validate({
		rules : {
password : {
required : true,
rangelength : [8,16]
},
confirmPassword : {
	equalTo : '#password'
}
}, // end of rules
messages : {
password : {
required : "Provide Password",
rangelength : "Must be between 8 and 16 characters."
},
confirm_password : {
equalTo : "Passwords don't match."
}
} // end of messages
	});//end of validation

/*Validation for reset password dailog*/
$("#resetPass").validate({
	rules : {
password : {
required : true,
rangelength : [8,16]
},
confirm_password2 : {
equalTo : '#password2'
}
}, // end of rules
messages : {
password : {
required : "Provide Password",
rangelength : "Must be between 8 and 16 characters."
},
confirm_password2 : {
equalTo : "Passwords don't match."
}
} // end of messages
});//end of validation

//Code for dialog box
$('#resetPassword').dialog({
	autoOpen: false,
	modal: true,
	resizable: false,
	draggable: false,
	hide: { effect: 'explode', delay: 100, duration: 1000, easing:
'easeInQuad' },
show: 'slideDown',
buttons : {
"Done" : function() {
	$(this).dialog('close');
	$("#username").focus();//focuses the username input ready to take input
// code executed when "Confirm" button is clicked
},
"Cancel" : function() {
	$(this).dialog('close');
	$("#username").focus();//focuses the username input ready to take input
// code executed when "Cancel" button is clicked
}
} // end buttons

});//end of dialog


$("#forgotPassword").click(function(){
	$("#resetPassword").dialog('open');
});


//Button for password reset
$('#forgotPassword').button();//End of button for password reset

//setting the time
function displayTime() {
	$('#time').text(getTime(true));
}
displayTime();
setInterval(displayTime,1000);//End of time

});
</script>
</head>
<body>
<!--The header contains the logo , name of the hospital, current date and time. -->
<header>
	<img class = "logo" src = "images/top_logo.jpg" alt = "Logo" >
	<p class =  "header">GOD'S GRACE MATERNITY CLINIC</p>
</header>


<!--This section extracts the current date from host system and displays it-->
<div id = "timeDetails">
 <strong id = "time">Time:</strong><!--Continuos time--><br>
 <strong id = "date"><?php echo date('d M Y'); ?></strong><!--Day name, month name, year-->
</div>

<!--This section is for creating user credentials, it is absolutely postioned and hidden. it appers when a button is clicked-->
<div class = "createAccount">
		<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id = "createAccountForm">
			<fieldset><legend>Create Account</legend>
				<label for = "surname">Surname: </label>
				<input name="surname" type="text" id = "surname"  title = "Please provide your surname" required /><span class = "error"><?php if(isset($error['surname'])) echo $error['surname'];?></span><br>
				<label for = "firstname">First name: </label>
				<input name="firstName" type="text" class = "firstName" required/><span class = "error"><?php if(isset($error['firstName'])) echo $error['firstName'];?></span><br />
				<label for = "secretPin">Secret Pin: </label>
				<input name="secretPin" type="password" /><span class = "error"><?php if(isset($error['secretPin'])) echo $error['secretPin']; ?></span><br>

				<label for = "username">Username: </label>
				<input type = "text" name = "username" class = "username" required><br>
				<label for = "password" class = "label">Password: </label>
				<input type = "password" name = "password" id = "password" required><br>
				<label for = "confirmPassword" class = "label">Confirm Password: </label>
				<input type = "password" name = "confirmPassword" id = "confirm_password" required><br>
				<div class = "controls">

		 <input name="submit" type="submit" value="Register" />
	 </div>
	</fieldset>
</form>
</div> <!--end of the form-->

<!--This section holds the login credentials requirement column, a login profile picture and a little
info on what the Clinic Management System is about-->
<section>
<div class = "loginInfo">
	<img src = "images/missing_user.png" alt = "Temporal Profile Pic"><br>
	<form class = "signIn" action = "php/sign_in.php" method = "POST">
	<fieldset>
	<legend>Credentials</legend>
		<label for "username">Username:</label>
		<input type = "text" name = "username"  size = "20" autofocus required  id = "username"/> <br>
		<label for "password">Password: </label>
		<input type = "password" name = "password" required /><br>

		<!--Prints error messages, for password registration or unauthorized page access-->
		<span class = "error"><?php if(isset($_REQUEST['error'])) print $invalid; $invalid = "";?></span><br><!--If credetials are not correct , error message is displayed-->
		<span class = "error"><?php if(isset($_REQUEST['message'])) print $message; ?></span><br><!--Message to prompt user to login before accessing any page-->
		
		<input type = "reset" value = "Reset"/>
		<input type = "submit" value = "Sign In"/>
	</fieldset>
	</form>
	<button id = "forgotPassword">Forgot your password?</button>
</div>

<div class = "welcomeNote">
		<p class = "intro">Welcome to the <strong>Clinic Management System</strong>.  If you are new here, use the
			<strong>Create Account</strong>  column to create your account, else provide <strong>Credentials</strong> to access your profile. If you have forgotten your password, or intend to change your password, select <strong>Forgot your password?</strong> Thank you!.<em>In God We Trust</em>
		</p>
	</div>
</section>

<!--Dialog box to reset password-->
<div id = "resetPassword" title = "Credentials Verification">
	<form id = "resetPass" action = "php/pass_reset.php" method = "POST">
		<label for = "surname">Surname: </label>
		<input type = "text" name = "surname" id = "surname2" required><br>
		<label for = "username">Username: </label>
		<input type = "text" name = "verUsername" id = "Username" required><br>
		<label for = "password" class = "label">New Password: </label>
		<input type = "password" name = "password" id = "password2" required><br>
		<label for = "confirmPassword" class = "label">Confirm Password: </label>
		<input type = "password" name = "confirm_password2" id = "confirm_password2" required><br>
		<input type = "reset" value = "Reset">
		<input type = "submit" value = "Change">
	</form>
</div>


<footer></footer>
</body>
<?php
//VERIFYING THE POSSIBILITY OF ERROR, IF THERE IS AN ERROR, SUBMISSION STOPS AND THE ERROR
//PRINTED ON THE SCREEN  ELSE INFORMATION IS SENT INTO THE DATABASE
if($_SERVER["REQUEST_METHOD"] == "POST"){
//INFORMATION WILL ONLY BE SENT IF THERE IS NO ERROR

/*Check if there is an error in First Name, Surname and Secret Pin, if any, Registration of User 
will not be successful. An error message is issued.
If there is no error, the system queries the database if username already exists. If it already exists,
a notification message should be issued indicating that the username already exists.
 
Else the values will be inserted into the database.
A successful insertion will invoke a notification to the user indicating a successful registration.
 */
if($error['firstName'] == "" && $error['secretPin'] == "" && $error['surname'] == ""){
	
//Look up the user--make sure the username does not exist already
	$query = sprintf("SELECT username FROM users " .
					"WHERE username = '%s';",
					$username);
	$results = mysqli_query($connect, $query);

	if (mysqli_num_rows($results) == 1) {	
	echo '<p class = "accountExist">Username already exits!</p>';
	} else {

//using database credentials, files can be stored into the DATABASE
		/*The Database Users holds five collumns.
		1. User_Id, increments automatically. This is the primary key. It assigns number of users automatically
		2. First_Name; Stored with datatype VARCHAR of length constraint of 50
		3. Surname; Stored with datatype VARCHAR of length constraint of 50
		4. Username; Stored with datatype VARCHAR of length constraint of 20
		5. Password; Stored with datatype of VARCHAR of length constraint of 50. Password is encrypted using each user's username.

		*/
//Inserting values into the database Users
$insert_sql = sprintf("INSERT INTO users (first_name, surname, username, password ) " .
"VALUES ('%s','%s', '%s','%s');",
						mysqli_real_escape_string($connect, $firstname),
						mysqli_real_escape_string($connect, $surname),
						mysqli_real_escape_string($connect, $username),
						mysqli_real_escape_string($connect, crypt($password, $username)));


//Insert the user into the databse
mysqli_query($connect, $insert_sql);
//Get the user id of the current inserted user


#alert the user that the account has been successfully created
echo '<p class = "accountCreated">Account has been successfully created. You can sign in now!</p>';


	}
}
else {
	echo '<p class = "accountError">Sorry! There are errors.</p>';
	
}
}

?>
</html>
