<!DOCTYPE html>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Formula 1 Talk</title>
   <link rel="stylesheet" href="css/index.css"/>
   <link rel="stylesheet" href="css/nav.css"/>
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
						<li><a href="indexUser.php">View All Posts</a></li>
						<li><a href="createPost.php">Create Post</a></li>
						<li><a href="signUp.php">Create Account</a></li>
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
			  <h3>Search for user </h3>
			  <div class="search">
					<form method="post" action="processSearch.php">
						<fieldset>
							<input id="searchBar" type="search" name="keyword" placeholder="enter keyword"/><input type="submit">
						</fieldset>
					</form>
					<br></br>
			  </div>
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
				$sql = "SELECT username FROM users WHERE ... ORDER BY timeOfPost ASC";
				$results = mysqli_query($connection, $sql);
				while ($row = mysqli_fetch_assoc($results)){
			  
				}
				$statement = null;
				mysqli_close($connection); 
			}
			?>
			   </div>
			</div>
			<!-- End of Center Column -->
			<!-- Start of Right Sidebar -->
			<div id="rightsidebar">
			</div>
			<!-- End of Right Sidebar -->
			<div class="clearthis">&nbsp;</div>
		  </div>
		  <!-- Start of Left Column -->
		  <div id="leftcolumn">
			<!-- Start of Left Sidebar -->
			<div id="leftsidebar">
			  <h3>Search: </h3>
			  <div class="search">
					<form method="post" action="processSearch.php">
						<fieldset>
							<input id="searchBar" type="search" name="keyword" placeholder="enter keyword"/><input type="submit">
						</fieldset>
					</form>
					<br></br>
			  </div>
			</div>
			<!-- End of Left Sidebar -->
		  </div>
		  <!-- End of Left Column -->
		  <div class="clearthis">&nbsp;</div>
		  <!-- Start of Page Footer -->
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
