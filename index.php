<?php include 'header.php'; ?>

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
					<h1>Search for chemicals:</h1>
					</br>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Ethyl Alcohol | CAS number | IUPAC number ">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Search</button>
						</span>
					</div><!-- /input-group -->
				</div><!-- /jumbotron -->
			</div><!-- /tabpanel -->	
		<div role="tabpanel" class="tab-pane" id="profile">
			<div class="jumbotron text-center set-white">
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
					<input type="text" class="form-control" placeholder="Room: 231A | Group Rooms: 231, 324, 500" aria-label="...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Search</button>
					</span>
				</div><!-- /input-group -->
			</div><!-- /jumbotron -->
		</div><!-- /tabpanel -->

</div>	

</div>


<?php include 'footer.php'; ?>