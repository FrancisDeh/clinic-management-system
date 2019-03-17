<?php
require_once "../php/est_connect.php";
/*This form recieves insurance information for non-insured patients who are now insured and updates their information in the database and sends back the updated information*/

$pid = $_REQUEST['pid'];
$schemeId = $_REQUEST['schemeID'];
$insuranceNumber = $_REQUEST['insuranceNo'];
$expDate = $_REQUEST['expDate'];

$update_query = sprintf("UPDATE patients SET exp_date = '%s' " .
",insurance_number = '%s', scheme_id = '%s', insurance_state = 'Insured' " .
" WHERE pid = '%s';",
mysqli_real_escape_string($connect, $expDate),
mysqli_real_escape_string($connect, $insuranceNumber),
mysqli_real_escape_string($connect, $schemeId),
mysqli_real_escape_string($connect, $pid));

/*execute query*/
//if successful, the show_patient page will load the new information and insurance state will be "insured" else nothing shows.
$result = mysqli_query($connect, $update_query);

header("Location: ../sites/show_patient.php?pid={$pid}");
exit();
?>