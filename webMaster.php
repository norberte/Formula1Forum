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
          define('DBPASS', '28723147');

			$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			$error = mysqli_connect_error();
		if($error != null){
			exit("<p>Unable to connect to database</p>". $error);
		} else {
			$sql = "SELECT postID, title, message, topic, timeOfPost, username FROM posts, users WHERE posts.userID = users.userID ORDER BY timeOfPost DESC";
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
				<h2> Post: <?php echo $row['message']?></h2> 
				<form id = "deletePostForm" method="post" action="deletePost.php" style="float:right">
					<input type="hidden" name="postID" value = <?php echo $row['postID'] ?> >
					<input class="primaryButton" type = "submit" value="Delete Post">
				</form>
					
				<form id = "editPostForm" method="post" action="editPost.php" style="float:right">
					<textarea class="newComment" rows="1" cols="60" name="editing" placeholder="Edit post here"></textarea>
					<input type="hidden" name="postID" value = <?php echo $row['postID'] ?> >
					<input class="primaryButton" type = "submit" value="Update Post">
				</form>
			  </div>
			  <?php
			    $postID = $row['postID'];
				mysqli_close($connection); 
				try{
					$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql2 = "SELECT commentID, username, message, timeOfComment FROM users, comments WHERE comments.userID = users.userID AND postID = ? ORDER BY timeOfComment DESC";
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
									<form id = "deletePostForm" method="post" action="deleteComment.php" style="float:right">
										<input type="hidden" name="postID" value = <?php echo $row['postID'] ?> >
										<input type="hidden" name="commentID" value = <?php echo  $r['commentID'] ?> >
										<input class="primaryButton" type = "submit" value="Delete Comment">
									</form>
									
									<form id = "editPostForm" method="post" action="editComment.php" style="float:right">
										<textarea class="newComment" rows="1" cols="60" name="editing" placeholder="Edit comment here"></textarea>
										<input type="hidden" name="postID" value = <?php echo $row['postID'] ?> >
										<input type="hidden" name="commentID" value = <?php echo  $r['commentID'] ?> >
										<input class="primaryButton" type = "submit" value="Update Comment">
									</form>
								</div>
							</div>
						<?php
						}
				$conn = null;
				} catch(PDOException $e){
					die($e->getMessage());
				}
				?>
				<br></br>
				<div>
					<form id = "commentArea" method="post" action="processComment.php" style="overflow:auto">
						<fieldset>
							<h2>Comment here</h2>
							<textarea class="newComment" rows="5" cols="110" name="comment"></textarea>
							<input type="hidden" name="postID" value = <?php echo $row['postID'] ?> >
							<input class="primaryButton" type = "submit">
						</fieldset>
					</form>
				</div>
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
