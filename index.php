<?php
	session_start();
	
	if(isset($_SESSION['login']))
		header("Location: main.php");
	
	$msg = "";
	
	if(isset($_POST['submit']))
	{
		include("conn.php");
		$user = $_POST['username'];
		$pass = $_POST['pass'];
		
		//$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
		
		$sql = "SELECT pass FROM user_reg WHERE username = '$user'";
		
		$res = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($res) > 0)
		{
			$dbhashed = mysqli_fetch_array($res);
			
			if(password_verify($pass, $dbhashed['pass']))
			{
				$_SESSION['login'] = 'logged';
				$_SESSION['username'] = $user;
				$_SESSION['sessionid'] = md5($user.$hashedpass);
				header("Location: main.php");
			}
			
			else
				$msg = "Incorrect username and/or password";
		}
		
		else
			$msg = "Incorrect username and/or password";
	}
	
	
?>
<html>
	<head>
	</head>
	<body>
		<form method="post" action="">
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="username"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="pass"></td>
				</tr>
				<tr>
					<td colspan="2"><input style="width:100%" type="submit" name="submit" value="Login"></td>
				</tr>
				<tr>
					<td colspan="2"><input style="width:100%" type="button" name="submit" value="New User" onclick="window.location.href = 'user_registration.php';"></td>
				</tr>
			</table>
		</form>
		<font color="red"><b><?php echo $msg; ?></b></font>
	</body>
</html>