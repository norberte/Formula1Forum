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
	if (!isset( $_SESSION['username'] ) ){
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (isset($_POST['username']) && isset($_POST['password'])) {
				$userName = mysqli_real_escape_string($connection, $_POST['username']);	// sanitize the input
				$password = $_POST['password'];
				
				$user = false;
				$sql = "SELECT * FROM users;";
				$results = mysqli_query($connection, $sql);
				while ($row = mysqli_fetch_assoc($results)){
					if(($row['username'] === $userName) && ($row['password'] === md5($password))){   //valid user
						$user = true;
						$_SESSION['username'] = $userName;
						header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php"); /* Redirect browser */
						exit;
					} 
				}
				
				$statement = null;
				mysqli_close($connection);
				
				if ($user == false){
					header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
					exit;
				}	
			} else {
				header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
				exit;
			}
		} else {
			header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
			exit;
		}
	} else {
		header("Location: http://cosc360.ok.ubc.ca/28723147/Project/indexUser.php"); /* Redirect browser */
		exit;
	}
}
session_destroy();
?>
