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
			$sql = "SELECT postID, title, message, topic, timeOfPost, username FROM posts, users WHERE posts.userID = users.userID ORDER BY timeOfPost ASC";
			$results = mysqli_query($connection, $sql);
			while ($row = mysqli_fetch_assoc($results)){
		  ?>
		  <div class="post">
			  <div class="post_header">
				<h1>Title: <?php echo $row['title']?></h1>
				<strong>Date and Time: <?php echo $row['timeOfPost']?></strong>
			  </div>
			  <div class="post_detail">
				<h1> Posted By: <?php echo $row['username']?> </h1>
				<strong>Topic: <?php echo $row['topic']?></strong>
			  </div>
			  <div class="post_content">
				<h2> Post: <?php echo $row['message']?> </h2>
			  </div>
			  <?php
			    $postID = $row['postID'];
				mysqli_close($connection); 
				try{
					$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql2 = "SELECT username, message, timeOfComment FROM users, comments WHERE comments.userID = users.userID AND postID = ? ORDER BY timeOfComment ASC";
					$stmt = $conn->prepare($sql2);
					$stmt->bindValue(1, $postID);
					$stmt->execute();
						while ($r = $stmt->fetch()) { 
						?>
							<div class="post_comments">
								<div class="post_header">
									<h2> Commenter: <?php echo $r['username']?> </h2>
									<strong>Date and Time: <?php echo $r['timeOfComment']?></strong>
								</div>
								<div>
									<h2>Comment: <?php echo $r['message']?></h2>
								</div>
							</div>
						<?php
						}
				$conn = null;
				} catch(PDOException $e){
					die($e->getMessage());
				}
				?>	
				<form id = "commentArea" method="post" action="processComment.php" style="overflow:auto">
					<fieldset>
						<h2>Comment here</h2>
						<textarea class="newComment" rows="5" cols="110" name="comment"></textarea>
						<input type="hidden" name="postID" value = <?php echo $row['postID'] ?> >
						<input input class="primaryButton" type = "submit">
					</fieldset>
				</form>
		  </div>
			<?php
			}
		}
		?>
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
		  <h3>Search: </h3>
		  
		  <div class="search">
				<form method="post" action="processSearch.php">
					<fieldset>
						<input id="searchBar" type="search" name="keyword" placeholder="enter keyword"/><input type="submit">
					</fieldset>
				</form>
				<br></br>
		  </div>
		  <!-- Start of Latest Matches -->
		  <div id="latestmatch">
			<h2><span>Discussion Topics:</h2></span>
			<ul>
				<li><a href="#merdedes">Mercedes AMG Petronas</a></li>
				<li><a href="#redbull">Reb Bull Tag-Hauer</a></li>
				<li><a href="#ferrari">Scuderia Ferrari</a></li>
				<li><a href="#forceindia">Force India Mercedes</a></li>
				<li><a href="#williams">Williams Mercedes</a></li>
				<li><a href="#mclaren">McLarren Honda</a></li>
				<li><a href="#tororosso">Toro Rosso Ferrari</a></li>
				<li><a href="#haas">Haas GP</a></li>
				<li><a href="#sauber">Sauber Ferrari</a></li>
				<li><a href="#renault">Renault</a></li>
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
