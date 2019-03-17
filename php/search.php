<?php
require_once 'est_connect.php';



/*The search term user has typed to be queried is received and stored as term*/
$term = $_REQUEST['search-text'];

$possibilities = array(); //to hold possible search found values

if(is_numeric($term)){
/*if the term is numeric, it is probable  that  the user wants to view the available patients pid*/

#be sure to replace the table name and the 'pid' syntax
$pid_query = "SELECT pid FROM patients;";
$pid_numbers = mysqli_query($connect, $pid_query);


if($pid_numbers){

while($pid = mysqli_fetch_row($pid_numbers)){
foreach($pid as $number){
	
	if((strpos($number, $term)) === 0){
		
		$possibilities[] = '"'. $number .'"';
	}

}
}
}
print ('['. implode(', ', $possibilities) .']');//this sends possible found searches that match the search term




}
else {
	/*if it is not numeric, the term, then it is probable that user is trying to find a name of a patient*/

	#be sure to change the table name and the 'name ' syntax
	$name_query = "SELECT name FROM patients;";
	$outcomes = mysqli_query($connect, $name_query);
	
	
	if($outcomes){	
while($names = mysqli_fetch_row($outcomes))	{
	foreach($names as $name){
		
	if((strpos($name, $term)) === 0){
		
		$possibilities[] = '"'. str_replace("'", "\\'", $name) .'"';
	}
}

}
}
	
print ('['. implode(', ', $possibilities) .']');

}


?>
