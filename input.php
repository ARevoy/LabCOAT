<?php 
require_once ('library.php');										//include the library of functions
$conn = connectdb();
		
include 'header.php';
?>
<div class="container panel panel-default">	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="home">
			<div class="jumbotron text-center set-white">
			<h1>Add New Chemical Agent:</h1>
			<p> Instructions: <br> Please fill in all boxes you can <br> All boxes are Manditory for submisson except IUPAC and CAS <br>
			Only one of those two is required, but if you know both fill both <br>
			Only one submisson at a time
			</p>
			</div>
		</div>
	</div>
	<div class = "content">
	<!-- if building hasn't been selected -->
	<?php
	if(empty($_GET["building"])){											//if there is no search 
	?>
		<form action = "input.php" method = "GET" onsubmit="return validateForm()" enctype="multipart/form-data">
			<div class = "block">
				<label class = "side">Name:</label>
				<input type="text" id = "name" name="name" size="25" maxlength="50" />
			</div>
			
			<div class = "block">
				<label class = "side">IUPAC:</label>
				<input type="text" id = "IUPAC" name="IUPAC" size="25" maxlength="50" /> 
				<label><span>OR</span></label>
				<label class = "side">CAS Number:</label>
				<input type="text" id = "cas" name="cas" size="25" maxlength="50" /> 	
			</div>
			
			<div class = "block">
				<label>Building:</label>
				<select id = "building" name = "building">
					<option value="DNA">DNA</option>
					<option value="CSB">Champlain</option>
					<option value="SC">Science Complex</option>
					<option value="ESC">Environmental Science Complex</option>
				</select>
			</div>
			
			<div class = "block">
				<button type="submit" class="btn btn-default">Next</button>
			</div>
		</form>
	<!-- if building has been selected-->
	<?php
	}else{																//if something was searched for
	$name =  $_GET['name'];
	$cas = $_GET['cas'];
	$IUPAC = $_GET['IUPAC'];
		
	if($IUPAC == null){	//check if the session is set
		$query = "select distinct IUPAC from chemical_agent where CAS = '{$cas}'";
		$results = mysqli_query($conn,$query) or die ("3. Error retrieveing genre information from databse"); //stores that data in an array
		$searched = mysqli_fetch_array($results);
		$IUPAC = $searched['IUPAC'];
	}/*else{
		$IUPAC =  $_GET['IUPAC'];
	}*/
	
	if($cas == null){	//check if the session is set
		$query = "select CAS from chemical_agent where IUPAC = '{$IUPAC}'";
		$results = mysqli_query($conn,$query) or die ("3. Error retrieveing genre information from databse"); //stores that data in an array
		$searched = mysqli_fetch_array($results);
		$cas = $searched['CAS'];
	}/*else{
		$cas =  $_GET['cas'];
	}*/
	$building =  $_GET['building'];
	$query = "select room from room where Building = '{$building}'";													//pulls the list of genre from the database
	$results = mysqli_query($conn,$query) or die ("3. Error retrieveing genre information from databse"); //stores that data in an array
	$date=getdate(date("U"));
	?>
	<form action = "processAgent.php" method = "POST" onsubmit="return validateForm()" enctype="multipart/form-data">
		<input type="hidden" name="Name" value="<?php echo $name;?>">
		<input type="hidden" name="IUPAC" value="<?php echo $IUPAC;?>">
		<input type="hidden" name="CAS" value="<?php echo $cas;?>">
		<input type="hidden" name="Building" value="<?php echo $building;?>">
		<input type="hidden" name="Date" value="<?php echo "$date[year]-$date[mon]-$date[mday]";?>">
		
		<div class = "block">
			<label>State:<label/>
			<input type="text" id = "State" name="State" size="25" maxlength="50" /> 
			
			<label>Quantity:<label/>
			<input type="text" id = "Quantity" name="Quantity" size="25" maxlength="50"/>
		</div>
		
		<div class = "block">
		<label>Room </label>
			<select id = "Room" name = "Room">
				<?php while($row = mysqli_fetch_array($results)){?>
					<option value = "<?php echo $row['room']?>"> <?php echo $row['room']?> </option> <!--conents of database-->
				<?php }?> 
			</select>
		</div>
		<div class = "block">
			<button type="submit" class="btn btn-default">Submit</button>
		</div>			
	<?php
		}
	?>
	</form> 
	</div>
</div>
<?php
include 'footer.php'; 
?>