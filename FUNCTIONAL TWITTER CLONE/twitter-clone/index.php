<?php

	include ('functions.php');

	include('views/header.php');

	if($_GET['page'] == 'timeline') {

		include('views/timeline.php');

	} else if($_GET['page'] == 'tweets') {

		include("views/yourtweets.php");

	} else if($_GET['page'] == 'search') {

		include("views/search.php");

    } else if($_GET['page'] == 'profiles') {

    	include("views/profiles.php");

	} else {

	include('views/home.php');

	}

	include('views/footer.php');





?>