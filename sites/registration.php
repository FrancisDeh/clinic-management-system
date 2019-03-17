<!--Html submits form values to itself-->
<?php

//REQUIRING CREDENTIALS FOR DATABASE CONNECTIVITY
require_once "../php/est_connect.php";
require_once "../php/authorize_settings.php";

//Authorize any user before they can access this page
authorize_user();



/*Pid of the last inserted patient and the total number of patients*/
$year = date("y");//a two digit year
$status = True;//set status to be true, ensures the while loop runs automatically
while($status){
	settype($year, "int"); //since year is string, change it to an integer
	#Sql to generate number of patient in that year.
	$query_one = sprintf("SELECT COUNT(pid) FROM patients WHERE year_of_reg = '%d';", $year);

	#execute query_one
	$result = mysqli_query($connect, $query_one);
	$count = mysqli_fetch_array($result);
	$count = $count[0];
	$last_pid = $count . "/" . $year;

	#number of current user will be an increment of 1
	$current_count = $count + 1;

	#SQL to generate total number of patients at present
	$query_two = "SELECT COUNT(pid) FROM patients;";

	#execute query_two
	$census = mysqli_query($connect, $query_two);
	$census = mysqli_fetch_array($census);
	$census = $census[0];

	$status = False;//turns condition of status to false
}

//SERVER SIDE VALIDATION WITH PHP
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


//Execute only when File is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

//array for error
$error = array();

//Health facility number
$facilityNo = $_REQUEST['facilityNo'];
//Registration number , year of registration and PID
$regNo = $_REQUEST['registrationNo'];
$yearOfReg =  $_REQUEST['year'];
$pid = $_REQUEST['pid'];

//Date of registration
$day = $_REQUEST['day'];
$month = $_REQUEST['month'];
$dateOfRegistration = $yearOfReg . '-' . $month . '-' . $day;

//Validating names
//First name
$firstname = inputVal($_REQUEST['firstName']);
$error['firstName'] = nameVal($firstname);
//Middlename
#initial declaration of error of middlename
$error['middleName'] = "";
if(empty($_REQUEST['middleName'])) {
	$middlename = "";}
else {
	$middlename = inputVal($_REQUEST['middleName']);
	$error['middleName'] = nameVal($middlename);}
//Lastname
$surname = inputVal($_REQUEST['surname']);
$error['surname'] = nameVal($surname);
/*Prepare name in one varable for storage in the database */
$name = $surname . " " .  $middlename . " " . $firstname;

//Date of birth
$dateOfBirth = $_REQUEST['dateOfBirth'];

//educational level
$educationalLevel = $_REQUEST['educationalLevel'];
//Age in year or in month
#initial declaration of month age and year age
$monthAge = "";
$yearAge = "";
if (!empty($_REQUEST['ageBox'])){
  $monthAge = $_REQUEST['monthAge'];
  $yearAge = "-1";
}
else { $yearAge = $_REQUEST['yearAge'];
$monthAge = "-1";
 }

//Gender
$gender = $_REQUEST['sex'];

//Marital status, validation for checkboxes and other information
#initial declaration of error of otherInfoError

if (!empty($_REQUEST['status'])){
  $maritalStatus = $_REQUEST['otherInfo'];
  $maritalStatus = inputVal($maritalStatus);
  

}
else { $maritalStatus = $_REQUEST['maritalStatus'];}


  //Addresses
  $homeAddress = inputVal($_REQUEST['homeAddress']);  
  $postalAddress = inputVal($_REQUEST['postalAddress']); 
  $locality = inputVal($_REQUEST['locality']);

//Occupation
$occupation = inputVal($_REQUEST['occupation']);

//Mobile contacts
//telephone a
$tel_a = $_REQUEST['telephone'];
//telephone b
if(empty($_REQUEST['telephone-2'])) {
$tel_b = "";}
else{
$tel_b = $_REQUEST['telephone-2'];
} //Telephone for storage in the database
$tel = $tel_a . " " . $tel_b;

//religion
$religion = $_REQUEST['religion'];

//name and address of relative
$nameOfRelative = inputVal($_REQUEST['nameOfRelative']);


$addressOfRelative = inputVal($_REQUEST['relativeAddress']);

/*If the insured checkbox is ticked, then it means patient is not insured, else patient is insured*/

#initial declration of errors
$error['nameOfScheme'] = "";
if (isset($_REQUEST['insured']) && (!empty($_REQUEST['insured']))){
#all info about insurance is empty and insurance state becomes not insured
$nameOfScheme = "";
$expDate = "";
$insuranceNumber = "";
$schemeId = "";

$insuranceState = "Not Insured";

} else {
	//Information about the scheme
	$nameOfScheme = inputVal($_REQUEST['nameOfScheme']);
	$error['nameOfScheme'] =  nameVal($nameOfScheme);

	//expiry Date
	$expDate = $_REQUEST['expDate'];

	//insurance number
	$insuranceNumber = $_REQUEST['insuranceNo'];

	//scheme id
	$schemeId = $_REQUEST['schemeID'];
	/*Insurance state will be stored in a different table*/
	$insuranceState = "Insured";
}
//END OF SERVER SIDE VALIDATION WITH PHP

}

?>



<!DOCYTYPE html>
<html lang = "en">
<head>
    <title>Registration Page</title>
    <link href="../css/registration.css" rel="stylesheet" >
    <link href="../css/jquery-ui.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src = "../js/getTime.js"></script>
    <script src = "../js/jquery.validate.min.js"></script>

	  <style>

	.autocomplete {
	position: absolute;
	margin-top: 0;
	border: 1px silver solid;
	width: 200px;
	padding-left: 0;
	margin-left: 0;
	background-color: teal;
	font-size:19px;
	cursor: hand;
	}

	li {

	list-style-type: none;
	margin-left: 0;
	border: 1px teal solid;
	}


	li:hover {
	-webkit-transform: scale(1.02);
	transform: scale(1.02);
	border: 1px orange solid;
	color: orange;
	background-color: #fff;
	}
  input[name='searchTerm'] {
  	font-size: 19px;
  }

	.selected {
	background-color: blue;
	color: #fff;
	}
	</style>
<script>
$(document).ready(function(){

	/*CODES FOR SEARCH BOX MECHANISM*/
//Disable search text default autocomplete
$("#searchAjax").attr('autocomplete', 'off');

//function for the enter key
var populateSearchField = function() {
$('#searchAjax').val($autocomplete
.find('li').eq(selectedItem).text());
setSelectedItem(null);
};


//Keeping track of selected items
var selectedItem = null;
var setSelectedItem = function(item) {
selectedItem = item;
if (selectedItem === null) {
$autocomplete.hide();
return;
}
if (selectedItem < 0) {
selectedItem = 0;
}
if (selectedItem >= $autocomplete.find('li').length) {
selectedItem = $autocomplete.find('li').length - 1;
}
$autocomplete.find('li').removeClass('selected')
.eq(selectedItem).addClass('selected');
$autocomplete.show();
};

var $autocomplete = $('<ul class="autocomplete"></ul>').hide().insertAfter('#searchAjax');
$('#searchAjax').keyup(function() {
if (event.keyCode > 40 || event.keyCode == 8) {
// Keys with codes 40 and below are special
// (enter, arrow keys, escape, etc.).
// Key code 8 is backspace.


$.ajax({
'url': '../php/search.php',
'data': {'search-text': $('#searchAjax').val()},
'dataType': 'json',
'type': 'POST',
'success': function(data) {
if (data.length) {
$autocomplete.empty();
$.each(data, function(index, term) {

$('<li></li>').text(term).appendTo($autocomplete).mouseover(function() {
setSelectedItem(index);
}).click(function() {

$('#searchAjax').val(term);
$autocomplete.hide();
});

});//ends each
setSelectedItem(0);
}
else {
setSelectedItem(null);
}

//$autocomplete.show();


}//ends success
});//ends ajax

}
else if (event.keyCode == 38 && selectedItem !== null) {
// User pressed up arrow.
setSelectedItem(selectedItem - 1);
event.preventDefault();
}
else if (event.keyCode == 40 && selectedItem !== null) {
// User pressed down arrow.
setSelectedItem(selectedItem + 1);
event.preventDefault();
}
else if (event.keyCode == 27 && selectedItem !== null) {
// User pressed escape key.
setSelectedItem(null);
}
}).keypress(function(event) {
if (event.keyCode == 13 && selectedItem !== null) {
// User pressed enter key.
populateSearchField();
event.preventDefault();
}
}).blur(function(event) {
setTimeout(function() {
setSelectedItem(null);
}, 250);
});
/*END OF SEARCH BOX MECHANISM*/

  //function for validation
  function validation(defaultText, errorMessage, tag, errorTag){
    if($(tag).val() == defaultText){
    $(errorTag).text(errorMessage);
    }//checks automatically and alerts for error

    $(tag).change(function(){
     if ($(this).val() == defaultText){
        $(errorTag).text(errorMessage)
      } else {$(errorTag).text(' '); }
    });
    //alerts for error only if change effect has been made
  }
  //Button for for form validation-client side with Javascript
  //validation for insurance number, if the length is less than or more than 8 characters, display error
  $("#insuranceNo").blur(function(){
    if($(this).val().length < 8 || $(this).val().length > 8){
      $("#error4").text("Character should be 8!");
    } else {
      $("#error4").text(" ");
    }
  }); //end of validation for inusrance number

  //Validatioon for scheme id, if the length is less than or more than 13 characters, display error
  $("#schemeId").blur(function(){
    if($(this).val().length < 13 ||  $(this).val().length > 13){
      $("#error5").text("Character should be 13!");
    } else {
      $("#error5").text(" ");
    }
  }); //end of the validation for scheme id
//Other forms of validation...validation for year

validation("--year--", "Select a year", "#year", "#error");
//ends year validation
validation("--choose a level--", "Select level", "#level", "#error1"); //ends validation for educational level
validation("-- choose gender --", "Select gender", "#gender", "#error2"); //ends validation for gender
validation("--choose a religion--", "Select religion", "#religion", "#error3"); //ends validation for religion

//Take values from Registration number and Year to form PID no.
 $("#pid").focus(function(){
  var number = $('input[name="registrationNo"]').val();
  var year = $('select[name="year"] :selected').val();
  $(this).val(number+ '/' + year);
});//end pid value setting

//if age is in months or in years
$('input[name="monthAge"]').prop('disabled', true).hide(); //Disabled by default until the checkbox is checked
$('#month').hide(); //hide "month years old."
$('input[name="ageBox"]').click(function(){
  $('input[name="monthAge"]').prop('disabled', false).toggle(); //shows or hides hidden inputs when checked
  $('#month').toggle(); //shows or hides hidden text when checked
//if month input box and "months old." is visible, then years input and "years old " should be disabled and disapper
  if($('input[name = "monthAge"]').is(':visible') && $('#month').is(':visible')){
    $('input[name="yearAge"]').prop('disabled', true).hide();
    $('#years').hide();
  }
  else {$('input[name="yearAge"]').prop('disabled', false).show();
  $('#years').show();
}
});//ends the month and year age

/*If patient is not insured, disable the input boxes related to accepting information on insurance*/
$("input[name='insured']").click(function(){
  if($(this).is(':checked')){
    $("input[name='nameOfScheme']").prop('disabled', true); //disable insurance name
    $("input[name='expDate']").prop('disabled', true); //disable insurance expiry date
    $("input[name='insuranceNo']").prop('disabled', true); //disable insurance number
    $("input[name='schemeID']").prop('disabled', true); //disable insurance scheme id
  }
  else {
    $("input[name='nameOfScheme']").prop('disabled', false); //enable insurance name
    $("input[name='expDate']").prop('disabled', false); //enable insurance expiry date
    $("input[name='insuranceNo']").prop('disabled', false); //enable insurance number
    $("input[name='schemeID']").prop('disabled', false); //enable insurance scheme id
  }

}); //end of insured check box

//if any of the marital status is checked, Other information should be disabled
$('#Info').hide();
$('textarea[name="otherInfo"]').hide(); //hide label and input box by default
$('input[name="status"]').click(function(){
  $('textarea[name="otherInfo"]').toggle();
  $('#Info').toggle();

  if($('textarea[name="otherInfo"]').is(':visible') && $('#Info').is(':visible')){
    $('#smdw').hide();
  } else { $('#smdw').show();}
});//ends marital status and other information
//hiding the search dialog box until the search menu is clicked
$(".searchBox").hide();
$("#search").click(function(){
  $(".searchBox").slideToggle();
  if(!$(this).prop(":hidden")){
    $("#searchAjax").val('').focus();
  }
});//end of searh Box



  //setting the time
  function displayTime() {
		$('#time').text(getTime(true));
	}
	displayTime();
	setInterval(displayTime,1000);//End of time
  //Button for Home menu
$('#registration').button({
icons : {
primary : 'ui-icon-home'
}
});//End of button for home menu

//Button for search menu
$('#search').button({
icons : {
primary : 'ui-icon-search'
}
});//End of button for search menu

//Button for Patient info menu
$('#info').button({
icons : {
primary : 'ui-icon-info'
}
});//End of button for info menu
//Logut button
$('#logout').button({
	icons: {
		primary: "ui-icon-circle-minus"
	}
}); //end of logut button

//Edit profile button
$("#editProfile").button({
	icons : {
	primary : 'ui-icon-info'
	}
});//end of edit profile button
//Medical report profile
$("#medReport").button({
	icons : {
	primary : 'ui-icon-info'
	}
});//end of medical report button
}); // end ready
    </script>
  </head>
  <body class = "home">
    <!--The header contains the logo , name of the hospital, current date and time. -->
      <!--   <header class =  "header">
           GOD'S GRACE MATERNITY CLINIC

         </header>-->

           <!--The aside contains the menu options-->
					 <div id = "timeDetails">
						<strong id = "time">Time:</strong><!--Continuos time--><br>
						<strong id = "date"><?php echo date('d M Y'); ?></strong><!--Day name, month name, year-->
					</div>
						<aside>
						 <button id = "registration"><a href = "registration.php" title =  "Home: click to refresh">Patient Registration</a></button>
							
								<button id = "medReport"><a href = "gen_report.php">Print Medical Report</a></button>
								<button id = "logout"><a href = "../php/sign_out.php">System Sign Me Out</a></button>
						 <button id = "search">Patient Search Box</button>

					</aside>

                    <!--This is the box for search-ability-->
                    <div class = "searchBox">
                      <form action = "../php/search_retrieve.php" method = "POST" id = "searchRequest">
                      <input type = "text" name = "searchTerm" placeholder="Surname or PID number" id = "searchAjax" /><br>
                     <input type = "submit" value = "Search" />
					<!-- <button id = "searchRequestButton">Search</button>-->
					 </form>
                    </div>

    <!--The section contains the form details -->

          <!--The form tag that holds all the form details-->

          <section>
            
            <h3>Patient Registration Form</h3>
<!--This section is a php code that displays the last inserted pid and the total number of patients that have visited the hospital since the beginning of the use of the software-->
<p>Last Registered Patient:<?php if(isset($last_pid)) echo ' <span class = "figures">'. $last_pid . '</span> '; ?>Total Number of Registered Patients:<?php if(isset($census)) echo ' <span class = "figures">'. $census . '</span>'; ?> </p>



          <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" id ="register">
                <!--Contains half of the Patient Information-->
                <nav class = "left">
                      <fieldset >
                          	<legend>Registration Info</legend>
                            <label for = "facility no">Health Facility No: </label>
                            <input type = "text" name="facilityNo" min = "6" max = "10" value = "<?php if(isset($facilityNo)) echo $facilityNo;?>" placeholder = "You can ignore this field." autofocus /><br>

														<label for = "date of registration">Date of Registration: </label>
															<input type = "number" min = "1" max = "31" name = "day" required />-
															<select name = "month" class = "month" required>
																
																 <option name = "month" value = "1">January</option>
																	<option name = "month" value = "2">February</option>
																	 <option name = "month" value = "3">March</option>
																		<option name = "month" value = "4">April</option>
																		 <option name = "month" value = "5">May</option>
																			<option name = "month" value = "6">June</option>
																			 <option name = "month" value = "7">July</option>
																	 <option name = "month" value = "8">August</option>
																	 <option name = "month" value = "9">September</option>
																	 <option name = "month" value = "10">October</option>
																	 <option name = "month" value = "11">November</option>
																	 <option name = "month" value = "12">December</option>
																</select><br>

                            <label for ="registration no">Registration no: </label>
                            <input type = "number" name = "registrationNo" min = "1" id = "number" value = "<?php if(isset($current_count)) echo $current_count;?>" required /> /
                            <select name = "year" id = "year">
                              <option>--year--</option>
                              <option value = "16">16</option>
                              <option value = "17">17</option>
                              <option value = "18">18</option>
                              <option value = "19">19</option>
                              <option value = "20">20</option>
                            </select><em id = "error" class = "error"></em>
                            <br>
                            <label for = "pid">PID no: </label>
                            <input type = "text" name = "pid" id = "pid" placeholder = "Click to generate pid" required /><br>
                        </fieldset><br>
                        <fieldset >
                              <legend>Personal Info</legend>
							  <em class = "nameInfo">Name should not contain symbols such as ' and /.</em><br>
                              <label for = "firstName">Surname: </label>
                              <input name="surname" type="text" placeholder="Begin with Capital letter" required /><span class = "error"><?php if(isset($error['surname'])) echo $error['surname'];?></span><br>
                              <label for = "middle name">Middle name<em>(If any)</em>: </label>
                              <input name="middleName" type="text" placeholder="Begin with Capital letter"  /><span class = "error"><?php if(isset($error['middleName'])) echo $error['middleName'];?></span><br>
                              <label for = "first name">First name: </label>
                              <input name="firstName" type="text" placeholder="Begin with Capital letter"   required/><span class = "error"><?php if(isset($error['firstName'])) echo $error['firstName'];?></span><br />
                              <label for ="date of birth">Date of Birth: </label>
                              <input name="dateOfBirth" type="date"  required id = "dateOfBirth" /><br>
                              <label for ="educational level">Educational Level: </label>
                              <select required id = "level" name = "educationalLevel">
                                <option>--choose a level--</option>
                                <option value = "NON FORMAL" name = "educationalLevel">NON FORMAL</option>
                                <option  name="educationalLevel"value="PRIMARY" >PRIMARY</option>
                                <option  name="educationalLevel" value="JSS/SHS">JHS/SHS</option>
                                <option  name="educationalLevel"value="MSLC">MSLC</option>
                                <option name="educationalLevel" value="SSS/SHS">SSS/SHS</option>
                                <option  name="educationalLevel" value="TECHNICAL">TECHNICAL</option>
                                <option  name="educationalLevel" value="TERTIARY">TERTIARY</option>
                              </select><em id = "error1" class = "error"></em><br>

                              <!--If patient is less than a year, check box should be ticked to select month-->
                              <input type = "checkbox" name = "ageBox" /><em class = "ageInfo">Tick if patient is less tha a year old. If patient is 0-28days old, select 0 months</em><br>
                              <label>Age: </label>
                              <input name="yearAge" type="number" min = "1" max = "100" /><span id = "years">years old.</span>
                              <input type = "number" min = "0" max = "11" name = "monthAge" /> <span id = "month">months old.</span><br>
                              <label>Sex: </label>
                            <select required id = "gender" name = "sex">
                              <option>-- choose gender --</option>
                              <option name = "sex" value = "M">MALE</option>
                              <option name = "sex" value =  "F">FEMALE</option>
                            </select><em id = "error2" class = "error"></em>
                          </fieldset>

                        <fieldset ><legend>Marital Status</legend>
                          <span class = "status"><input type = "checkbox" name = "status" /><em class = "status">Tick if other information is needed</em></span><br>

                            <div id = "smdw">
                        <input name="maritalStatus" type="radio" value="Single" />Single
                        <input name="maritalStatus" type="radio" value="Married" /> Married
                        <input name="maritalStatus" type="radio" value="Divorced" />Divorced
                        <input name="maritalStatus" type="radio" value="Widowed" />Widowed
                      </div>
                      <br />
                          <label for = "other info" id = "Info">Other Information: </label>
                            <textarea name="otherInfo" cols="20" rows="4" placeholder="Other information not more than 100 characters..." ></textarea>
                      </fieldset><br>




                </nav>
                <nav class = "right">

                  <fieldset ><legend>Address and Other Info</legend>
                    <label for = "postal address">Postal Address: </label>
                    <input name="postalAddress" type="text" placeholder="Not more than 50 characters..."  /><br>
                    <label for = "house address">Address (House No): </label>
                    <textarea name="homeAddress" cols="20" rows="4" placeholder="Home Address not more than 50 characters..." ></textarea><br />
                    <label for = "locality">Locality: </label>
                    <input name="locality" type="text" placeholder="Locality"/><br>
                    <label for = "telephone">Telephone: </label>
                    <input name="telephone" type="text" pattern="[0-9]{10}" placeholder="xxx-xxxxxxx" required title = "Number should be 10 digits." /><br />
                    <label for = "telephone2">Telephone<em>(If any)</em>: </label>
                    <input type = "text" name = "telephone-2" pattern="[0-9]{10}" placeholder="xxx-xxxxxxx" title = "Number should be 10 digits."  /> <br />
                    <label for = "occupation">Occupation<em>(If any)</em>: </label>
                    <input name="occupation" type="text" placeholder="Occupation"><br>
                    <label for = "religion">Religion: </label>
                    <select id = "religion" name = "religion" required>
                      <option>--choose a religion--</option>
                      <option value = "Christianity" name = "religion">CHRISTIANITY</option>
                      <option value = "Islam" name = "religion">ISLAM</option>
                      <option value = "Traditional" name = "religion">TRADITIONAL</option>
                    </select><em id = "error3" class = "error"></em>

                        <br />
                    <label for = "name of relative">Name of Nearest relative: </label>
                    <input name="nameOfRelative" type="text" required placeholder="Name" max = "100" /><br>
                    <label for = "contact address">Contact Address: </label>
                    <textarea name="relativeAddress" cols="20" rows="5" placeholder="Contact Address" ></textarea><br />

                    <input type = "checkbox" name = "insured" /><em class = "insured">Tick if patient is not insured</em><br>
                    <label for = "name of scheme">Name of Scheme: </label>
                    <input name="nameOfScheme" type="text" value = "NHIS"/><span class = "error"><?php if(isset($error['nameOfScheme'])) echo $error['nameOfScheme'];?></span><br>
                    <label for = "expiry date">Expiry Date of Insurance Card: </label>
                    <input name="expDate" type="date" /><br />
                    <label>Insurance No: </label>
                    <input name="insuranceNo" type="text" pattern = "[0-9]{8}" id = "insuranceNo" required/><em id = "error4" class = "error"></em>
                    <br>
                    <label for = "scheme id">Scheme Identification No: </label>
                    <input name="schemeID" type="text" placeholder="ID No" pattern = "[0-9A-Z]{13}" id = "schemeId" required/><em id = "error5" class = "error"></em>
                    <br><br>
                      <div class = "controls">
                      <input name="reset" type="reset" value="Reset" />
                   <input name="submit" type="submit" value="Register" />
                 </div>
                </fieldset>
              </nav>
          </form>

        </section>

      </body>
      <footer></footer>
</html>
<?php
			//VERIFYING THE POSSIBILITY OF ERROR, IF THERE IS AN ERROR, SUBMISSION STOPS AND THE ERROR
			//PRINTED ON THE SCREEN  ELSE INFORMATION IS SENT INTO THE DATABASE
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		//INFORMATION WILL ONLY BE SENT IF THERE IS NO ERROR
	if( ($error['firstName'] == "") && ($error['middleName'] == "") && ($error['surname'] == "") && ($error['nameOfScheme'] == "") ){
//using database credentials, files can be stored into the DATABASE
// Handle user request
$insert_sql = sprintf("INSERT INTO patients (pid, reg_no, year_of_reg, date_of_reg, name, educational_level, date_0f_birth," .
											"month_age, year_age, gender, marital_status, home_address, postal_address," .
											"locality, occupation, tel, religion, name_of_relative, address_of_relative," .
											"exp_date, insurance_number, scheme_id, insurance_state, month_of_reg) " .
"VALUES ('%s','%d', '%d', '%s','%s', '%s', '%s', '%d','%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s', '%d');",
						mysqli_real_escape_string($connect, $pid), $regNo, $yearOfReg,
						mysqli_real_escape_string($connect, $dateOfRegistration),
						mysqli_real_escape_string($connect, $name),
						mysqli_real_escape_string($connect, $educationalLevel), $dateOfBirth, $monthAge, $yearAge,
						mysqli_real_escape_string($connect, $gender),
						mysqli_real_escape_string($connect, $maritalStatus),
						mysqli_real_escape_string($connect, $homeAddress),
						mysqli_real_escape_string($connect, $postalAddress),
						mysqli_real_escape_string($connect, $locality),
						mysqli_real_escape_string($connect, $occupation),
						mysqli_real_escape_string($connect, $tel),
						mysqli_real_escape_string($connect, $religion),
						mysqli_real_escape_string($connect, $nameOfRelative),
						mysqli_real_escape_string($connect, $addressOfRelative), $expDate,
						mysqli_real_escape_string($connect, $insuranceNumber),
						mysqli_real_escape_string($connect, $schemeId), $insuranceState, $month);

//Insert the user into the databse
$result = mysqli_query($connect, $insert_sql);
if($result){

#alert the user that the account has been successfully created for patient
echo '<p class = "accountCreated">Account Created! Click "Patient Registration" menu to refresh page!</p>';

} else {
	/*echo ('<p class = "accountError">Error in submitting form! ' . mysqli_error($connect) . '</p>' );*/
}

}//end of error
else {
	echo '<p class = "accountError">Error in submitting form! Refill the form and correct the errors.</p>';
	//When erros are found in the submission, this should be allerted to the user
}

}//end of self submission

?>
