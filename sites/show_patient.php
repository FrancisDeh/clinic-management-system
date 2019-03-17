<?php
require_once "../php/est_connect.php";
require_once "../php/authorize_settings.php";

//Authorize any user before they can access this page and if pid is not provided, take back to previous page
authorize_user();

//Get the user ID of the user to show
if(isset($_REQUEST['pid'])){
$pid = $_REQUEST['pid'];}
else { $pid = 0;}//let pid be 0 if it is not set, then the later codes will alert user to provide a valid pid



//use the pid to get patient information
//Build the select statement
$select_query = sprintf("SELECT * FROM patients WHERE pid = %d", $pid);
//Run the query
$result = mysqli_query($connect, $select_query);
if (mysqli_num_rows($result) === 1) {
	$row = mysqli_fetch_array($result);
	$pid = $row['pid'];
  $regNo =  $row['reg_no'];
  $yearOfReg = $row['year_of_reg'];
  $dateOfRegistration = $row['date_of_reg'];
  $name = $row['name'];
  $educationalLevel = $row['educational_level'];
  $dateOfBirth = $row['date_0f_birth'];
  $monthAge = $row['month_age'];
  $yearAge = $row['year_age'];

	//if month age is empty, display year age and vice versa
	if($monthAge == -1){
		$age = $yearAge . " yr(s)";
	} else if($monthAge == 0){
		$age = $monthAge . " - 28 days";
	} else {
	$age = $monthAge . " month(s)";}
	//end of age conditionals

  $gender = $row['gender'];
  $maritalStatus = $row['marital_status'];
  $homeAddress = $row['home_address'];
  $postalAddress = $row['postal_address'];
  $locality = $row['locality'];
  $occupation = $row['occupation'];
  $tel = $row['tel'];


  $religion = $row['religion'];
  $nameOfRelative = $row['name_of_relative'];
  $addressOfRelative  = $row['address_of_relative'];

	/*If insurace information are empty, patient is not insured*/
$insuranceState = $row['insurance_state'];
	$expDate  = $row['exp_date'];

$insuranceNumber  = $row['insurance_number'];

$schemeId = $row['scheme_id'];


}
else {
	/*alert user that the pid provided is not valid*/
	echo '<p class = "pidError">Please provide a valid PID number!</p>';
}

 ?>
 <!--HTML GOES HERE-->
 <!DOCYTYPE html>
<html lang = "en">
<head>
    <title>Show Patient</title>
    <link href="../css/show_patient.css" rel="stylesheet" >
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
	width: 250px;
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
  //hiding the search dialog box until the search menu is clicked
  $(".searchBox").hide();
  $("#search").click(function(){
    $(".searchBox").slideToggle();
    if(!$(this).prop(":hidden")){
      $("#searchAjax").val('').focus();
    }
  });//end of searh Box

	/*Click the plus sign and it opens insurance dialog box*/
	  $('#plus_sign').click(function(){
	    $('#insuranceDialog').dialog('open');
	  });//end of plus sign click
	  //Code for dialog box for insurance
	    $('#insuranceDialog').dialog({
	    	autoOpen: false,
	    	modal: true,
	    	resizable: false,
	    	draggable: true,
	    	hide: { effect: 'explode', delay: 100, duration: 1000, easing:
	    'easeInQuad' },
	    show: 'slideDown',
	    buttons : {
	    "Cancel" : function() {
	    	$(this).dialog('close');
	    }
	    } // end buttons

	    });//end of dialog


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
  
  //When the Patient Information Button is been clicked, the form should be reloaded with the patient pid
  $("#info").click(function(){
	  if($("#pidNumber").val() != 0){
		  var pid = $("#pidNumber").val();
		  var extLink = $('a[href^="show_patient"]').attr('href');
		  var newLink = extLink + "?pid=" + pid;
		  $('a[href^="show_patient"]').attr('href', newLink);
	  }//end of if
  });//end of click

  }); // end ready
      </script>
    </head>
    <body>
      <!--The aside contains the menu options-->
                <div id = "timeDetails">
                 <strong id = "time">Time:</strong><!--Continuos time--><br>
                 <strong id = "date"><?php echo date('d M Y'); ?></strong><!--Day name, month name, year-->
               </div>
                 <aside>
                  <button id = "registration"><a href = "registration.php">Patient Registration</a></button>
                     <button id = "info"><a href = "show_patient.php">Patient Information</a></button>
                     <button id = "medReport"><a href = "gen_report.php">Print Medical Report</a></button>
                     <button id = "logout"><a href = "../php/sign_out.php">System Sign Me Out</a></button>
                  <button id = "search">Patient Search Box</button>

               </aside>
               <!--This is the box for search-ability-->
               <div class = "searchBox">
                 <form action="../php/search_retrieve.php" method = "POST">
                 <input type = "text" name = "searchTerm" placeholder="Enter Name or PID no" id = "searchAjax" /><br>
                 <input type = "submit" value = "Search" />
				</form>
               </div>
  <section>
  <img class = "patient_pic" src = "../images/patient_pic.jpg">
      <h3>Patient Information</h3>

      <table width="1000" border="1">

				<tr>
					<td class = "constantLabels">Insurance State <img id = "plus_sign" src = "../images/plus_a.png" title = "Click to insure non-insured patient"></td>
					<td class = "constantLabels" colspan="2">Name Of Patient</td>
					<td class = "constantLabels">Registration Date(Y,M,D)</td>
					<td class = "constantLabels">PID number </td>
					<td  class = "constantLabels">Date of Birth(Y,M,D)</td>
				</tr>
				<tr>
					<td><?php if(isset($insuranceState)) echo $insuranceState; ?></td>
					<td colspan="2"><?php if(isset($name)) echo $name;  ?></td>
					<td><?php if(isset($dateOfRegistration)) echo $dateOfRegistration; ?></td>
					<td ><?php if(isset($pid)) echo $pid; ?></td>
					<td><?php if(isset($dateOfBirth)) echo $dateOfBirth;  ?></td>
				</tr>
				<tr>
					<td class = "constantLabels">Age</td>
					<td class = "constantLabels" colspan="2">Relative Name</td>
					<td class = "constantLabels">Gender</td>
					<td class = "constantLabels">Educational Level</td>
					<td class = "constantLabels">Postal Address</td>
				</tr>
				<tr>
					<td ><?php if(isset($age)) echo $age; ?></td>
					<td colspan="2"><?php if(isset($nameOfRelative)) echo $nameOfRelative; ?></td>
					<td><?php if(isset($gender)) echo $gender;  ?></td>
					<td><?php if(isset($educationalLevel)) echo $educationalLevel; ?></td>
					<td ><?php if(isset($postalAddress)) echo $postalAddress; ?></td>
				</tr>
				<tr>
					<td class = "constantLabels">House Address</td>
					<td class = "constantLabels" colspan="2">Marital Status</td>
					<td class = "constantLabels">Locality</td>
					<td class = "constantLabels">Religion</td>
					<td class = "constantLabels">Relative's Address</td>
				</tr>
				<tr>
					<td><?php if(isset($homeAddress)) echo $homeAddress; ?></td>
					<td colspan="2"><?php if(isset($maritalStatus)) echo $maritalStatus; ?></td>
					<td ><?php if(isset($locality)) echo $locality; ?></td>
					<td><?php if(isset($religion)) echo $religion;  ?></td>
					<td ><?php if(isset($addressOfRelative)) echo $addressOfRelative; ?></td>
				</tr>
				<tr>
					<td class = "constantLabels">Occupation</td>
					<td class = "constantLabels" colspan="2">Telephone</td>
					<td class = "constantLabels">Insurance No</td>
					<td class = "constantLabels">Scheme ID No</td>
					<td class = "constantLabels">Expiry Date(Y,M,D)</td>
				</tr>
				<tr>
					<td ><?php if(isset($occupation)) echo $occupation; ?></td>
					<td colspan="2"><?php if(isset($tel)) echo $tel; ?></td>
					<td ><?php if(isset($insuranceNumber)) echo $insuranceNumber; ?></td>
					<td><?php if(isset( $schemeId)) echo  $schemeId; ?></td>
					<td><?php if(isset($expDate)) echo $expDate;  ?></td>
				</tr>
</table>
<p class = "varDates">Dates of Diagnosis(Y-M-D): <?php
/*This query selects the date of registration of the patient.*/
$select_query4 = sprintf("SELECT date_of_diagnosis FROM patient_diagnosis WHERE pid = %d", $pid);
//Run the query
$resultOfdate = mysqli_query($connect, $select_query4);
if(mysqli_num_rows($resultOfdate) > 0){
	$x = 0;
	while($result = mysqli_fetch_row($resultOfdate)){
	
foreach($result as $date){
	$x++;
	echo '<span class = "noEcho">'. $x . '.</span> ' .   '<span class = "dateEcho">'. $date . ".</span> ";
	
}
	}} else {echo '<span class = "dateEcho">None</span>';} ?></p>
<table>
  <tr>
      <th>Doctor's Diagnosis</th>
      <th>Doctor's Medication</th>
      <th>Doctor's Remarks</th>
    </tr>
    <tr>
        <td class = "previousDiagnosis">
<?php //QUERY DIAGNOSIS FROM DATABASE AND DISPLAY IF NOT EMPTY
//This query selects all diagnosis from
$select_query = sprintf("SELECT diagnosis FROM patient_diagnosis WHERE pid = %d", $pid);
$resultOfdiagnosis = mysqli_query($connect, $select_query);
if(mysqli_num_rows($resultOfdiagnosis) > 0){
	$x = 0;
	while($result = mysqli_fetch_row($resultOfdiagnosis)){
	
	$numOfRows = mysqli_num_rows($resultOfdiagnosis); //The number of results doctor should expect
	foreach($result as $value){
		$x++;
		echo '<span class = "report">' .'<span class = "noEcho">'. $x . '</span>. ' . $value .'</span><br>';
		
	}}
	mysqli_free_result($resultOfdiagnosis);
}
else {
	echo '<span class = "report">There are no Diagnosis.</span><br>';
	
}//end of diagnosis
?>
</td>
      <td class = "previousDiagnosis">
	  <?php
	  /*select query for medication from diagnosis table*/
$select_query2 = sprintf("SELECT medication FROM patient_diagnosis WHERE pid = %d", $pid);
$resultOfmedication = mysqli_query($connect, $select_query2);
if(mysqli_num_rows($resultOfmedication) > 0){
	$x = 0;
	while($result = mysqli_fetch_row($resultOfmedication)){
	
	foreach($result as $value){
		$x++;
		echo '<span class = "report">' .'<span class = "noEcho">'. $x . '</span>. ' . $value .'</span><br>';
		
	}}
	mysqli_free_result($resultOfmedication);
} else {
	echo '<span class = "report">There are no Medications.</span><br>';
}//end of medication
?>
	  </td>
    <td class = "previousDiagnosis">
	<?php
	/*This query selects the remarks by doctor from the diagnosis table*/
$select_query3 = sprintf("SELECT remarks FROM patient_diagnosis WHERE pid = %d", $pid);
//Run the query
$resultOfremarks = mysqli_query($connect, $select_query3);
if(mysqli_num_rows($resultOfremarks) > 0){
	$x = 0;
	while($result = mysqli_fetch_row($resultOfremarks)){
	
	foreach($result as $value){
		$x++;
		echo '<span class = "report">' .'<span class = "noEcho">'. $x . '</span>. ' . $value .'</span><br>';
		
	}}
	
	mysqli_free_result($resultOfremarks);
} else {
	echo '<p class = "report">There are no Remarks.</p>';
}//end of remarks
?>

	</td>
  </tr>
</table>

<!--A form to accept doctors diagnosis including month and year-->
  <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
<!--month and year-->
<label for = "date of diagnosis">Date of diagnosis: </label>
<input type = "number" min = "1" max = "31" name = "day" placeholder = "day" required>
<select name = "month" required>
		<option>--Select Month--</option>
	 <option name = "month" value = "January">January</option>
		<option name = "month" value = "February">February</option>
		 <option name = "month" value = "March">March</option>
			<option name = "month" value = "April">April</option>
			 <option name = "month" value = "May">May</option>
				<option name = "month" value = "June">June</option>
				 <option name = "month" value = "July">July</option>
		 <option name = "month" value = "August">August</option>
		 <option name = "month" value = "September">September</option>
		 <option name = "month" value = "October">October</option>
		 <option name = "month" value = "November">November</option>
		 <option name = "month" value = "December">December</option>
	</select>
	<select name = "year" id = "year" required>
		<option>--Year--</option>
		<option name = "year" value = "2016">2016</option>
		<option name = "year" value = "2017">2017</option>
		<option name = "year" value = "2018">2018</option>
		<option name = "year"  value = "2019">2019</option>
		<option name = "year" value = "2020">2020</option>
	</select>
	<label>PID</label><input type = "text" name = "pid" id = "pidNumber" value = "<?php if(isset($pid)) echo $pid; ?>">
	<br>

<table>
  <tr>
      <th>Doctor's Diagnosis</th>
      <th>Doctor's Medication</th>
      <th>Doctor's Remarks</th>
    </tr>
    <tr>

        <td class = "currentDiagnosis"><textarea name = "diagnosis" required placeholder = "Please type your diagnosis here, not more than 1000 characters...."></textarea></td>
      <td class = "currentDiagnosis"><textarea name = "medication" required placeholder = "Please type your medication here, not more than 1000 characters..."></textarea></td>
    <td class = "currentDiagnosis"><textarea name = "remarks" required placeholder = "Please type your remarks here, not more than 1000 characters...."></textarea></td>
  </tr>
</table>
<div class = "controls">
<input type = "reset" value = "Reset"/>
<input type = "submit" value = "Submit" />
</div>
</form>
  </section>
	<!--Dialog box for filling insurance related issues-->
	<div id = "insuranceDialog" title = "Insure Patient">
	    <form action = "../php/insurance.php" method = "POST">
	      <label>PID no:</label>
	      <input type = "text" name = "pid" value = "<?php if(isset($pid)) echo $pid; ?>">
	      <label>Insurance No: </label>
	      <input name="insuranceNo" type="text" pattern = "[0-9]{8}" id = "insuranceNo" value = "<?php if(isset($insuranceNumber)) echo $insuranceNumber;?>" required/>

	      <label for = "scheme id">Scheme Id No: </label>
	      <input name="schemeID" type="text" placeholder="ID No" pattern = "[0-9A-Z]{13}" id = "schemeId" value = "<?php if(isset($schemeId)) echo $schemeId;?>"required/>
	      <label for = "expiry date">Expiry Date: </label>
	      <input name="expDate" type="date" required />
	      <input name="submit" type="submit" value="Insure" />
	    </form>
	  </div>
</body>
<footer></footer>

 <?php

/*if the request has been made for the form to be submitted, accept values and enter them into the database*/

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
 //function for inputVal

 //Function for general validation
function inputVal($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
 $pid = $_REQUEST['pid'];
 $diagnosis = inputVal($_REQUEST['diagnosis']);
 $medication = inputVal($_REQUEST['medication']);
 $remarks = inputVal($_REQUEST['remarks']);
 $dayOfdiagnosis = $_REQUEST['day'];
 
 $month = $_REQUEST['month'];
 /*Switch case  to determine the integer value for each month*/
switch ($month){
  case "January":
          $month_of_diagnosis = 01;
          break;
  case "February":
          $month_of_diagnosis = 02;
          break;
  case "March":
          $month_of_diagnosis = 03;
          break;
  case "April":
          $month_of_diagnosis = 04;
          break;
  case "May":
          $month_of_diagnosis = 05;
          break;
  case "June":
          $month_of_diagnosis = 06;
          break;
  case "July":
          $month_of_diagnosis = 07;
          break;
  case "August":
          $month_of_diagnosis = 08;
          break;
  case "September":
          $month_of_diagnosis = 09;
          break;
  case "October":
          $month_of_diagnosis = 10;
          break;
  case "November":
          $month_of_diagnosis = 11;
          break;
  case "December":
          $month_of_diagnosis = 12;
          break;
  default:
  #code....
  break;
}//end of switch case

 $yrOfdiagnosis = $_REQUEST['year'];
 $dateOfDiagnosis = $yrOfdiagnosis . "-" . $month_of_diagnosis . "-" . $dayOfdiagnosis;
 

 $insert_sql = sprintf("INSERT INTO patient_diagnosis (pid, date_of_diagnosis,".
	"month_of_diagnosis, yr_of_diagnosis, diagnosis, medication, remarks) ".
 "VALUES ('%s', '%s', '%d', '%s', '%s', '%s', '%s');", $pid, $dateOfDiagnosis, $month_of_diagnosis, $yrOfdiagnosis, $diagnosis, $medication, $remarks);

//Insert the user into the databse
$output = mysqli_query($connect, $insert_sql);
if($output){
	echo '<p class = "diagSent">Diagnosis Updated!Click "Patient Information" menu to Refresh</p>';
	
}
else{
	/*echo ('<p class = "diagError">Error in submitting form! ' . mysqli_error($connect) . '</p><br>' );*/
	}

}// end of the submission of information-
?>
