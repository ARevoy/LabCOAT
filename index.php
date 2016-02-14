<?php 
require_once ('library.php');										//include the library of functions
$conn = connectdb();												//connect the database

if(empty($_GET["Sdata"])){											//if there is no search 
		$term = null;	
}else{																//if something was searched for
		$term = $_GET["Sdata"];										//set the search term to term
}

if(empty($_GET["RSdata"])){											//if there is no search 
		$id = null;	
}else{																//if something was searched for
		$id = $_GET["RSdata"];										//set the search term to term
}
//Query for selecting The building and room numbers the chemical is in *Note for later only shows one building at a time currently
$query = "SELECT CAS FROM chemical_agent WHERE Name LIKE '%{$term}%'";
$b_results = mysqli_query($conn,$query) or die ("Error finding database for first query");	//sends query to the database
$searched = mysqli_fetch_array($b_results);
$Cnum = $searched['CAS'];

//Query for seelcting the chemical information from a slected lab
$query = "SELECT Distinct IUPAC, CL.CAS AS CAS, date_added, Quantity, state, Building, Room FROM room R, chemical_agent CA, chemical_location CL WHERE CL.RoomID = R.RoomID AND CA.CAS = CL.CAS AND CL.CAS LIKE '%{$Cnum}%'";

$CAresults = mysqli_query($conn,$query) or die ("Error finding database for second query");
//$row = mysqli_fetch_array($results);					//stores information form the database concerning the chemical 

//Query for seelcting the chemical information from a slected lab
$query = "SELECT Distinct IUPAC, CL.CAS AS CAS, date_added, Quantity, state FROM room R, chemical_agent CA, chemical_location CL WHERE CL.RoomID = R.RoomID AND CA.CAS = CL.CAS AND R.Room = '{$id}'";
$Rresults = mysqli_query($conn,$query) or die ("Error finding movie in database");

include 'header.php';
?>

<div class="container panel panel-default">	
	<div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="tab active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Chemical Search</a></li>
			<li role="presentation" class="tab"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Room Search</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home">
				<div class="jumbotron text-center set-white">
					<form action="index.php" method="get" enctype="multipart/form-data">  	<!--submit button link-->
						<h1>Search for chemicals:</h1>
						<div class="input-group">
							<input type="text" class="form-control" name = "Sdata" placeholder="Search by name">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">Search</button>
							</span>
						</div><!-- /input-group -->
					</form>
				</div><!-- /jumbotron -->
			</div><!-- /tabpanel -->	
		<div role="tabpanel" class="tab-pane" id="profile">
			<div class="jumbotron text-center set-white">
				<form action="index.php" method="get" enctype="multipart/form-data">  	<!--submit button link-->
					<h1>Search by room:</h1>
					</br>
					<div class="input-group">
						<div class="input-group-btn">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select College:<span class="caret"></span></button>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#">Science Complex</a></li>
									<li><a href="#">Champlain</a></li>
									<li><a href="#">Gzowski</a></li>
									<!-- 				          <li role="separator" class="divider"></li> -->
									<li><a href="#">Environmental Science Complex</a></li>
								</ul>
						</div><!-- /btn-group -->
						<input type="text" class="form-control" name = "RSdata" placeholder="Room: 231A | Group Rooms: 231, 324, 500" aria-label="...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Search</button>
						</span>
					</div><!-- /input-group -->
				</form>
			</div><!-- /jumbotron -->
		</div><!-- /tabpanel -->
	</div>	<!--tab-content-->
</div><!--container-->
<div class = "content">
	<table class = "displayTable">
		<tr>
			<th>Building</th>
			<th>Room</th>
			<th>IUPAC</th>
			<th>CAS</th> 
			<th>Quantity</th>
			<th>State</th>
			<th>Date Added</th>
		</tr>
	<?php
	if ($term == null){
	}else{
		while ($row = mysqli_fetch_array($CAresults)){			//While there are different labs with the chemical searched
	?>
		<tr>
			<td><?php echo $row["Building"];?></td>
			<td><?php echo $row["Room"];?></td>
			<td><?php echo $row["IUPAC"];?></td>
			<td><?php echo $row["CAS"];?></td>
			<td><?php echo $row["Quantity"];?></td>
			<td><?php echo $row["state"];?></td>
			<td><?php echo $row["date_added"];?></td>
		</tr>
	<?php 
		}
	}
	?>
	</table>
	
	<table>
		<tr>
			<th>Name</th>
			<th>CAS</th> 
			<th>Quantity</th>
			<th>State</th>
			<th>Date Added</th>
		</tr>
	<?php
		while ($chemicals = mysqli_fetch_array($Rresults)){			//While there are different labs with the chemical searched
	?>
		<tr>
			<td><?php echo $chemicals["IUPAC"]?></td>
			<td><?php echo $chemicals["CAS"]?></td>
			<td><?php echo $chemicals["Quantity"]?></td>
			<td><?php echo $chemicals["state"]?></td>
			<td><?php echo $chemicals["date_added"]?></td>
		</tr>
	<?php 
		}
	?>
	</table>
</div>
<?php 
//Query for selecting the different names that the chemical is stored as 
$query = "SELECT Name FROM chemical_agent WHERE CAS = '{$Cnum}'";  
$n_results = mysqli_query($conn,$query) or die ("Error finding database for last query"); 	//stores the name infomation
?>
		<p>Names: 	
			<?php
			while ($name_info = mysqli_fetch_array($n_results)){							//while there are different names
				?> <span> <?php echo $name_info["Name"]; ?> <span> <?php					//list the different names
			}
			?>
			</span>
		</p>
<?php 
$Cnum = null;
$row = null;
$chemical = null;
$name_info = null;

include 'footer.php'; ?>