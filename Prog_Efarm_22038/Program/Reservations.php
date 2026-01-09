<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (!isset($_GET['id']) || !isset($_GET['room_name'])) {
		header("Location: View_Rooms.php");
		exit;
	}
	$roomId =  test_input($_GET['id']);
	$roomName = test_input($_GET['room_name']);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['id']) || !isset($_POST['room_name'])) {
		header("Location: View_Rooms.php");
		exit;
	}
	$roomId =  test_input($_POST['id']);
	$roomName = test_input($_POST['room_name']);
	$name = test_input($_POST['name']);
	$start_date = test_input($_POST['start_date']);
	$end_date = test_input($_POST['end_date']);
	
	require "db.php";
	
	$current_date = new DateTime();
    $start_date_test = new DateTime($start_date);
    $end_date_test = new DateTime($end_date);

	if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if ($start_date_test <= $current_date) {
        $errors[] = "Start date must be in the future.";
    }
    if ($end_date_test <= $current_date) {
        $errors[] = "End date must be in the future.";
    } 
	if ($end_date_test <= $start_date_test) {
        $errors[] = "End date must be later than the start date.";
    }
	
	if (empty($errors)) {
		$stmt = $conn->prepare("INSERT INTO reservations (room, name, start, end) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("isss", $roomId, $name, $start_date, $end_date);
		session_start();
		try{
			$stmt->execute();
			$_SESSION['Status'] = "Success";
			$_SESSION['Result'] = "Reservation for " . $roomName;
			$_SESSION['name'] = $name;
			$_SESSION['start_date'] = $start_date;
			$_SESSION['end_date'] = $end_date;
		} catch(Exception $e) {
			$_SESSION['Status'] = "Failure";
			$_SESSION['Result'] = "An internal error has occured!";
		}
		$stmt->close();
		$conn->close();
		
		header("Location: Post_Reservation.php");
		exit;
	}
} else {
	header("Location: View_Rooms.php");
	exit;
}
?>

<html lang="en">
<head>
  <title>Reservation Form: <?= $roomName ?></title>
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
  <a class="navbar-brand" href="Entry_Page.php">
    <img src="site_images/Logo_long.png" alt="logo" style="width:100px;">
  </a>
  
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

<div class="container" id="main">
  <div class="jumbotron text-center">
	<h1>Reservation for: <?= $roomName ?></h1>
	<p>Simply fill in the info!</p> 
  </div>
  
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
	<input type="text" name="id" value="<?= $roomId ?>" hidden>
	<input type="text" name="room_name" value="<?= $roomName ?>" hidden>
		
	<div class="row">
      <div class="col-md-8">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
        </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>" required>
        </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>" required>
        </div>
	  </div>
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
	
	<div class="text-center my-4">
		<button type="submit" class="btn btn-outline-light btn-lg">Submit</button>
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