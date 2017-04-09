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
					define('DBPASS', '28723147');;

					$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
					$error = mysqli_connect_error();
					if($error != null){
						exit("<p>Unable to connect to database</p>". $error);
					} else {
								if( isset($_POST['name']) ){
									$name = mysqli_real_escape_string($connection, $_POST['name']);	// sanitize the input
									$sql = "SELECT * FROM users WHERE firstName = ?";
									try{
										$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
										$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										$stmt = $conn->prepare($sql);
										$stmt->bindValue(1, $name);
										$stmt->execute();
										while ($row = $stmt->fetch()) {
											$username = $row['username'];
											$firstName = $row['firstName'];
											$lastName = $row['lastName'];
											$email = $row['email'];
											$userID = $row['userID'];
											echo "<fieldset style=\"background-color:white;\">
												<table width=\"100px1\">
													<legend>User: ".$userName."</legend>
													<tr>
														<td>First Name: ".$row['firstName']."</td>
													</tr>
													<tr>
														<td>Last Name: ".$row['lastName']."</td>
													</tr>
													<tr>
														<td>Email: ".$row['email']."</td>
													</tr>
													<tr>
														<td>Email: ".$row['userID']."</td>
													</tr>
												</table>
											</fieldset>";
											?>
											<form id = "deletePostForm" method="post" action="disableUser.php" style="float:right">
												<input type="hidden" name="userID" value = <?php echo $userID ?> >
												<input class="primaryButton" type = "submit" value="Disable User">
											</form>
											<?php
										}
										$conn = null;
									} catch(PDOException $e){
										die($e->getMessage());
									}
								} else if ( isset($_POST['email']) ){
									$email = mysqli_real_escape_string($connection, $_POST['email']);	// sanitize the input
									$sql = "SELECT * FROM users WHERE email = ?";
									try{
										$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
										$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										$stmt = $conn->prepare($sql);
										$stmt->bindValue(1, $email);
										$stmt->execute();
										while ($row = $stmt->fetch()) {
											$username = $row['username'];
											$firstName = $row['firstName'];
											$lastName = $row['lastName'];
											$email = $row['email'];
											$userID = $row['userID'];
											echo "<fieldset style=\"background-color:white;\">
												<table width=\"100px\">
													<legend>User: ".$userName."</legend>
													<tr>
														<td>First Name: ".$row['firstName']."</td>
													</tr>
													<tr>
														<td>Last Name: ".$row['lastName']."</td>
													</tr>
													<tr>
														<td>Email: ".$row['email']."</td>
													</tr>
													<tr>
														<td>Email: ".$row['userID']."</td>
													</tr>
												</table>
											</fieldset>";
											?>
											<form id = "deletePostForm" method="post" action="disableUser.php" style="float:right">
												<input type="hidden" name="userID" value = <?php echo $userID ?> >
												<input class="primaryButton" type = "submit" value="Disable User">
											</form>
											<?php
										}
										$conn = null;
									} catch(PDOException $e){
										die($e->getMessage());
									}
								} else if ( isset($_POST['topic']) ){
									$topic = mysqli_real_escape_string($connection, $_POST['topic']);	// sanitize the input
									$sql = "SELECT username, firstName, lastName, email, users.userID FROM users, posts WHERE topic = ? AND users.userID = posts.userID";
									try{
										$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
										$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										$stmt = $conn->prepare($sql);
										$stmt->bindValue(1, $topic);
										$stmt->execute();
										while ($row = $stmt->fetch()) {
											$username = $row['username'];
											$firstName = $row['firstName'];
											$lastName = $row['lastName'];
											$email = $row['email'];
											$userID = $row['userID'];
											echo "<fieldset style=\"background-color:white;\">
													<table width=\"100px\">
														<legend>User: ".$userName."</legend>
														<tr>
															<td>First Name: ".$row['firstName']."</td>
														</tr>
														<tr>
															<td>Last Name: ".$row['lastName']."</td>
														</tr>
														<tr>
															<td>Email: ".$row['email']."</td>
														</tr>
														<tr>
															<td>User ID: ".$row['userID']."</td>
														</tr>
													</table>
											</fieldset>";
											?>
											<form id = "deletePostForm" method="post" action="disableUser.php" style="float:right">
												<input type="hidden" name="userID" value = <?php echo $userID ?> >
												<input class="primaryButton" type = "submit" value="Disable User">
											</form>
											<?php
										}		
										$conn = null;
									} catch(PDOException $e){
										die($e->getMessage());
									}
								}
					}
				?>
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

