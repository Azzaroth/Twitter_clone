<?php

	include("functions.php");

	if($_GET['action'] == "loginSignup") {

		$error = "";

		if(!$_POST['email']) {
			$error = $error."<p>Email required</p>";
		}

		if(!$_POST['password']) {
			$error = $error."<p>Password required</p>";
		}

		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  			$error = $error."<p>Invalid email</p>";
		}

		if ($error != "") {
			echo $error;
			exit();
		}

		if($_POST['loginActive'] == '0') {

			$query = "SELECT * FROM users WHERE email ='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0) {

				echo "Emal address already taken";

			}
			
			else {

				$query = "INSERT INTO users (email,password) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";

				if(mysqli_query($link,$query)) {

					$_SESSION['id'] = mysqli_insert_id($link);
					
					$query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = '".mysqli_insert_id($link)."' LIMIT 1";

					mysqli_query($link,$query);

					echo 1;

				}
				else {

					echo "Couldn't create user.";

				}


			}


		} else if($_POST['loginActive'] == '1') {

			$query = "SELECT * FROM users WHERE email ='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_assoc($result);
			
			if($row['password'] == md5(md5($row['id']).$_POST['password'])) {

				$_SESSION['id'] = $row['id'];

				echo 1;

			} else {

				$error = $error."Could not find username or password";
				echo $error;

			}

		}

	}

	if ($_GET['action'] == "toggleFollow") {

		$query = "SELECT * FROM following WHERE follower ='".mysqli_real_escape_string($link,$_SESSION['id'])."' AND isfollowing ='".mysqli_real_escape_string($link,$_POST['userId'])."' LIMIT 1";

		$result = mysqli_query($link, $query);

		if (mysqli_num_rows($result) > 0) {

			$row = mysqli_fetch_assoc($result);

			$deleteQuery = "DELETE FROM following WHERE id ='".mysqli_real_escape_string($link,$row['id'])."' LIMIT 1";

			mysqli_query($link, $deleteQuery);

			echo 1;

		} else {

			$insertQuery = "INSERT INTO following (follower, isfollowing) VALUES (".mysqli_real_escape_string($link,$_SESSION['id']).",".mysqli_real_escape_string($link,$_POST['userId']).")";
			
			mysqli_query($link, $insertQuery);

			echo 2;

		}

	}

	if($_GET['action'] == 'postTweet') {

		if(!$_POST['tweetContent']) {

			echo "Your tweet is empty.";

		} else if(strlen($_POST['tweetContent']) > 140) {

			echo "Your tweet is too long.";

		} else {

			$insertQuery = "INSERT INTO tweets (tweet, userid, datetime) VALUES ('".mysqli_real_escape_string($link,$_POST['tweetContent'])."',".mysqli_real_escape_string($link,$_SESSION['id']).", NOW())";
			
			mysqli_query($link, $insertQuery);

			echo 1;

		}

	}

?>