<?php

	session_start();

	$link = mysqli_connect("shareddb1a.hosting.stackcp.net","twitterdb-3450d2","cp3hAQjoF94R","twitterdb-3450d2");

	if (mysqli_connect_errno()) {
		print_r(mysqli_connect_error());
		exit();
	}

	if ($_GET['function'] == 'logout') {
		session_unset();
	}

	function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'h'),
        array(60 , 'min'),
        array(1 , 's')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
}

	function displayTweets($type) {

		global $link;

		if($type == 'public') {

			$whereClause = "";

		} else if($type == 'isfollowing') {

			$query = "SELECT * FROM following WHERE follower ='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
			
			$result = mysqli_query($link, $query);

			$whereClause = "";

			while($row = mysqli_fetch_assoc($result)) {

				if($whereClause == "") $whereClause = "WHERE";
				else $whereClause .= " OR";
				$whereClause .= " userid = ".$row['isfollowing'];

			}

		} else if ($type == 'yourtweets') {

			$whereClause = "WHERE userid = ".mysqli_real_escape_string($link,$_SESSION['id']);

		} else if ($type == 'search') {

			$whereClause = "WHERE tweet LIKE '%".mysqli_real_escape_string($link,$_GET['q'])."%'";

		} else if (is_numeric($type)) {

			$userQuery = "SELECT * FROM users WHERE id = '".mysqli_real_escape_string($link,$type)."' LIMIT 1";
				$userQueryResult = mysqli_query($link,$userQuery);
				$user = mysqli_fetch_assoc($userQueryResult);

			echo "<h2>".mysqli_real_escape_string($link,$user['email'])."'s Tweets</h2>";

			$whereClause = "WHERE userid = ".mysqli_real_escape_string($link,$type);

		}

		$query = "SELECT * FROM tweets ".$whereClause." ORDER BY datetime DESC LIMIT 10";

		$result = mysqli_query($link,$query);

		if (mysqli_num_rows($result) == 0) {
			echo "There are no tweets to display";
		} else {

			while($row = mysqli_fetch_assoc($result)) {

				$userQuery = "SELECT * FROM users WHERE id = '".mysqli_real_escape_string($link,$row['userid'])."' LIMIT 1";
				$userQueryResult = mysqli_query($link,$userQuery);
				$user = mysqli_fetch_assoc($userQueryResult);

				echo "<div class='tweet'><p><a href='?page=profiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>tweeted ".time_since(time() - strtotime($row['datetime']))." ago</span></p>";

				echo "<p>".$row['tweet']."</p>";

				echo "<a style='color:blue;' class='toggleFollow' data-userId='".$row['userid']."'>";

				$query2 = "SELECT * FROM following WHERE follower ='".mysqli_real_escape_string($link,$_SESSION['id'])."' AND isfollowing ='".mysqli_real_escape_string($link,$row['userid'])."' LIMIT 1";

		$result2 = mysqli_query($link, $query2);

		if (mysqli_num_rows($result2) > 0) echo "Unfollow";
		else echo "Follow";

				echo '</a></div>';

			}

		}

	}


	function displaySearch() {

		echo '<form class="form-inline">
		<div class="form-group">
		  <input type="hidden" name="page" value="search">
		  <input type="text" name="q" class="form-control mb-2 mr-sm-2 mb-sm-0" id="search" placeholder="Type something to search">
		
		  <button style="margin-top: 10px;"class="btn btn-primary">Search tweets</button>
		</div>
		</form>';

	}

	function displayTweetBox() {

		if($_SESSION['id'] > 0) {

			echo '<div class="alert alert-success" style="display:none;" id="tweetSuccess">Tweet success!</div>
			<div class="alert alert-danger" id="tweetFail" style="display:none;"></div>
			<div class="form">
			  <div class="form-group">
			    <textarea class="form-control" id="tweetContent"></textarea>
			  </div>
			
			  <button id="postTweetButton" class="btn btn-primary">Post Tweet</button>
			</div>';

		}

	}

	function displayUsers() {

		global $link;

		$query = "SELECT * FROM users LIMIT 15";

		$result = mysqli_query($link,$query);

			while($row = mysqli_fetch_assoc($result)) {

				echo "<p><a href='?page=profiles&userid=".$row['id']."'>".$row['email']."</a></p>";

			}

	}



?>