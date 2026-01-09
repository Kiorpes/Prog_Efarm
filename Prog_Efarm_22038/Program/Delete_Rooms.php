<?php

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['name'])) {
	header("Location: Admin_Login.php");
	exit;
}

$errors = [];

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$id = test_input($_GET['id']);
	$name = test_input($_GET['name'] ?? '');
	$price = test_input($_GET['price'] ?? '');
	$description = test_input($_GET['description'] ?? '');
	$accomodations = test_input($_GET['accomodations'] ?? '');
	$image = test_input($_GET['image'] ?? '');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = test_input($_POST['id']);
	$name = test_input($_POST['name']);
	$price = test_input($_POST['price']);
	$description = test_input($_POST['description']);
	$accomodations = test_input($_POST['accomodations']);
	$image = test_input($_POST['image']);
	
	
	if (empty($id)) {
        $errors[] = "Internal Error. Try leaving the page...";
    }
	
	if(empty($errors)) {
		require "db.php";
		$stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
		$stmt->bind_param("i", $id);
		try{
			$stmt->execute();
			$_SESSION['Notification'] = "Room Deleted Successfully!";
			
		} catch(Exception $e) {
			$_SESSION['Notification'] = "An Internal Server Error has occured...";
		}
		
		$stmt->close();
		$conn->close();

		header("Location: Room_Log.php");
		exit;
	}
}
	
?>

<html lang="en">
<head>
  <title>Hotel Verdania: Delete Room</title>
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
	<h1>Confirm Deletion</h1> <br>
	<h3>Really delete the following room?</h3> 
  </div>
  
  
  <form method="POST" class="text-center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <input type="hidden" name="id" value="<?= $id ?>">
		
        <div class="form-group">
			Room Name: <?= $name ?>
		</div>
        <div class="form-group">
			Price: <?= $price ?>
		</div>
        <div class="form-group">
			Description: <?= $description ?>
		</div>
        <div class="form-group">
			Accomodations: <?= $accomodations ?>
		</div>
        <div class="form-group">
			Image Path: <?= $image ?>
		</div>
		
		
		<?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
	  
	<br>
	<div class="my-4">
		<button type="submit" class="btn btn-outline-light btn-lg">Delete</button>
	</div>
</form>
  
  
  
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