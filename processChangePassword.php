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
	if (isset( $_SESSION['username'] )){
		$userName = $_SESSION['username'];
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (isset($_POST['oldpassword']) && isset($_POST['newPasswordRepeat']) && isset($_POST['newPassword'])) {
				try{
					$conn = new PDO("mysql:host=cosc360.ok.ubc.ca;dbname=db_28723147", DBUSER, DBPASS);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$oldPass = $_POST['oldpassword'];
					$sql = "SELECT password FROM users WHERE username = ?";
					$stmt = $conn->prepare($sql);
					$stmt->bindValue(1, $userName);
					$stmt->execute();
						while ($r = $stmt->fetch()) { 
							$password = $r['password'];
						}
				$conn = null;
				} catch(PDOException $e){
					die($e->getMessage());
				}
				
				if($password === md5($oldPass)){   // valid user
					$newPassword = $_POST['newPassword'];
					$newPassword_check = $_POST['newPasswordRepeat'];
					if(strcmp($newPassword,$newPassword_check) == 0){
						$sql = "UPDATE users SET password = ? WHERE username = ?";
						if($statement = mysqli_prepare($connection, $sql)){
							mysqli_stmt_bind_param($statement,'ss',md5($newPassword),$userName);
							mysqli_stmt_execute($statement);
							header("Location: http://cosc360.ok.ubc.ca/28723147/Project/editProfile.php"); /* Redirect browser */
							exit;
						} else {
							header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
							exit;
						}
					} else{
						echo "<p>The new passwords do not match</p>";
						echo "<a href=\"lab8-3.html\">Return to user entry</a>";
					}
				}
				$statement = null;
				mysqli_close($connection);
			}
		} else {
			header("Location: http://cosc360.ok.ubc.ca/28723147/Project/editProfile.php"); // Redirect browser 
			exit;
		}
	} else {
		header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); // Redirect browser 
		exit;
	}
	
}
?>
