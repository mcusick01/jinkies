<!DOCTYPE html>

<html>
<head>
	<title>Scooby Doo! Where Are You?!</title>	
	<link href="FinalProject_CommentStyles.css" rel="stylesheet"/>
</head>
<body>
	<?php 
	
		//initialize posting variables
		$submit = '';
		$user = '';
		$comm = '';
		$favchar = '';
		$resultarray = '';
		$row = '';
	
		//variables to hold pass-in info
		$servername = "localhost";
		$username = "macusick";
		$password = "abc";
		
		//create and check the connection
		$connection = mysqli_connect($servername, $username, $password);
		
		//check connection -- if no eror message displays in browser, connection was succesful
		if(!$connection)	//if connection fails, call exit function
		{
			die("Connection failed: " . mysqli_connect_error());
		}
		
		//create database
		$sql = "CREATE DATABASE IF NOT EXISTS finalprojectDB";
		
		//if database is created succesfully, do this
		if(mysqli_query($connection, $sql))
		{
			//select the succesfully created DB to use
			if(mysqli_select_db($connection, "finalprojectDB"))
			{
				//if selection was succesful, create a table
				$sql = "CREATE TABLE IF NOT EXISTS scoobydooComments (
						id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						name VARCHAR(15),
						comment VARCHAR(280) NOT NULL)";
				if(!mysqli_query($connection, $sql))
				{
					die("Error creating table: " . mysqli_error($connection));
				}
			}
			else //error message
			{
				die("Error selecting database: " . mysqli_error($connection));
			}
		}
		else //error message
		{
			die("Error creating database: " . mysqli_error($connection));
		}
		
		//if form has been submitted
		if(isset($_POST['submit']))
		{
			//set variables
			$user = $_POST['user'];
			$comm = $_POST['comment'];
			$favchar = $_POST['characters'];
					
			$sql = "INSERT INTO scoobydooComments (name, comment) VALUES ('$user', '$comm')";
			mysqli_query($connection, $sql);
		}	
		
		//if cookie is not set
		if(!isset($_COOKIE['favoriteCharCookie']))
		{
			setcookie('favoriteCharCookie', $favchar, time() + 86400);
			$_COOKIE['favoriteCharCookie'] = $favchar;
			echo "<div id='favcharacter'><p>Your favorite character today is... </br> " . $_COOKIE['favoriteCharCookie'] . "<p></div>";
		}
		else
		{
			echo "<div id='favcharacter'><p>Your favorite character today is... </br> " . $_COOKIE['favoriteCharCookie'] . "<p></div>";
		}
		
		
		//to print comments in div
		//$result contains an array with the values from the query
		$sql = "SELECT * FROM scoobydooComments";
		$resultarray = mysqli_query($connection, $sql);
		
		echo "<div id='scrollable'>
					<ul>";

			while($row = mysqli_fetch_array($resultarray))
			{
				//print into the div
				echo "<li class='name'>$row[1] said...
					  	<li class='comment'>$row[2]</li>
					  </li></br>";
			}
		echo	   "</ul>
		
			  </div>
	
			  <div id='form'>
					<form method='post'>
						<fieldset>
							<label id='name'>Name:
								<input type='text' name='user'/>
							</label>
							
							<label id='favchar'>Favorite Character: 
								<select name='characters'>
									<option value='Fred'>Fred</option>
									<option value='Velma'>Velma</option>
									<option value='Daphne'>Daphne</option>
									<option value='Shaggy'>Shaggy</option>
									<option value='Scooby'>Scooby</option>
								</select>
							</label>

							<label id='commentbox'>Leave a comment:
								<textarea rows='5' cols='60' name='comment'></textarea>
							</label>

							<input type='submit' name='submit' value='Submit My Comment!'>
						</fieldset>
					</form>
			  </div>
			
			  <div id='bottomMenu'>
				<a href='FinalProject_Villains.html' >
					<img src='villainslink-01.png' alt='Top 10 Villains' class='pagelinks'>
				</a>
				<a href='index.html' >
					<img src='homelink-01.png' alt='Home' class='pagelinks'>
				</a>
				<a href='FinalProject_comments.php'>
					<img src='commentslink-01.png' alt='Comments'  class='pagelinks'>
				</a>
			  </div>";
	?>
</body>
</html>	
