<!DOCTYPE html>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Formula 1 Talk</title>
   <link rel="stylesheet" href="css/index.css"/>
   <link rel="stylesheet" href="css/nav.css"/>
</head>
<body>
	<div id="body_wrapper">
	<header id="masthead">
		<figure>
		  <img src="img/logo.jpg" width="75" height="50" alt="Formula 1 Logo" />
		</figure>
		<h1>Formula 1 Talk</h1>
		<div class="menu">
			<nav>
				<ul>
				<?php
					session_start();
					if (!isset( $_SESSION['username'] ) ){
				?>
						<li><a href="index.php">View All Posts</a></li>
						<li><a href="signUp.php">Create Account</a></li>
						<li><a href="logIn.php">Log-in</a></li>
				<?php
					} else {
				?> 
						<li><a href="viewProfile.php">View profile: <?php echo $_SESSION['username']?> </a></li>
						<li><a href="indexUser.php">View All Posts</a></li>
						<li><a href="createPost.php">Create Post</a></li>
						<li><a href="signUp.php">Create Account</a></li>
						<li><a href="logIn.php">Log-in</a></li>
						<li><a href="logOut.php">Log out</a></li>
				<?php 
					}
				?>
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
						if ($_SERVER["REQUEST_METHOD"] == "POST"){
							$postIDs = array();
							$keyword = mysqli_real_escape_string($connection, $_POST['keyword']);	// sanitize the input
							$sql = "SELECT postID FROM posts WHERE title LIKE '%".$keyword."%' OR message LIKE '%".$keyword."%'";
							$results = mysqli_query($connection, $sql);
							while ($row = mysqli_fetch_assoc($results)){
								array_push($postIDs,$row['postID']);
							}
							
							foreach($postIDs as $id){
								try{
									$sql = "SELECT postID, title, message, topic, timeOfPost, username FROM posts, users WHERE posts.userID = users.userID AND postID = ?";
									$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare($sql);
									$stmt->bindValue(1, $id);
									$stmt->execute();
									while($r = $stmt->fetch()){
										$postID = $r['postID'];
										$title = $r['title'];
										$message = $r['message'];
										$topic = $r['topic'];
										$timeOfPost = $r['timeOfPost'];
										$username = $r['username'];
									}	
									$conn = null;
								} catch(PDOException $e){
									die($e->getMessage());
								}
							?>
								<div class="post">
								  <div class="post_header">
									<h1>Title: <?php echo $title ?></h1>
									<strong>Date and Time: <?php echo $timeOfPost ?></strong>
								  </div>
								  <div class="post_detail">
									<h1> Posted By: <?php echo $username ?> </h1>
									<strong>Topic: <?php echo $topic ?></strong>
								  </div>
								  <div class="post_content">
									<h2> Post: <?php echo $message ?> </h2>
								  </div>
								  <?php
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
									<?php
											if (isset( $_SESSION['username'] ) ){
										?> 
												<form id = "commentArea" method="post" action="processComment.php" style="overflow:auto">
													<fieldset>
														<h2>Comment here</h2>
														<textarea class="newComment" rows="5" cols="110" name="comment"></textarea>
														<input type="hidden" name="postID" value = <?php echo $postID ?> >
														<input input class="primaryButton" type = "submit">
													</fieldset>
												</form>
										<?php 
											}
										?>
								</div>
								<?php
								$statement = null;
								mysqli_close($connection); 
							}
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
</body>
</html>

