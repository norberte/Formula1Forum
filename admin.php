<!DOCTYPE html>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Formula 1 Talk</title>
   <link rel="stylesheet" href="css/index.css"/>
   <link rel="stylesheet" href="css/nav.css"/>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<?php
session_start();
if (!isset( $_SESSION['username'] ) ){
	header("Location: http://cosc360.ok.ubc.ca/28723147/Project/index.php"); /* Redirect browser */
	exit;
} else {
	if(strcmp($_SESSION['username'], "WebAdmin") == 0){
	?> 
	<div id="body_wrapper">
		<header id="masthead">
			<figure>
			  <img src="img/logo.jpg" width="75" height="50" alt="Formula 1 Logo" />
			</figure>
			<h1>Formula 1 Talk</h1>
			<div class="menu">
				<nav>
					<ul>
						<li><a href="viewProfile.php">View profile: <?php echo $_SESSION['username']?> </a></li>
						<li><a href="indexUser.php">Admin Post Managing</a></li>
						<li><a href="createPost.php">Create Post</a></li>
						<li><a href="signUp.php">Create Account</a></li>
						<li><a href="admin.php">Administrator view</a></li>
						<li><a href="logIn.php">Log-in</a></li>
						<li><a href="logOut.php">Log out</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<div id="rightcolumn">
			<!-- Start Page Header -->
			<div id="page_header">
			  <h1><span><h1>Formula 1 Talk</h1></span></h1>
			</div>
			<!-- End of Page Header -->
			<!-- Start of Center Column -->
			<div id="centercolumn">
				<div id="centercolumn_2">
					<?php
					define('DBHOST', 'cosc360.ok.ubc.ca');
					define('DBNAME', 'db_28723147');
					define('DBUSER', '28723147');
					define('DBPASS', '28723147');

					$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
					$error = mysqli_connect_error();
					if($error != null){
						exit("<p>Unable to connect to database</p>". $error);
					} else {
						?>
						<div>
							<h3>Search for user by: </h3>
							<div>
								<form method="post" action="adminSearch.php">
									<input type="search" name="name" placeholder="Enter first name"/><input type="submit">
								</form>
								<form method="post" action="adminSearch.php">
									<input type="search" name="email" placeholder="Enter email"/><input type="submit">
								</form>
								<form method="post" action="adminSearch.php">
									<input type="search" name="topic" placeholder="Enter topic"/><input type="submit">
								</form>
								<br></br>
							</div>
						</div>
						<?php
					}
					?>
					<div style="float:right;">
					<h2>Search for posts: </h2>
					  <div class="search">
							<form method="post" action="processSearch.php">
								<input id="searchBar" type="search" name="keyword" placeholder="enter keyword"/><input type="submit">
							</form>
							<br></br>
					  </div>
					  <!-- Start of Latest Matches -->
						<div style="background-color:white;">
							<br>
							<h1 style="text-align:center;">Analysis of Topics trending</h1>
							<br>
							<ul>
								<?php
									define('DBHOST', 'cosc360.ok.ubc.ca');
									define('DBNAME', 'db_28723147');
									define('DBUSER', '28723147');
									define('DBPASS', '28723147');

									$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
									$error = mysqli_connect_error();
									if($error != null){
										exit("<p>Unable to connect to database</p>". $error);
									} else {
										$sql = "SELECT topic, COUNT(commentID) FROM posts, comments WHERE posts.postID = comments.postID GROUP BY comments.postID ORDER BY COUNT(commentID) DESC LIMIT 10;";
										$results = mysqli_query($connection, $sql);
										while ($row = mysqli_fetch_assoc($results)){
											?>
											<li style="color: inherit; background-color: #b3b3b3;">
												<?php echo $row['topic']?> - <?php echo $row['COUNT(commentID)']?> people are talking about it
											</li>
											<?php
										}
									}
									mysqli_close($connection); 
								?>
							</ul>
							<div class="clearthis">&nbsp;</div>
						</div>
					  <!-- End of Latest Matches -->
					</div>
				</div>
				<div id="centercolumn_2">
					<h1> Site Usage Measured in Number of Posts created each day </h1><br></br>
					<div id="columnchart_values"/>
					<script type="text/javascript">
						google.charts.load("current", {packages:['corechart']});
						google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
							  var data = google.visualization.arrayToDataTable([
								["Element", "Number of Posts", { role: "style" } ],
								<?php
									$days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
									$currDay = 0;
									$date = date("Y-m-d", strtotime('sunday last week'));//This may break since on sunday it shows NEXT sunday, test monday to see if I should do - 1 week
									
									define('DBHOST', 'cosc360.ok.ubc.ca');
									define('DBNAME', 'db_28723147');
									define('DBUSER', '28723147');
									define('DBPASS', '28723147');
									$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
									$error = mysqli_connect_error();
									if($error != null){
										exit("<p>Unable to connect to database</p>". $error);
									} else {
										for($x = 0;$x<7;$x++){
											$sql = "SELECT COUNT(postID) AS totalPosts FROM posts WHERE DATE(timeOfPost) = DATE('".$date."');";
											$results = mysqli_query($connection, $sql);
											while ($row = mysqli_fetch_assoc($results)){
												echo "[\"".$days[$x]."\", ".$row['totalPosts'].", \"blue\"]";
												if($x !== 6){
													echo ",";
												}    
											}
											$date = date('Y-m-d', strtotime($date . ' +1 day'));
										}
									}
								?>
							  ]);
							  var view = new google.visualization.DataView(data);
							  view.setColumns([0, 1,
											   { calc: "stringify",
												 sourceColumn: 1,
												 type: "string",
												 role: "annotation" },
											   2]);
							  var options = {
								title: "Number of Posts per day in a week",
								width: 500,
								height: 300,
								bar: {groupWidth: "95%"},
								legend: { position: "none" },
							  };
							  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
							  chart.draw(view, options);
							}
					</script>
			    </div>
				<div id="centercolumn_2" style="float:right">
				  <h1> Site Usage Measured in Number of Comments made each day </h1><br></br>
					<div id="columnchart_values2"/>
					<script type="text/javascript">
						google.charts.load("current", {packages:['corechart']});
						google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
							  var data = google.visualization.arrayToDataTable([
								["Element", "Number of Comments", { role: "style" } ],
								<?php
									$days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
									$currDay = 0;
									$date = date("Y-m-d", strtotime('sunday last week'));//This may break since on sunday it shows NEXT sunday, test monday to see if I should do - 1 week
									
									define('DBHOST', 'cosc360.ok.ubc.ca');
									define('DBNAME', 'db_28723147');
									define('DBUSER', '28723147');
									define('DBPASS', '28723147');
									$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
									$error = mysqli_connect_error();
									if($error != null){
										exit("<p>Unable to connect to database</p>". $error);
									} else {
										for($x = 0;$x<7;$x++){
											$sql = "SELECT COUNT(commentID) AS totalComments FROM comments WHERE DATE(timeOfComment) = DATE('".$date."');";
											$results = mysqli_query($connection, $sql);
											while ($row = mysqli_fetch_assoc($results)){
												echo "[\"".$days[$x]."\", ".$row['totalComments'].", \"blue\"]";
												if($x !== 6){
													echo ",";
												}    
											}
											$date = date('Y-m-d', strtotime($date . ' +1 day'));
										}
									}
								?>
							  ]);
							  var view = new google.visualization.DataView(data);
							  view.setColumns([0, 1,
											   { calc: "stringify",
												 sourceColumn: 1,
												 type: "string",
												 role: "annotation" },
											   2]);
							  var options = {
								title: "Number of Comments per day in a week",
								width: 500,
								height: 300,
								bar: {groupWidth: "95%"},
								legend: { position: "none" },
							  };
							  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
							  chart.draw(view, options);
							}
					</script>
				</div>
			</div>	 
		</div>
	</div>
	<?php
	} else {
		header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php"); /* Redirect browser */
		exit;
	}
}
?>
</body>
</html>

