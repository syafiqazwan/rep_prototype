<?php
	include("init.php");
	include("conn.php");
	
	$retrievePostSql = "Select p_title, p_desc, p_mediapath, mt.mt_desc, s.s_desc, p_s_id, p_datetime,
						p_location, ur.username, p_verifycount
						from post
						left join mediatype mt on mt.mt_id = p_mt_id
						inner join user_reg ur on ur.id = p_u_id
						left join status s on s.s_id = p_s_id
						where p_s_id in (1,2) 
						order by p_datetime desc";
						
	$retPostRes = mysqli_query($conn, $retrievePostSql);
	
?>
<html>
	<head>
	</head>
	<body>
		Welcome <?php echo $_SESSION['username']; ?><br />
		<input type="button" value="Logout" onclick="window.location.replace('logout.php');">
		<br />
		<?php
		
		while($rowPost = mysqli_fetch_array($retPostRes))
		{
			$status = $rowPost['p_s_id'];
			$date=date_create($rowPost['p_datetime']);
			$dateFormat = date_format($date,"Y/m/d H:i:s A");
		?>
			<div>
				<h1><?php echo $rowPost['p_title']; ?></h1>
				<div>Posted at <?php echo $dateFormat; ?></div>
				<div>Located near <?php echo $rowPost['p_location']; ?></div>
				<div><?php echo $status == "1" ? "<font color='green'><b>".$rowPost['s_desc']."</b></font>" : "<font color='orange'><b>".$rowPost['s_desc']."</b></font>";  ?></div>
				<img src = "<?php echo $rowPost['p_mediapath']; ?>" width="640" height="480"></img><br>
				<div><?php echo $rowPost['p_desc']; ?></div>
				<div>
					<input type="button" name="verify" value="Verify This" /><p><?php echo $rowPost['p_verifycount']; ?> people(s) verified this</p>
					<input type="button" name="report" value="Report This Post" />
					<input type="button" name="comment" value="View Comment" />
				</div>
				<br><br>
			</div>
		<?php
		}
		?>
	</body>
</html>