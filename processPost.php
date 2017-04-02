<?php
define('DBHOST', 'cosc360.ok.ubc.ca');
define('DBNAME', 'db_28723147');
define('DBUSER', '28723147');
define('DBPASS', '28723147');

session_start();
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
$error = mysqli_connect_error();
if($error != null){
	exit("<p>Unable to connect to database</p>". $error);
} else {
	session_start();
	if (isset( $_SESSION['username'] ) ){
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (isset($_POST['title']) && isset($_POST['topic'])) {
				$userName = $_SESSION['username'];
				$sql = "SELECT userID FROM users WHERE username = ?";
				$stmt = $connection->prepare($sql);
				$stmt->bind_param("s", $userName);
				$stmt->execute();
				$stmt->bind_result($userid);
						
				while($stmt->fetch()){
					$userID = $userid;
				}
				$stmt->close();
						
				$message=mysqli_real_escape_string($connection, $_POST['message']);	// sanitize the input
				$topic = mysqli_real_escape_string($connection, $_POST['topic']);	// sanitize the input
				$title = mysqli_real_escape_string($connection, $_POST['title']);	// sanitize the input
				
				
				$sql = "INSERT INTO posts(userID, title, topic, message) VALUES (?,?,?,?);";
				if($statement = mysqli_prepare($connection, $sql)){
					mysqli_stmt_bind_param($statement,'isss',$userID,$title,$topic,$message);
					mysqli_stmt_execute($statement);
					header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php"); /* Redirect browser */
					exit;
				}
				$statement = null;
				mysqli_close($connection);
			} else {
				header("Location: http://cosc360.ok.ubc.ca/28723147/Project/createPost.php"); /* Redirect browser */
				exit;
			}
		} else {
			header("Location: http://cosc360.ok.ubc.ca/28723147/Project/createPost.php"); /* Redirect browser */
			exit;
		}
	} else {
		header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
		exit;
	}
}
session_destroy();
?>
