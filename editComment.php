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
			$post = mysqli_real_escape_string($connection, $_POST['postID']);	// sanitize the input
			$comment = mysqli_real_escape_string($connection, $_POST['commentID']);	// sanitize the input
			$message = mysqli_real_escape_string($connection, $_POST['editing']);
			
			$sql = "UPDATE comments SET message = ? WHERE postID = ? AND commentID = ?;";
			if($statement = mysqli_prepare($connection, $sql)){
				mysqli_stmt_bind_param($statement,'sii',$message, $post ,$comment);
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
