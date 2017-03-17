<?php
	if(isset($_POST['username']) && isset($_POST['pass']))
	{
		include("conn.php");
		$user = trim($_POST['username']);
		$pass = $_POST['pass'];

		$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
		
		$check_user_sql = "SELECT id FROM user_reg WHERE username = '$user'";
		
		$res_check = mysqli_query($conn, $check_user_sql);
		
		if(mysqli_num_rows($res_check) > 0)
		{
			echo "<script>Error! Username already exist</script>";
		}
		
		else
		{
			$insert_user = "INSERT INTO user_reg (username, pass) VALUES ('$user', '$hashed_pass')";
			$res_insert = mysqli_query($conn, $insert_user);
			
			if(!$res_insert)
			{
				echo "Error inserting new data. Registration unsuccessful!";
				echo(mysqli_error($conn));
			}
			
			else
			{
				echo "<script>alert('Registration for user $user successful! Please login'); window.location.replace('index.php');</script>";
			}
		}
	}
?>
<html>
	<head>
		<script>
			var valid = false;
			
			function verifyPassw()
			{
				var p = document.getElementById('pass').value;
				var v = document.getElementById('verifyPass').value;
				var m = document.getElementById('verifyMsg');
				
				if(p != v)
				{
					m.innerHTML = "<font color='red'><b>Password did not match!</b></font>";
					valid = false;
				}
				
				else
				{
					m.innerHTML = "<font color='green'><b>Password matched!</b></font>";
					valid = true;
				}
				
				if(p.trim() == '' && v.trim() == '')
				{
					m.innerHTML = "<font color='red'><b>Password cannot be empty!</b></font>";
					valid = false;
				}
					
			}
			
			function submitForm()
			{
				if(valid)
					document.getElementById("reg").submit();
				else
					alert("Please check your password again!");
			}
		</script>
	</head>
	<body>
		<form id="reg" method="POST" action="">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" max="10"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" id="pass" onkeyup="verifyPassw()" name="pass"></td>
				</tr>
				<tr>
					<td>Verify Password:</td>
					<td><input type="password" id="verifyPass" name="verifypass" onkeyup="verifyPassw()"><div id="verifyMsg"></div></td>
				</tr>
				<tr>
					<td colspan="2"><input style="width:100%" type="button" value="Register" name="register" onclick="submitForm()"></td>
				</tr>
			</table>
		</form>
	</body>
</html>