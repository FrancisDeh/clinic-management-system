<?php
require_once 'est_connect.php';

/*This page accepts search terms from submitted search box, determines wether it is pid or a patient name, if it is a pid, it is redirected to the show patient page, if it is a name , the pid is retrieved and redirected to the show patient page */

$search_term = $_REQUEST['searchTerm'];
if(strpos($search_term, '/')){
  header("Location: ../sites/show_patient.php?pid={$search_term}");
  exit();
}
else {
  #use the name to retrieve the pid number from the database and direct it to the show patient page
  $name_query = sprintf("SELECT pid FROM patients  WHERE name = '%s';", $search_term);
  $pid_no = mysqli_query($connect, $name_query);
if(mysqli_num_rows($pid_no) == 1){
	
	while($rows  = mysqli_fetch_array($pid_no)){
	$number = $rows[0];
	header("Location: ../sites/show_patient.php?pid={$number}");
exit();
}
}


}


?>
