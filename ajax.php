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
				</div>
				<?php
				}
			}
			?>