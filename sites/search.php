<?php

#Array for letters
$letters = array('indigo', 'violet', 'green', 'india', 'indonesia', 'indiana');
#Array for numbers
$numbers = array('38/23', '40/16', '49/14', '60/45', '70/12', '79/12', '84/13', '83/45', '76/10', '65/12', '54/78', '42/10');

$term = $_REQUEST['search-text'];

$possibilities = array(); //to hold possible search found values

if(is_numeric($term)){
foreach($numbers as $number){
	if((strpos($number, $term)) === 0){
		$possibilities[] = '"'. $number .'"';
	}
}
print ('['. implode(', ', $possibilities) .']');

}
else {
	foreach($letters as $letter){
	if((strpos($letter, $term)) === 0){
		$possibilities[] = '"'. str_replace("'", "\\'", $letter) .'"';
	}
}
print ('['. implode(', ', $possibilities) .']');
	
}


?>