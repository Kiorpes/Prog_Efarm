<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['name'])) {
	header("Location: Admin_Login.php");
	exit;
}
?>

<html lang="en">
<head>
  <title>Hotel Verdania: Admin Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel='stylesheet' type='text/css' href='mystyle.css' />
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center" id="nav">
  <a class="navbar-brand" href="Admin_Main.php">
    <img src="site_images/Logo_long.png" alt="logo" style="width:100px;">
  </a>
  
  <ul class="navbar-nav">
	<li class="nav-item">
      <a class="nav-link" href="Reservation_Log.php">Reservations</a>
    </li>
	<li class="nav-item">
      <a class="nav-link" href="Room_Log.php">Rooms</a>
    </li>
		<li class="nav-item">
      <a class="nav-link" href="Logout.php">Log Out</a>
    </li>
  </ul>
</nav>

<div class="container" id="main">
  <div class="jumbotron text-center">
	<h2>Welcome, <?= $_SESSION['name'] ?></h2><br>
	<p>What follows below</p>
	<p>is your site admin options:</p>
  </div>
  <div class="container shadow-lg p-4 mb-5 rounded text-center my-4" style="border:5px solid brown">
	<p>
		Need to inspect Hotel reservations?
	</p>
	<form action="Reservation_Log.php">
		<button type="submit" class="btn btn-outline-light btn-lg">View Reservations</button>
	</form>
	</div><br>
	
	<div class="container shadow-lg p-4 mb-5 rounded text-center my-4" style="border:5px solid brown">
		<p>
			Wish to manage Hotel Rooms on the site?
		</p>
		<form action="Room_Log.php">
			<button type="submit" class="btn btn-outline-light btn-lg">Manage Rooms</button>
		</form>
	</div>
<br>
<div class="row bg-dark text-white" id="footer">
	<div class="col-2"></div>
	<div class="col-5">
		<h4 class="footer_header">Contact us at:</h3>
		<p><img id="phone" src="site_images/telephone.png" width="25" height="25"> Phone: 14028195</p>
		<p><img id="email" src="site_images/email.png" width="25" height="25"> Mail: ver@falsemail.com</p>
	</div>
	<div class="col-5">
		<h4 class="footer_header">Find us at:</h3>
		<p><img id="house" src="site_images/house.png" width="25" height="25"> Location: Serres, Greece</p>
		<p><img id="location" src="site_images/location.png" width="25" height="25"> Coordinates: 41°04'28.6"N 23°33'18.6"E</p>
	</div>
</div>
</div>
</body>
</html>
	
	
