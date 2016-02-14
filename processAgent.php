<?php
require_once ('library.php');													//access the library full of functions
$conn = connectdb();															//connect to the database

	if (empty($_POST["Name"])|| strlen(trim($_REQUEST['Name'])) == 0){			//check if the field is empty 
		//$_SESSION["invalid"] = 8;												//set invaild to a unique id
		header('location:index.php');											//redirect to the another page
		die();																	//end the process page
	}else{
	 $cname = dbParam($_POST["Name"]);											//format the input
		if (strpos($cname,'/*') !== false) {									//check if the content can comment in sql
			//$_SESSION["invalid"] = 8;											//set invaild to a unique id
			header('location:index.php');										//redirect to the create account page
			die();																//end the process page
		}
	}
	
	if (empty($_POST["IUPAC"])|| strlen(trim($_REQUEST['IUPAC'])) == 0){		//the standard name of the chemcial agent
		//$_SESSION["invalid"] = 9;
		header('location:index.php');
		die();
	}else{
		$iupac = dbParam($_POST["IUPAC"]);
	 	if (strpos($iupac,'/*') !== false) {
			//$_SESSION["invalid"] = 9;
			header('location:index.php');
			die();
		} 
	 }
	 
	 if (empty($_POST["CAS"])|| strlen(trim($_REQUEST['CAS'])) == 0){			//the CAS number of the agent
		//$_SESSION["invalid"] = 10;
		header('location:index.php');
		die();
	}else{
		$cas = dbParam($_POST["CAS"]);
		if (strpos($cas,'/*') !== false) {
			//$_SESSION["invalid"] = 10;
			header('location:index.php');
			die();
		}
	}
	
	if (empty($_POST["Quantity"])|| strlen(trim($_REQUEST['Quantity'])) == 0){	//the amount of the agent
		//$_SESSION["invalid"] = 11;
		header('location:index.php');
		die();
	}else{
		$quantity = dbParam($_POST["Quantity"]);
		if (strpos($quantity,'/*') !== false) {
			//$_SESSION["invalid"] = 10;
			header('location:index.php');
			die();
		}
	 }	
   
	if (empty($_POST["State"])|| strlen(trim($_REQUEST['State'])) == 0){		//the state of the agent
		//$_SESSION["invalid"] = 12;
		header('location:index.php');
		die();
	}else{
		$state = dbParam($_POST["State"]);
		if (strpos($state,'/*') !== false) {
			//$_SESSION["invalid"] = 10;
			header('location:index.php');
			die();
		}
	}
	
	if (empty($_POST["Building"])|| strlen(trim($_REQUEST['Building'])) == 0){	//the building the agent is located in
		//$_SESSION["invalid"] = 12;
		header('location:index.php');
		die();
	}else{
		$building = dbParam($_POST["Building"]);
		if (strpos($building,'/*') !== false) {
			//$_SESSION["invalid"] = 10;
			header('location:index.php');
			die();
		}
	}
	
	if (empty($_POST["Room"])|| strlen(trim($_REQUEST['Room'])) == 0){			//the room the agent is located in
		//$_SESSION["invalid"] = 12;
		header('location:index.php');
		die();
	}else{
		$room = dbParam($_POST["Room"]);
		if (strpos($state,'/*') !== false) {
			//$_SESSION["invalid"] = 10;
			header('location:index.php');
			die();
		}
	}
$date = $_POST["Date"];
$query = "SELECT Name from chemical_agent where CAS = '{$cas}'";
$results = mysqli_query($conn,$query) or die ("Error adding user to database");		//retieve names of chemical agents in the data base

$check = 0;																			//check value
while ($row = mysqli_fetch_array($results)){										//do while there are names ot be read		
	
	$data = strtolower($row['Name']);												//convert database name to lower case
	$chemical_name = strtolower($cname);											//convert inserted name to lower case

	if($data == $chemical_name){													//if they are identical set the check value to 1
	$check = 1;
	}
}

if($check == 0){																	//if the check value is 0, no identical names were found
	$query = "INSERT INTO chemical_agent(CAS,IUPAC, Name) 
	values ('{$cas}','{$iupac}','{$cname}')";  										//query for adding chemical agent to the database

	mysqli_query($conn,$query) or die ("Error adding user to database");			//updating the databse
}

$query = "SELECT RoomID FROM room WHERE Room = '{$room}' AND Building = '{$building}'";		//query to retieve the Room ID

$result = mysqli_query($conn,$query) or die ("Error adding user to database");	//retieve Room id from database

$row = mysqli_fetch_array($result);												//store it in row
	
$Rid = $row['RoomID'];															//grab the id from the array

$query = "INSERT INTO chemical_location(CAS, RoomID, Quantity, State, date_added)
values ('{$cas}','{$Rid}','{$quantity}', '{$state}','{$Date}')";				//query to insert the agents data into the database

mysqli_query($conn,$query) or die ("Error adding user to database");			//updating the databse
header('location:index.php');
?>
