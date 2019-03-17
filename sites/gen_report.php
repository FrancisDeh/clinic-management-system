<?php
require_once "../php/est_connect.php";
require_once "../php/authorize_settings.php";

//Authorize any user before they can access this page
authorize_user();


/*if form has been submitted, execute the following codes*/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];

/*Switch case  to determine the integer value for each month*/
switch ($month){
  case "January":
          $month_of_diagnosis = 1;
          break;
  case "February":
          $month_of_diagnosis = 2;
          break;
  case "March":
          $month_of_diagnosis = 3;
          break;
  case "April":
          $month_of_diagnosis = 4;
          break;
  case "May":
          $month_of_diagnosis = 5;
          break;
  case "June":
          $month_of_diagnosis = 6;
          break;
  case "July":
          $month_of_diagnosis = 7;
          break;
  case "August":
          $month_of_diagnosis = 8;
          break;
  case "September":
          $month_of_diagnosis = 9;
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

/*Switch case to determine the short suffix integer form of the year, ie 2016 = 16*/
switch ($year) {
  case '2016':
    $yr_of_reg = 16;
    break;
  case '2017':
    $yr_of_reg = 17;
    break;
  case '2018':
    $yr_of_reg = 18;
    break;
  case '2019':
    $yr_of_reg = 19;
    break;
  case '2020':
    $yr_of_reg = 20;
    break;
  default:
    # code...
    break;
}//end of switch case

/*VALUES TO POPULATE THE TABLE*/

/*ages 1 and 4 yrs*/

#insured
#new
#male
$query1 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result1 = mysqli_query($connect, $query1); #query the database
  if ($result1) {
  	$row = mysqli_fetch_array($result1);
  	$value1 = $row[0];
  }

#female
$query2 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result2 = mysqli_query($connect, $query2); #query the database
  if($result2) {
  	$row = mysqli_fetch_array($result2);
  	$value2 = $row[0];
  }

#old
#male
$query3 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));
  
  //new query should be like; p.month_of_reg < '%d' AND p.month_of_reg > '%d'; where '%d' is $month_of_diagnosis

  $result3 = mysqli_query($connect, $query3); #query the database
  if ($result3) {
  	$row = mysqli_fetch_array($result3);
  	$value3 = $row[0];
  }
#female
$query4 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),  $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result4 = mysqli_query($connect, $query4); #query the database
  if ($result4) {
  	$row = mysqli_fetch_array($result4);
  	$value4 = $row[0];
  }
#not Insured
#new
#male
$query5 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result5 = mysqli_query($connect, $query5); #query the database
  if ($result5) {
  	$row = mysqli_fetch_array($result5);
  	$value5 = $row[0];
  }

#female
$query6 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result6 = mysqli_query($connect, $query6); #query the database
  if ($result6) {
  	$row = mysqli_fetch_array($result6);
  	$value6 = $row[0];
  }

#old
#male
$query7 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result7 = mysqli_query($connect, $query7); #query the database
  if ($result7) {
  	$row = mysqli_fetch_array($result7);
  	$value7 = $row[0];
  }

#female
$query8 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 1 AND 4;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result8 = mysqli_query($connect, $query8); #query the database
  if ($result8) {
  	$row = mysqli_fetch_array($result8);
  	$value8 = $row[0];
  }

  /*total number of counts for ages 1 and 4*/
#total1 stands for total for males and total2 stands for totals for females
$total1 = $value1 + $value3 + $value5 + $value7; //ends total for male
$total2 = $value2 + $value4 + $value6 + $value8; //ends total for females
/*end of ages 1 and 4*/

/*ages 5 and 9 yrs*/

#insured
#new
#male
$query9 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result9 = mysqli_query($connect, $query9); #query the database
  if ($result9) {
  	$row = mysqli_fetch_array($result9);
  	$value9 = $row[0];
  }

#female
$query10 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result10 = mysqli_query($connect, $query10); #query the database
  if ($result10) {
  	$row = mysqli_fetch_array($result10);
  	$value10 = $row[0];
  }

#old
#male
$query11 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result11 = mysqli_query($connect, $query11); #query the database
  if ($result11) {
  	$row = mysqli_fetch_array($result11);
  	$value11 = $row[0];
  }
#female
$query12 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result12 = mysqli_query($connect, $query12); #query the database
  if ($result12) {
  	$row = mysqli_fetch_array($result12);
  	$value12 = $row[0];
  }
#not Insured
#new
#male
$query13 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result13 = mysqli_query($connect, $query13); #query the database
  if ($result13) {
  	$row = mysqli_fetch_array($result13);
  	$value13 = $row[0];
  }

#female
$query14 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result14 = mysqli_query($connect, $query14); #query the database
  if ($result14) {
  	$row = mysqli_fetch_array($result14);
  	$value14 = $row[0];
  }

#old
#male
$query15 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result15 = mysqli_query($connect, $query15); #query the database
  if ($result15) {
  	$row = mysqli_fetch_array($result15);
  	$value15 = $row[0];
  }

#female
$query16 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 5 AND 9;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result16 = mysqli_query($connect, $query16); #query the database
  if ($result16) {
  	$row = mysqli_fetch_array($result16);
  	$value16 = $row[0];
  }

  /*total number of counts for ages 5 and 9*/
#total3 stands for total for males and total4 stands for totals for females
$total3 = $value9 + $value11 + $value13 + $value15; //ends total for male
$total4 = $value10 + $value12 + $value14 + $value16; //ends total for females
/*end of ages 5 and 9*/

/*ages 10 and 14 yrs*/

#insured
#new
#male
$query17 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result17 = mysqli_query($connect, $query17); #query the database
  if ($result17) {
  	$row = mysqli_fetch_array($result17);
  	$value17 = $row[0];
  }

#female
$query18 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result18 = mysqli_query($connect, $query18); #query the database
  if ($result18) {
  	$row = mysqli_fetch_array($result18);
  	$value18 = $row[0];
  }

#old
#male
$query19 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result19 = mysqli_query($connect, $query19); #query the database
  if ($result19) {
  	$row = mysqli_fetch_array($result19);
  	$value19 = $row[0];
  }
#female
$query20 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result20 = mysqli_query($connect, $query20); #query the database
  if ($result20) {
  	$row = mysqli_fetch_array($result20);
  	$value20 = $row[0];
  }
#not Insured
#new
#male
$query21 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result21 = mysqli_query($connect, $query21); #query the database
  if ($result21) {
  	$row = mysqli_fetch_array($result21);
  	$value21 = $row[0];
  }

#female
$query22 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result22 = mysqli_query($connect, $query22); #query the database
  if ($result22) {
  	$row = mysqli_fetch_array($result22);
  	$value22 = $row[0];
  }

#old
#male
$query23 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result23 = mysqli_query($connect, $query23); #query the database
  if ($result23) {
  	$row = mysqli_fetch_array($result23);
  	$value23 = $row[0];
  }

#female
$query24 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 10 AND 14;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result24 = mysqli_query($connect, $query24); #query the database
  if ($result24) {
  	$row = mysqli_fetch_array($result24);
  	$value24 = $row[0];
  }

  /*total number of counts for ages 10 and 14*/
#total5 stands for total for males and total6 stands for totals for females
$total5 = $value17 + $value19 + $value21 + $value23; //ends total for male
$total6 = $value18 + $value20 + $value22 + $value24; //ends total for females
/*end of ages 10 and 14*/

/*ages 15 and 17 yrs*/

#insured
#new
#male
$query25 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result25 = mysqli_query($connect, $query25); #query the database
  if ($result25) {
  	$row = mysqli_fetch_array($result25);
  	$value25 = $row[0];
  }

#female
$query26 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result26 = mysqli_query($connect, $query26); #query the database
  if ($result26) {
  	$row = mysqli_fetch_array($result26);
  	$value26 = $row[0];
  }

#old
#male
$query27 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result27 = mysqli_query($connect, $query27); #query the database
  if ($result27) {
  	$row = mysqli_fetch_array($result27);
  	$value27 = $row[0];
  }
#female
$query28 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result28 = mysqli_query($connect, $query28); #query the database
  if ($result28) {
  	$row = mysqli_fetch_array($result28);
  	$value28 = $row[0];
  }
#not Insured
#new
#male
$query29 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result29 = mysqli_query($connect, $query29); #query the database
  if ($result29) {
  	$row = mysqli_fetch_array($result29);
  	$value29 = $row[0];
  }

#female
$query30 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result30 = mysqli_query($connect, $query30); #query the database
  if ($result30) {
  	$row = mysqli_fetch_array($result30);
  	$value30 = $row[0];
  }

#old
#male
$query31 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result31 = mysqli_query($connect, $query31); #query the database
  if ($result31) {
  	$row = mysqli_fetch_array($result31);
  	$value31 = $row[0];
  }

#female
$query32 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 15 AND 17;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result32 = mysqli_query($connect, $query32); #query the database
  if ($result32) {
  	$row = mysqli_fetch_array($result32);
  	$value32 = $row[0];
  }

  /*total number of counts for ages 15 and 17*/
#total7 stands for total for males and total8 stands for totals for females
$total7 = $value25 + $value27 + $value29 + $value31; //ends total for male
$total8 = $value26 + $value28 + $value30 + $value32; //ends total for females
/*end of ages 15 and 17*/

/*ages 18 and 19 yrs*/

#insured
#new
#male
$query33 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result33 = mysqli_query($connect, $query33); #query the database
  if ($result33) {
  	$row = mysqli_fetch_array($result33);
  	$value33 = $row[0];
  }

#female
$query34 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result34 = mysqli_query($connect, $query34); #query the database
  if ($result34) {
  	$row = mysqli_fetch_array($result34);
  	$value34 = $row[0];
  }

#old
#male
$query35 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result35 = mysqli_query($connect, $query35); #query the database
  if ($result35) {
  	$row = mysqli_fetch_array($result35);
  	$value35 = $row[0];
  }
#female
$query36 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result36 = mysqli_query($connect, $query36); #query the database
  if ($result36) {
  	$row = mysqli_fetch_array($result36);
  	$value36 = $row[0];
  }
#not Insured
#new
#male
$query37 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result37 = mysqli_query($connect, $query37); #query the database
  if ($result37) {
  	$row = mysqli_fetch_array($result37);
  	$value37 = $row[0];
  }

#female
$query38 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result38 = mysqli_query($connect, $query38); #query the database
  if ($result38) {
  	$row = mysqli_fetch_array($result38);
  	$value38 = $row[0];
  }

#old
#male
$query39 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result39 = mysqli_query($connect, $query39); #query the database
  if ($result39) {
  	$row = mysqli_fetch_array($result39);
  	$value39 = $row[0];
  }

#female
$query40 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 18 AND 19;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result40 = mysqli_query($connect, $query40); #query the database
  if ($result40) {
  	$row = mysqli_fetch_array($result40);
  	$value40 = $row[0];
  }

  /*total number of counts for ages 18 and 19*/
#total9 stands for total for males and total10 stands for totals for females
$total9 = $value33 + $value35 + $value37 + $value39; //ends total for male
$total10 = $value34 + $value36 + $value38 + $value40; //ends total for females
/*end of ages 18 and 19*/

/*ages 20 and 34 yrs*/

#insured
#new
#male
$query41 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result41 = mysqli_query($connect, $query41); #query the database
  if ($result41) {
  	$row = mysqli_fetch_array($result41);
  	$value41 = $row[0];
  }

#female
$query42 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result42 = mysqli_query($connect, $query42); #query the database
  if ($result42) {
  	$row = mysqli_fetch_array($result42);
  	$value42 = $row[0];
  }

#old
#male
$query43 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result43 = mysqli_query($connect, $query43); #query the database
  if ($result43) {
  	$row = mysqli_fetch_array($result43);
  	$value43 = $row[0];
  }
#female
$query44 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result44 = mysqli_query($connect, $query44); #query the database
  if ($result44) {
  	$row = mysqli_fetch_array($result44);
  	$value44 = $row[0];
  }
#not Insured
#new
#male
$query45 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result45 = mysqli_query($connect, $query45); #query the database
  if ($result45) {
  	$row = mysqli_fetch_array($result45);
  	$value45 = $row[0];
  }

#female
$query46 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result46 = mysqli_query($connect, $query46); #query the database
  if ($result46) {
  	$row = mysqli_fetch_array($result46);
  	$value46 = $row[0];
  }

#old
#male
$query47 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result47 = mysqli_query($connect, $query47); #query the database
  if ($result47) {
  	$row = mysqli_fetch_array($result47);
  	$value47 = $row[0];
  }

#female
$query48 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 20 AND 34;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result48 = mysqli_query($connect, $query48); #query the database
  if ($result48) {
  	$row = mysqli_fetch_array($result48);
  	$value48 = $row[0];
  }

  /*total number of counts for ages 20 and 34*/
#total11 stands for total for males and total12 stands for totals for females
$total11 = $value41 + $value43 + $value45 + $value47; //ends total for male
$total12 = $value42 + $value44 + $value46 + $value48; //ends total for females
/*end of ages 20 and 34*/

/*ages 35 and 49 yrs*/

#insured
#new
#male
$query49 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result49 = mysqli_query($connect, $query49); #query the database
  if ($result49) {
  	$row = mysqli_fetch_array($result49);
  	$value49 = $row[0];
  }

#female
$query50 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result50 = mysqli_query($connect, $query50); #query the database
  if ($result50) {
  	$row = mysqli_fetch_array($result50);
  	$value50 = $row[0];
  }

#old
#male
$query51 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result51 = mysqli_query($connect, $query51); #query the database
  if ($result51) {
  	$row = mysqli_fetch_array($result51);
  	$value51 = $row[0];
  }
#female
$query52 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result52 = mysqli_query($connect, $query52); #query the database
  if ($result52) {
  	$row = mysqli_fetch_array($result52);
  	$value52 = $row[0];
  }
#not Insured
#new
#male
$query53 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result53 = mysqli_query($connect, $query53); #query the database
  if ($result53) {
  	$row = mysqli_fetch_array($result53);
  	$value53 = $row[0];
  }

#female
$query54 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result54 = mysqli_query($connect, $query54); #query the database
  if ($result54) {
  	$row = mysqli_fetch_array($result54);
  	$value54 = $row[0];
  }

#old
#male
$query55 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result55 = mysqli_query($connect, $query55); #query the database
  if ($result55) {
  	$row = mysqli_fetch_array($result55);
  	$value55 = $row[0];
  }

#female
$query56 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 35 AND 49;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result56 = mysqli_query($connect, $query56); #query the database
  if ($result56) {
  	$row = mysqli_fetch_array($result56);
  	$value56 = $row[0];
  }

  /*total number of counts for ages 35 and 49*/
#total13 stands for total for males and total14 stands for totals for females
$total13 = $value49 + $value51 + $value53 + $value55; //ends total for male
$total14 = $value50 + $value52 + $value54 + $value56; //ends total for females
/*end of ages 35 and 49*/

/*ages 50 and 59 yrs*/

#insured
#new
#male
$query57 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result57 = mysqli_query($connect, $query57); #query the database
  if ($result57) {
  	$row = mysqli_fetch_array($result57);
  	$value57 = $row[0];
  }

#female
$query58 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result58 = mysqli_query($connect, $query58); #query the database
  if ($result58) {
  	$row = mysqli_fetch_array($result58);
  	$value58 = $row[0];
  }

#old
#male
$query59 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result59 = mysqli_query($connect, $query59); #query the database
  if ($result59) {
  	$row = mysqli_fetch_array($result59);
  	$value59 = $row[0];
  }
#female
$query60 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result60 = mysqli_query($connect, $query60); #query the database
  if ($result60) {
  	$row = mysqli_fetch_array($result60);
  	$value60 = $row[0];
  }
#not Insured
#new
#male
$query61 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result61 = mysqli_query($connect, $query61); #query the database
  if ($result61) {
  	$row = mysqli_fetch_array($result61);
  	$value61 = $row[0];
  }

#female
$query62 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result62 = mysqli_query($connect, $query62); #query the database
  if ($result62) {
  	$row = mysqli_fetch_array($result62);
  	$value62 = $row[0];
  }

#old
#male
$query63 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result63 = mysqli_query($connect, $query63); #query the database
  if ($result63) {
  	$row = mysqli_fetch_array($result63);
  	$value63 = $row[0];
  }

#female
$query64 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 50 AND 59;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result64 = mysqli_query($connect, $query64); #query the database
  if ($result64) {
  	$row = mysqli_fetch_array($result64);
  	$value64 = $row[0];
  }

  /*total number of counts for ages 50 and 59*/
#total15 stands for total for males and total16 stands for totals for females
$total15 = $value57 + $value59 + $value61 + $value63; //ends total for male
$total16 = $value58 + $value60 + $value62 + $value64; //ends total for females
/*end of ages 50 and 59*/

/*ages 60 and 69 yrs*/

#insured
#new
#male
$query65 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result65 = mysqli_query($connect, $query65); #query the database
  if ($result65) {
  	$row = mysqli_fetch_array($result65);
  	$value65 = $row[0];
  }

#female
$query66 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result66 = mysqli_query($connect, $query66); #query the database
  if ($result66) {
  	$row = mysqli_fetch_array($result66);
  	$value66 = $row[0];
  }

#old
#male
$query67 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result67 = mysqli_query($connect, $query67); #query the database
  if ($result67) {
  	$row = mysqli_fetch_array($result67);
  	$value67 = $row[0];
  }
#female
$query68 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result68 = mysqli_query($connect, $query68); #query the database
  if ($result68) {
  	$row = mysqli_fetch_array($result68);
  	$value68 = $row[0];
  }
#not Insured
#new
#male
$query69 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result69 = mysqli_query($connect, $query69); #query the database
  if ($result69) {
  	$row = mysqli_fetch_array($result69);
  	$value69 = $row[0];
  }

#female
$query70 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result70 = mysqli_query($connect, $query70); #query the database
  if ($result70) {
  	$row = mysqli_fetch_array($result70);
  	$value70 = $row[0];
  }

#old
#male
$query71 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result71 = mysqli_query($connect, $query71); #query the database
  if ($result71) {
  	$row = mysqli_fetch_array($result71);
  	$value71 = $row[0];
  }

#female
$query72 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age BETWEEN 60 AND 69;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result72 = mysqli_query($connect, $query72); #query the database
  if ($result72) {
  	$row = mysqli_fetch_array($result72);
  	$value72 = $row[0];
  }

  /*total number of counts for ages 60 and 69*/
#total17 stands for total for males and total18 stands for totals for females
$total17 = $value65 + $value67 + $value69 + $value71; //ends total for male
$total18 = $value66 + $value68 + $value70 + $value72; //ends total for females
/*end of ages 60 and 69*/

/*ages 70 yrs and above*/

#insured
#new
#male
$query73 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result73 = mysqli_query($connect, $query73); #query the database
  if ($result73) {
  	$row = mysqli_fetch_array($result73);
  	$value73 = $row[0];
  }

#female
$query74 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result74 = mysqli_query($connect, $query74); #query the database
  if ($result74) {
  	$row = mysqli_fetch_array($result74);
  	$value74 = $row[0];
  }

#old
#male
$query75 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result75 = mysqli_query($connect, $query75); #query the database
  if ($result75) {
  	$row = mysqli_fetch_array($result75);
  	$value75 = $row[0];
  }
#female
$query76 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result76 = mysqli_query($connect, $query76); #query the database
  if ($result76) {
  	$row = mysqli_fetch_array($result76);
  	$value76 = $row[0];
  }
#not Insured
#new
#male
$query77 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result77 = mysqli_query($connect, $query77); #query the database
  if ($result77) {
  	$row = mysqli_fetch_array($result77);
  	$value77 = $row[0];
  }

#female
$query78 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result78 = mysqli_query($connect, $query78); #query the database
  if ($result78) {
  	$row = mysqli_fetch_array($result78);
  	$value78 = $row[0];
  }

#old
#male
$query79 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result79 = mysqli_query($connect, $query79); #query the database
  if ($result79) {
  	$row = mysqli_fetch_array($result79);
  	$value79 = $row[0];
  }

#female
$query80 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.year_age >= 70;",
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result80 = mysqli_query($connect, $query80); #query the database
  if ($result80) {
  	$row = mysqli_fetch_array($result80);
  	$value80 = $row[0];
  }

  /*total number of counts for ages 70 and above*/
#total19 stands for total for males and total20 stands for totals for females
$total19 = $value73 + $value75 + $value77 + $value79; //ends total for male
$total20 = $value74 + $value76 + $value78 + $value80; //ends total for females
/*end of ages 70 and above*/

/*ages 0 to 28 days*/

#insured
#new
#male
$query81 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result81 = mysqli_query($connect, $query81); #query the database
  if ($result81) {
  	$row = mysqli_fetch_array($result81);
  	$value81 = $row[0];
  }

#female
$query82 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result82 = mysqli_query($connect, $query82); #query the database
  if ($result82) {
  	$row = mysqli_fetch_array($result82);
  	$value82 = $row[0];
  }

#old
#male
$query83 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result83 = mysqli_query($connect, $query83); #query the database
  if ($result83) {
  	$row = mysqli_fetch_array($result83);
  	$value83 = $row[0];
  }
#female
$query84 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result84 = mysqli_query($connect, $query84); #query the database
  if ($result84) {
  	$row = mysqli_fetch_array($result84);
  	$value84 = $row[0];
  }
#not Insured
#new
#male
$query85 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result85 = mysqli_query($connect, $query85); #query the database
  if ($result85) {
  	$row = mysqli_fetch_array($result85);
  	$value85 = $row[0];
  }

#female
$query86 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result86 = mysqli_query($connect, $query86); #query the database
  if ($result86) {
  	$row = mysqli_fetch_array($result86);
  	$value86 = $row[0];
  }

#old
#male
$query87 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result87 = mysqli_query($connect, $query87); #query the database
  if ($result87) {
  	$row = mysqli_fetch_array($result87);
  	$value87 = $row[0];
  }

#female
$query88 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age = 0;",//0 in month_age stands for patients between 0 to 28 days.
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result88 = mysqli_query($connect, $query88); #query the database
  if ($result88) {
  	$row = mysqli_fetch_array($result88);
  	$value88 = $row[0];
  }

  /*total number of counts for ages 0 to 28 days*/
#total21 stands for total for males and total22 stands for totals for females
$total21 = $value81 + $value83 + $value85 + $value87; //ends total for male
$total22 = $value82 + $value84 + $value86 + $value88; //ends total for females
/*end of ages 0 to 28 days*/

/*ages 1 to 11 months*/

#insured
#new
#male
$query89 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result89 = mysqli_query($connect, $query89); #query the database
  if ($result89) {
  	$row = mysqli_fetch_array($result89);
  	$value89 = $row[0];
  }

#female
$query90 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result90 = mysqli_query($connect, $query90); #query the database
  if ($result90) {
  	$row = mysqli_fetch_array($result90);
  	$value90 = $row[0];
  }

#old
#male
$query91 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result91 = mysqli_query($connect, $query91); #query the database
  if ($result91) {
  	$row = mysqli_fetch_array($result91);
  	$value91 = $row[0];
  }
#female
$query92 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result92 = mysqli_query($connect, $query92); #query the database
  if ($result92) {
  	$row = mysqli_fetch_array($result92);
  	$value92 = $row[0];
  }
#not Insured
#new
#male
$query93 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result93 = mysqli_query($connect, $query93); #query the database
  if ($result93) {
  	$row = mysqli_fetch_array($result93);
  	$value93 = $row[0];
  }

#female
$query94 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg = '%d' AND p.year_of_reg = '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year),
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result94 = mysqli_query($connect, $query94); #query the database
  if ($result94) {
  	$row = mysqli_fetch_array($result94);
  	$value94 = $row[0];
  }

#old
#male
$query95 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'M' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result95 = mysqli_query($connect, $query95); #query the database
  if ($result95) {
  	$row = mysqli_fetch_array($result95);
  	$value95 = $row[0];
  }

#female
$query96 = sprintf("SELECT COUNT(d.pid) FROM patients p, patient_diagnosis d" .  " WHERE d.pid = p.pid AND " .
" d.month_of_diagnosis = '%d' AND" .
" d.yr_of_diagnosis = '%s' AND" .
" p.insurance_state = 'Not Insured' AND " .
" p.gender = 'F' AND " .
" p.month_of_reg < '%d' AND p.month_of_reg > '%d' AND p.year_of_reg <= '%d' AND ".
" p.month_age BETWEEN 1 AND 11;",//month ages between 1 and 11
  mysqli_real_escape_string($connect, $month_of_diagnosis),
  mysqli_real_escape_string($connect, $year), $month_of_diagnosis, $month_of_diagnosis,
  mysqli_real_escape_string($connect, $yr_of_reg));

  $result96 = mysqli_query($connect, $query96); #query the database
  if ($result96) {
  	$row = mysqli_fetch_array($result96);
  	$value96 = $row[0];
  }

  /*total number of counts for ages 1 and 11 months*/
#total23 stands for total for males and total24 stands for totals for females
$total23 = $value89 + $value91 + $value93 + $value95; //ends total for male
$total24 = $value90 + $value92 + $value94 + $value96; //ends total for females
/*end of ages 1 and 11 months*/

/*Final total for each column*/
/*Total for INSURED patients*/
/*New*/
/*males*/
$total_new_insured_males = $value1 + $value9 + $value17 + $value25 + $value33 + $value41 + $value49 + $value57 + $value65 + $value73 + $value81 + $value89;

/*females*/
$total_new_insured_females = $value2 + $value10 + $value18 + $value26 + $value34 + $value42 + $value50 + $value58 + $value66 + $value74 + $value82 + $value90;

/*Old*/
/*males*/
$total_old_insured_males = $value3 + $value11 + $value19 + $value27 + $value35 + $value43 + $value51 + $value59 + $value67 + $value75 + $value83 + $value91;

/*females*/
$total_old_insured_females = $value4 + $value12 + $value20 + $value28 + $value36 + $value44 + $value52 + $value60 + $value68 + $value76 + $value84 + $value92;

/*Total for NON INSURED patients*/
/*New*/
/*males*/
$total_new_non_insured_males = $value5 + $value13 + $value21 + $value29 + $value37 + $value45 + $value53 + $value61 + $value69 + $value77 + $value85 + $value93;

/*females*/
$total_new_non_insured_females = $value6 + $value14 + $value22 + $value30 + $value38 + $value46 + $value54 + $value62 + $value70 + $value78 + $value86 + $value94;

/*Old*/
/*males*/
$total_old_non_insured_males = $value7 + $value15 + $value23 + $value31 + $value39 + $value47 + $value55 + $value63 + $value71 + $value79 + $value87 + $value95;

/*females*/
$total_old_non_insured_females = $value8 + $value16 + $value24 + $value32 + $value40 + $value48 + $value56 + $value64 + $value72 + $value80 + $value88 + $value96;

/*total male patients in all*/
$total_male = $total1 + $total3 + $total5 + $total7 +  $total9 +  $total11 + $total13 +  $total15 +  $total17 +  $total19 +  $total21 + $total23;

/*total female pateints in all*/
$total_female = $total2 + $total4 + $total6 + $total8 + $total10 + $total12 + $total14 + $total16 + $total18 + $total20 + $total22 + $total24;

/*End of total of each column*/

echo '<p class = "populate">NB: Click +, select the month and year again and populate the form to fill the blanks. Click cancel.</p>';

}//end of request
?>



<!DOCYTYPE html>
<html lang = "en">
<head>
    <title>Report Page</title>
    <link href="../css/gen_report.css" rel="stylesheet" >
    <link href="../css/jquery-ui.min.css" rel="stylesheet">
    <link rel="stylesheet" media="print" href="../css/print.css"/>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src = "../js/getTime.js"></script>
    <script src = "../js/jquery.validate.min.js"></script>
<script>
$(document).ready(function(){

  /*When the generate_menu button is clicked, a dialog box apears*/
$(".menu_button").click(function(){
  $('#reportMenu').dialog('open');
});//end of menu button

  /*Daialog box to generate content for the report to be generated*/
  //Code for dialog box
  $('#reportMenu').dialog({
  	autoOpen: false,
  	modal: true,
  	resizable: false,
  	draggable: false,
  	hide: { effect: 'explode', delay: 100, duration: 1000, easing:
  'easeInQuad' },
  show: 'slideDown',
  buttons : {
  "Cancel" : function() {
  	$(this).dialog('close');
  }
  } // end buttons

  });//end of dialog

  // create button to populate the form when clicked
    $('#populate').button({
      icons: {
          primary: "ui-icon-circle-plus"
      }
    }).click(function(event) {
event.preventDefault();
var  instituteName = $("input[name='institution']").val();
var region = $("input[name='region']").val();
var district = $("input[name='district'] ").val();
var month = $("select[name='month']").val();
var year = $("select[name='year']").val();

    $("#inst").text(instituteName).show('clip',1000).effect('highlight',1000);

    $("#reg").text(region).show('clip',1000).effect('highlight',1000);

    $("#dist").text(district).show('clip',1000).effect('highlight',1000);

    $("#mnt").text(month).show('clip',1000).effect('highlight',1000);

    $("#yr").text(year).show('clip',1000).effect('highlight',1000);


    }); // end click
/*Action when the submit button of the populate form is clicked*/
$("#populateForm").submit(function(event){
  $("#reportMenu").dialog('close');
});

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

/*Print button and click event */
$("#print").button();
$("#print").click(function(){
  $("#printBox").dialog('open');
});

/*the Print dialog box*/
$('#printBox').dialog({
  autoOpen: false,
  modal: true,
  resizable: false,
  draggable: false,
  hide: { effect: 'explode', delay: 100, duration: 1000, easing:
'easeInQuad' },
show: 'fadeIn',
buttons: {
  'OK': function(){
    $(this).dialog('close');
  }
}
});///end of the print dialog box

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
								<button id = "registration"><a href = "registration.php">Patient Registration</a></button>
								
								<button id = "medReport"><a href = "gen_report.php">Print Medical Report</a></button>
								<button id = "logout"><a href = "../php/sign_out.php">System Sign Me Out</a></button>
						</aside>
            <!--Image displays a  dialog menu that allows user to select fill in informations-->
            <div class = "menu_button">
              <img src = "../images/plus.png" title = "Click to fill the form.">
            </div>
<!--This is the dialog for the report menu generation-->
<div id = "reportMenu" title = "Provide Form Contents">
    <form id = "populateForm" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
      <label for = "institution">Name Of Institution: </label>
      <input type = "text" name = "institution" value = "God's Grace Maternity Clinic"  autofocus><br>
      <label for = "region">Region: </label>
      <input type = "text" name = "region" value = "Ashanti Region" ><br>
      <label for = "district">District: </label>
      <input type = "text" value = "Bosomtwi" name  = "district"><br>
      <label for = "month">Month: </label>
      <select name = "month" required>
          <option name = "month">--Select Month--</option>
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
        </select><br>
        <label for = "year">Year: </label>
        <select name = "year" id = "year" required>
          <option>--Year--</option>
          <option value = "2016">2016</option>
          <option value = "2017">2017</option>
          <option value = "2018">2018</option>
          <option value = "2019">2019</option>
          <option value = "2020">2020</option>
        </select><br>
        <button id = "populate">Populate Form</button><br>
        <input type = "submit" value = "Generate Report">
      </form>
    </div>


            <!--Section to contain form details and table for printing-->
            <h3>Generate Monthly Medical Report</h3>
            <section>
<!--headings for the form-->
<h4>GHANA HEALTH SERVICE</h4>
<h4>STATEMENT OF OUTPATIENTS</h4>
<span class = "fillIn">INSTITUTION: </span><span id = "inst">............................</span>
<span class = "spacious">REGION: </span><span id = "reg">..................................</span>
<span class = "spacious" id = "division">DISTRICT: </span><span id = "dist">........................</span>
<span class = "spacious">MONTH: </span><span id = "mnt">................................</span>
<span class = "spacious">YEAR: </span><span id = "yr">......</span>

<!--Table to hold the main form contents-->
<table border = "1" cell-spacing = "2" cell-padding =  "5">
    <tr>
      <th rowspan="3">AGE GROUP</th>
        <th colspan = "4">INSURED PATIENTS</th>
        <th colspan = "4">NON-INSURED PATIENTS</th>
        <th colspan = "2">TOTAL</th>
      </tr>
      <tr>
          <th colspan = "2">NEW</th>
          <th colspan = "2">OLD</th>
          <th colspan = "2">NEW</th>
          <th colspan = "2">OLD</th>
          <th colspan="2"></th>
        </tr>
        <tr>
            <th>MALE</th>
            <th>FEMALE</th>
            <th>MALE</th>
            <th>FEMALE</th>
            <th>MALE</th>
            <th>FEMALE</th>
            <th>MALE</th>
            <th>FEMALE</th>
            <th>MALE</th>
            <th>FEMALE</th>
          </tr>
          <tr>
              <td class = "title">0 - 28 DAYS</td>
              <td><?php if(isset($value81)) echo $value81;?></td>
              <td><?php if(isset($value82)) echo $value82;?></td>
              <td><?php if(isset($value83)) echo $value83;?></td>
              <td><?php if(isset($value84)) echo $value84;?></td>
              <td><?php if(isset($value85)) echo $value85;?></td>
              <td><?php if(isset($value86)) echo $value86;?></td>
              <td><?php if(isset($value87)) echo $value87;?></td>
              <td><?php if(isset($value88)) echo $value88;?></td>
              <td><?php if(isset($total21)) echo $total21;?></td>
              <td><?php if(isset($total22)) echo $total22;?></td>
            </tr>
            <tr>
                <td class = "title">1 - 11 MONTHS</td>
                <td><?php if(isset($value89)) echo $value89;?></td>
                <td><?php if(isset($value90)) echo $value90;?></td>
                <td><?php if(isset($value91)) echo $value91;?></td>
                <td><?php if(isset($value92)) echo $value92;?></td>
                <td><?php if(isset($value93)) echo $value93;?></td>
                <td><?php if(isset($value94)) echo $value94;?></td>
                <td><?php if(isset($value95)) echo $value95;?></td>
                <td><?php if(isset($value96)) echo $value96;?></td>
                <td><?php if(isset($total23)) echo $total23;?></td>
                <td><?php if(isset($total24)) echo $total24;?></td>
              </tr>
              <tr>
                  <td class = "title">1 - 4 YEARS</td>
                  <td><?php if(isset($value1)) echo $value1; ?></td>
                  <td><?php if(isset($value2)) echo $value2; ?></td>
                  <td><?php if(isset($value3)) echo $value3; ?></td>
                  <td><?php if(isset($value4)) echo $value4; ?></td>
                  <td><?php if(isset($value5)) echo $value5; ?></td>
                  <td><?php if(isset($value6)) echo $value6; ?></td>
                  <td><?php if(isset($value7)) echo $value7; ?></td>
                  <td><?php if(isset($value8)) echo $value8; ?></td>
                  <td><?php if(isset($total1)) echo $total1; ?></td>
                  <td><?php if(isset($total2)) echo $total2; ?></td>
                </tr>
                <tr>
                    <td class = "title">5 - 9 YEARS</td>
                    <td><?php if(isset($value9)) echo $value9; ?></td>
                    <td><?php if(isset($value10)) echo $value10; ?></td>
                    <td><?php if(isset($value11)) echo $value11; ?></td>
                    <td><?php if(isset($value12)) echo $value12; ?></td>
                    <td><?php if(isset($value13)) echo $value13; ?></td>
                    <td><?php if(isset($value14)) echo $value14; ?></td>
                    <td><?php if(isset($value15)) echo $value15; ?></td>
                    <td><?php if(isset($value16)) echo $value16; ?></td>
                    <td><?php if(isset($total3)) echo $total3; ?></td>
                    <td><?php if(isset($total4)) echo $total4; ?></td>
                  </tr>
                  <tr>
                      <td class = "title">10 - 14 YEARS</td>
                      <td><?php if(isset($value17)) echo $value17; ?></td>
                      <td><?php if(isset($value18)) echo $value18; ?></td>
                      <td><?php if(isset($value19)) echo $value19; ?></td>
                      <td><?php if(isset($value20)) echo $value20; ?></td>
                      <td><?php if(isset($value21)) echo $value21; ?></td>
                      <td><?php if(isset($value22)) echo $value22; ?></td>
                      <td><?php if(isset($value23)) echo $value23; ?></td>
                      <td><?php if(isset($value24)) echo $value24; ?></td>
                      <td><?php if(isset($total5)) echo $total5; ?></td>
                      <td><?php if(isset($total6)) echo $total6; ?></td>
                    </tr>
                    <tr>
                        <td class = "title">15 - 17 YEARS</td>
                        <td><?php if(isset($value25)) echo $value25; ?></td>
                        <td><?php if(isset($value26)) echo $value26; ?></td>
                        <td><?php if(isset($value27)) echo $value27; ?></td>
                        <td><?php if(isset($value28)) echo $value28; ?></td>
                        <td><?php if(isset($value29)) echo $value29; ?></td>
                        <td><?php if(isset($value30)) echo $value30; ?></td>
                        <td><?php if(isset($value31)) echo $value31; ?></td>
                        <td><?php if(isset($value32)) echo $value32; ?></td>
                        <td><?php if(isset($total7)) echo $total7; ?></td>
                        <td><?php if(isset($total8)) echo $total8; ?></td>
                      </tr>
                      <tr>
                          <td class = "title">18 - 19 YEARS</td>
                          <td><?php if(isset($value33)) echo $value33; ?></td>
                          <td><?php if(isset($value34)) echo $value34; ?></td>
                          <td><?php if(isset($value35)) echo $value35; ?></td>
                          <td><?php if(isset($value36)) echo $value36; ?></td>
                          <td><?php if(isset($value37)) echo $value37; ?></td>
                          <td><?php if(isset($value38)) echo $value38; ?></td>
                          <td><?php if(isset($value39)) echo $value39; ?></td>
                          <td><?php if(isset($value40)) echo $value40; ?></td>
                          <td><?php if(isset($total9)) echo $total9; ?></td>
                          <td><?php if(isset($total10)) echo $total10; ?></td>
                        </tr>
                        <tr>
                            <td class = "title">20 - 34 YEARS</td>
                            <td><?php if(isset($value41)) echo $value41;?></td>
                            <td><?php if(isset($value42)) echo $value42;?></td>
                            <td><?php if(isset($value43)) echo $value43;?></td>
                            <td><?php if(isset($value44)) echo $value44;?></td>
                            <td><?php if(isset($value45)) echo $value45;?></td>
                            <td><?php if(isset($value46)) echo $value46;?></td>
                            <td><?php if(isset($value47)) echo $value47;?></td>
                            <td><?php if(isset($value48)) echo $value48;?></td>
                            <td><?php if(isset($total11)) echo $total11;?></td>
                            <td><?php if(isset($total12)) echo $total12;?></td>
                          </tr>
                          <tr>
                      <td class = "title">35 - 49 YEARS</td>
                      <td><?php if(isset($value49)) echo $value49;?></td>
                        <td><?php if(isset($value50)) echo $value50;?></td>
                        <td><?php if(isset($value51)) echo $value51;?></td>
                      <td><?php if(isset($value52)) echo $value52;?></td>
                      <td><?php if(isset($value53)) echo $value53;?></td>
                        <td><?php if(isset($value54)) echo $value54;?></td>
                        <td><?php if(isset($value55)) echo $value55;?></td>
                        <td><?php if(isset($value56)) echo $value56;?></td>
                        <td><?php if(isset($total13)) echo $total13;?></td>
                        <td><?php if(isset($total14)) echo $total14;?></td>
                            </tr>
                            <tr>
                    <td class = "title">50 - 59 YEARS</td>
                    <td><?php if(isset($value57)) echo $value57;?></td>
                    <td><?php if(isset($value58)) echo $value58;?></td>
                    <td><?php if(isset($value59)) echo $value59;?></td>
                    <td><?php if(isset($value60)) echo $value60;?></td>
                    <td><?php if(isset($value61)) echo $value61;?></td>
                    <td><?php if(isset($value62)) echo $value62;?></td>
                    <td><?php if(isset($value63)) echo $value63;?></td>
                    <td><?php if(isset($value64)) echo $value64;?></td>
                    <td><?php if(isset($total15)) echo $total15;?></td>
                      <td><?php if(isset($total16)) echo $total16;?></td>
                    </tr>
                              <tr>
                <td class = "title">60 - 69 YEARS</td>
                <td><?php if(isset($value65)) echo $value65;?></td>
              <td><?php if(isset($value66)) echo $value66;?></td>
            <td><?php if(isset($value67)) echo $value67;?></td>
              <td><?php if(isset($value68)) echo $value68;?></td>
              <td><?php if(isset($value69)) echo $value69;?></td>
              <td><?php if(isset($value70)) echo $value70;?></td>
                <td><?php if(isset($value71)) echo $value71;?></td>
                <td><?php if(isset($value72)) echo $value72;?></td>
                <td><?php if(isset($total17)) echo $total17;?></td>
                <td><?php if(isset($total18)) echo $total18;?></td>
                                </tr>
                                <tr>
                  <td class = "title">70 YEARS AND ABOVE</td>
                  <td><?php if(isset($value73)) echo $value73;?></td>
                  <td><?php if(isset($value74)) echo $value74;?></td>
                    <td><?php if(isset($value75)) echo $value75;?></td>
                  <td><?php if(isset($value76)) echo $value76;?></td>
                  <td><?php if(isset($value77)) echo $value77;?></td>
                  <td><?php if(isset($value78)) echo $value78;?></td>
                  <td><?php if(isset($value79)) echo $value79;?></td>
                  <td><?php if(isset($value80)) echo $value80;?></td>
                  <td><?php if(isset($total19)) echo $total19;?></td>
                  <td><?php if(isset($total20)) echo $total20;?></td>
                              </tr>
                                  <tr>
          <td class = "title">TOTAL ALL AGES</td>
          <td><?php if(isset($total_new_insured_males)) echo $total_new_insured_males; ?></td>
             <td><?php if(isset($total_new_insured_females)) echo $total_new_insured_females; ?></td>
              <td><?php if(isset($total_old_insured_males)) echo $total_old_insured_males; ?></td>
              <td><?php if(isset($total_old_insured_females)) echo $total_old_insured_females; ?></td>
              <td><?php if(isset($total_new_non_insured_males)) echo $total_new_non_insured_males; ?></td>
              <td><?php if(isset($total_new_non_insured_females)) echo $total_new_non_insured_females; ?></td>
              <td><?php if(isset($total_old_non_insured_males)) echo $total_old_non_insured_males; ?></td>
              <td><?php if(isset($total_old_non_insured_females)) echo $total_old_non_insured_females; ?></td>
              <td><?php if(isset($total_male)) echo $total_male; ?></td>
              <td><?php if(isset($total_female)) echo $total_female; ?></td>
                      </tr>

</table>
  <strong id = "notice">TO BE DISPATCHED NOT LATER THAN TUESDAY OF THE MONTH IMMEDIATELY FOLLOWING TO THE DISTRICT DIRECTOR OF HEALTH SERVICES</strong>
  <div class = "signature">............................................................<br>
    <span>MEDICAL OFFICER IN-CHARGE</span>
  </div>
            </section>
            <!--Print button and the dialog box-->
            <button id = "print">SAVE/PRINT</button>
            <div id = "printBox" title = "Print Document">
              <p>To issue the PRINT/SAVE command, use <strong>Ctrl+P</strong></p>
			  <p>Select Layout to be <strong>Landscape</strong>, Paper Size as <strong>A4</strong> and Margins to be <strong>Default
			  </strong>. Disable <strong>Headers and Footers</strong>. Click <strong>Print</strong>. To SAVE, select <strong>Change</strong> and select <strong>
			  Save as PDF</strong>. Click <strong>Save</strong>.
			  </p>
            </div>
	 </body>
      <footer></footer>
	  </html>
