<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link rel ="stylesheet" href="http://gustavorozato-com.stackstaging.com/twitter-clone/styles.css">
  </head>
  <body>

  <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="http://gustavorozato-com.stackstaging.com/twitter-clone/">Twitter</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="?page=timeline">Timeline<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=tweets">Tweets</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=profiles">Profiles</a>
      </li>
    </ul>
    <div class="form-inline my-2 my-lg-0">
    <?php if($_SESSION['id']) { ?>

    <a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">Logout</a>

    <?php } else { ?>
      <button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#myModal">Login/Signup</button>
      <?php } ?>
    </div>
  </div>
</nav>