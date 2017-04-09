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
	header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
	exit;
} else {
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
						if (isset( $_SESSION['username'] )){
							$userName = $_SESSION['username'];
							try{
								$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
								$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$sql = "SELECT * FROM users WHERE username = ?";
								$stmt = $conn->prepare($sql);
								$stmt->bindValue(1, $userName);
								$stmt->execute();
								while ($row = $stmt->fetch()) {
									$userID = $row['userID'];
									$firstName = $row['firstName'];
									$lastName = $row['lastName'];
									$email = $row['email'];
								}
								$conn = null;
							} catch(PDOException $e){
								die($e->getMessage());
							}
						}
					}
			?>
			<div id="bg"></div>
			<div class="card">
				<form id="editProfileForm" method="post" action="processEditProfile.php" enctype="multipart/form-data">
					<div class="profile">
					<h1>Edit Profile </h1><br>
						<?php
							$sql = "SELECT contentType, image FROM userimages where userID=?";		// build the prepared statement SELECTing on the userID for the user
							$stmt = mysqli_stmt_init($connection);		//init prepared statement object
							mysqli_stmt_prepare($stmt, $sql);		// bind the query to the statement
							mysqli_stmt_bind_param($stmt, "i", $userID);		// bind in the variable data (ie userID)
							$result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt)); 		// Run the query.
							mysqli_stmt_bind_result($stmt, $type, $image); 		//bind in results
							// Binds the columns in the resultset to variables
							mysqli_stmt_fetch($stmt);		// Fetches the blob and places it in the variable $image for use as well as the image type (which is stored in $type)
							mysqli_stmt_close($stmt);		// release the statement
							echo '<img src="data:image/'.$type.';base64,'.base64_encode($image).'"/>';		// put image in the html page
							mysqli_close($connection);						
						?>
						<p>Change Profile Picture:</p><hr>
						<div>
							<input type="file" class="form-control" name="userImage">
						</div>
						<div class="border"></div>
					</div>
					<div class="name"><p>UserName:<?php echo $userName ?></p></div>
					<div class="numbers">
						<table id="stats">
							<tbody>
								<tr>
									<td>First Name:</td>
									<td><input class="formControl" type="text" name="firstname" placeholder= <?php echo $firstName ?> ></td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input class="formControl" type="text" name="lastname" placeholder=<?php echo $lastName ?> ></td>
								</tr>
								<tr>
									<td>Email:</td>
									<td><input class="formControl" type="email" name="email" placeholder=<?php echo $email ?> ></td>
								</tr>
							</tbody>
						</table>
						<div class="divider"></div>
					</div>
					<br>
					<input class="primaryButton" type="submit" value="Update Profile Info" >
					<button class="primaryButton"><a href="changePassword.php">Change Password</a></button>
				</form>
				
			</div>
			<!-- End of News Box 2 -->
		  </div>
		</div>
		<!-- End of Center Column -->
		<!-- Start of Right Sidebar -->
		<div id="rightsidebar">
		  <!-- Start of Team Roster -->
		  <div id="driver_roster">
			<div id="drivers_header">
			  <h2><span>Drivers</span></h2>
			</div>
			<div id="drivers_content">
			  <ul>
				<li id="hamilton"><a href="http://www.lewishamilton.com">Lewis Hamilton</a></li>
				<li id="bottas"><a href="http://www.lewishamilton.com">Valtteri Bottas</a></li>
				<li id="ricciardo"><a href="http://www.lewishamilton.com">Daniel Ricciardo</a></li>
				<li id="verstappen"><a href="http://www.lewishamilton.com">Max Verstappen</a></li>
				<li id="kimi"><a href="http://www.lewishamilton.com">Kimi Raikkonen</a></li>
				<li id="vettel"><a href="http://www.lewishamilton.com">Sebastian Vettel</a></li>
				<li id="perez"><a href="http://www.lewishamilton.com">Sergio Perez</a></li>
				<li id="ocon"><a href="http://www.lewishamilton.com">Esteban Ocon</a></li>
				<li id="massa"><a href="http://www.lewishamilton.com">Felipe Massa</a></li>
				<li id="stroll"><a href="http://www.lewishamilton.com">Lance Stroll</a></li>
				<li id="vandoorne"><a href="http://www.lewishamilton.com">Stoffel Vandoorne</a></li>
				<li id="alonso"><a href="http://www.lewishamilton.com">Fernando Alonso</a></li>
				<li id="hulkenberg"><a href="http://www.lewishamilton.com">Nico Hulkenberg</a></li>
				<li id="palmer"><a href="http://www.lewishamilton.com">Jolyon Palmer</a></li>
				<li id="kvyat"><a href="http://www.lewishamilton.com">Daniil Kvyat</a></li>
				<li id="sainz"><a href="http://www.lewishamilton.com">Carlos Sainz</a></li>
				<li id="magnussen"><a href="http://www.lewishamilton.com">Kevin Magnussen</a></li>
				<li id="grosjean"><a href="http://www.lewishamilton.com">Romain Grosjean</a></li>
				<li id="wehrlein"><a href="http://www.lewishamilton.com">Pascal Wehrlein</a></li>
				<li id="ericcson"><a href="http://www.lewishamilton.com">Marcus Ericsson</a></li>
			  </ul>
			  <div class="clearthis">&nbsp;</div>
			</div>
		  </div>
		  <!-- End of Team Roster -->
		</div>
		<!-- End of Right Sidebar -->
		<div class="clearthis">&nbsp;</div>
	  </div>
	  <!-- Start of Left Column -->
	  <div id="leftcolumn">
		<!-- Start of Left Sidebar -->
		<div id="leftsidebar">
		   <h2>Search for keywords in posts:</h2>
			  <div class="search">
					<form method="post" action="processSearch.php">
						<fieldset>
							<input id="searchBar" type="search" name="keyword" placeholder="enter keyword"/><input type="submit">
						</fieldset>
					</form>
					<br></br>
			  </div>
			  <br>
			  <h2>Search for topic:</h2>
			  <div class="search">
					<form method="post" action="processTopicSearch.php">
						<fieldset>
							<input id="searchBar" type="search" name="topic" placeholder="enter topic name"/><input type="submit">
						</fieldset>
					</form>
					<br></br>
			  </div>
		  <!-- Start of Latest Matches -->
		  <div id="latestmatch">
					<br>
					<h1 style="text-align:center;">Hot Threads:</h1>
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
									<li>
										<form method="post" action="processTopicSearch.php">
											<input type="hidden" name="topic" value="<?php echo $row['topic']?>" /> 
											<input type="submit" value="<?php echo $row['topic']?>" />
										</form>
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
		<!-- End of Left Sidebar -->
	  </div>
	  <!-- End of Left Column -->
	  <div class="clearthis">&nbsp;</div>
	  <!-- Start of Page Footer -->
	</div>
<?php
}
?>
</body>
</html>