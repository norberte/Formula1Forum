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
	if (isset( $_SESSION['username'] ) ){
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			$message= mysqli_real_escape_string($connection, $_POST['comment']);	// sanitize the input
			$userName = $_SESSION['username'];
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
			
				
			$sql = "INSERT INTO comments(userID, postID, message) VALUES (?,?,?);";
			if($statement = mysqli_prepare($connection, $sql)){
				mysqli_stmt_bind_param($statement,'iis',$userID ,$_POST['postID'], $message);
				mysqli_stmt_execute($statement);
				header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php"); // Redirect browser 
				exit;
			}
			$statement = null;
			mysqli_close($connection);
		} else {
			header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php"); // Redirect browser
			exit;
		}
		
	} else {
		header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
		exit;
	}
}
?>
