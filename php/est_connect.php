<?php

//Establishing connection to MySQL with valid credentials,
//The sys_config file contains the connection variables

/*est_connect.php file establishes connection to the database using valid credentials
	a. The Host
	b. Username
	c. Password
The second aspect establishes connection with the database hospital if the authentication has been
successfully granted. In both instances, error messages are generated if connections are not successfully
established.

All pages that access the database for data manipulation and transaction require this file.

This file requires sys_config.php*/


require "sys_config.php";
$connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD);

//Invoking The connection
$connect
or
die ("<p>Error connecting to the database: " . mysqli_connect_error() . "</p>");



/*Establishing connection to database called hospital*/
mysqli_select_db($connect, DATABASE_NAME)
or die ("<p>Error selecting database: " . mysqli_error($connect) . "</p>");

?>
