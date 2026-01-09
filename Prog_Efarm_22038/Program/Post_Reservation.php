<?php
session_start();
if (!isset($_SESSION['Result']) || !isset($_SESSION['Status'])) {
	header("Location: Entry_Page.php");
	exit;
}
?>

<html lang="en">
<head>
  <title>Hotel Verdania: Post-Reservation</title>
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
  <!-- Brand/logo -->
  <a class="navbar-brand" href="Entry_Page.php">
    <img src="site_images/Logo_long.png" alt="logo" style="width:100px;">
  </a>
  
  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="Entry_Page.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="View_Rooms.php">Rooms</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">History</a>
    </li>
	<li class="nav-item">
      <a class="nav-link" href="#footer">Contact us</a>
    </li>
  </ul>
</nav>

<div class="container flex-fill" id="main">
  <div class="jumbotron text-center">
	<?php if ($_SESSION['Status'] == "Success"): ?>
		<h1><?= $_SESSION['Result'] ?></h1>
		<h1>was submitted succesfully!</h1><br>
		<p>You reserved the room as follows:</p>
		<p>Name: <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Not found...'; ?></p>
		<p>Start Date: <?php echo isset($_SESSION['start_date']) ? $_SESSION['start_date'] : 'Not found...'; ?></p>
		<p>End Date: <?php echo isset($_SESSION['end_date']) ? $_SESSION['end_date'] : 'Not found...'; ?></p><br>
		<p>We hope to meet you soon!</p>
	
	<?php elseif ($_SESSION['Status'] == "Failure"): ?>
		<h1><?= $_SESSION['Result'] ?></h1> <br>
		<p>We apologise for the inconvenience...</p>
	
	<?php else: ?>
		<h1>Improbable Error</h1> <br>
		<p>An unexpected error has occured.</p>
		<p>We apologise for the inconvenience...</p>
	
	<?php endif; 	
	session_unset();
	session_destroy(); ?>
			
  </div>
  
  <div class="text-center my-4">
  <form action="Entry_Page.php">
	<button type="submit" class="btn btn-outline-light btn-lg">Go Back</button>
  </form>
</div><br>
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