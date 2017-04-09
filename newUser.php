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
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["userImage"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["userImage"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["userImage"]["size"] > 100000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["userImage"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}	
		if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password-check'])) {
			$email = mysqli_real_escape_string($connection, $_POST['email']);		// sanitize the input
			$userName = mysqli_real_escape_string($connection, $_POST['username']);	// sanitize the input
			
			$notUserYet = true;
			$sql = "SELECT * FROM users;";
			$results = mysqli_query($connection, $sql);		// get results of the query
			while ($row = mysqli_fetch_assoc($results)){
				if($row['username'] === $userName || $row['email'] === $email){ // check to see if user already exists
					echo "<p>User already exists in database</p>";
					echo "<a href=\"newuser.html\">Return to user entry</a>";
					$notUserYet = false;
				}
			}
			$statement = null;
			
			if($notUserYet == true){
				$firstName = mysqli_real_escape_string($connection, $_POST['firstname']);	
				$lastName = mysqli_real_escape_string($connection, $_POST['lastname']);
				$password = $_POST['password'];
				$password2 =$_POST['password-check'];
				if(strcmp($password, $password2) == 0){
					$sql = "INSERT INTO users(firstName,lastName,username,email,password) VALUES (?,?,?,?,?);";
					if($statement = mysqli_prepare($connection, $sql)){
						mysqli_stmt_bind_param($statement,'sssss',$firstName,$lastName,$userName,$email,md5($password));
						mysqli_stmt_execute($statement);
						echo "<p>User inserted into the database</p>";
						try{
							$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = "SELECT userID FROM users WHERE username = ?";
							$stmt = $conn->prepare($sql);
							$stmt->bindValue(1, $userName);
							$stmt->execute();
								while ($r = $stmt->fetch()) { 
									$userID = $r['userID'];
								}
							$conn = null;
						} catch(PDOException $e){
							die($e->getMessage());
						}
						
						$imagedata = file_get_contents($_FILES["userImage"]["tmp_name"]); //store the contents of the files in memory in preparation for upload
						
						$sql = "INSERT INTO userimages (userID, contentType, image) VALUES(?,?,?)";
						$stmt = mysqli_stmt_init($connection); //init prepared statement object
						mysqli_stmt_prepare($stmt, $sql); // register the query

						$null = NULL;
						mysqli_stmt_bind_param($stmt, "isb", $userID, $imageFileType, $null); // bind the variable data into the prepared statement

						mysqli_stmt_send_long_data($stmt, 2, $imagedata); // This sends the binary data to the third variable location in the prepared statement (starting from 0).
						$result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));// run the statement
						mysqli_stmt_close($stmt); // and dispose of the statement. 
						
						echo "<br>";
						if(isset($result)){
							echo "User image was inserted into the database";
							header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php");
							die();
						} else {
							echo "User image was not inserted into the database";
						}
					} else {
						echo "<p>Error - user was not inserted into the database</p>";
						echo "<a href=\"newuser.html\">Return to user entry</a>";
					}
					mysqli_close($connection);
				} else {
					echo "<p>Error - passwords do not match</p>";
				}
				
			}
		}
	}
}
?>