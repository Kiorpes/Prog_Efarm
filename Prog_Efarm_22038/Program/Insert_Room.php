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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = test_input($_POST['name']);
	$price = test_input($_POST['price']);
	$description = test_input($_POST['description']);
	$accomodations = test_input($_POST['accomodations']);
	$image = test_input($_POST['image']);
	
	if (empty($name)) {
        $errors[] = "Room Name is required.";
    }
	if (empty($price)) {
        $errors[] = "Price is required.";
    }
	if (empty($description)) {
        $errors[] = "Description is required.";
    }
	if (empty($accomodations)) {
        $errors[] = "Accomodations are required.";
    }
	if (empty($image)) {
        $errors[] = "Image Path is required.";
    }
	if (!is_numeric($price)) {
		$errors[] = "Price must be numeric.";
	}
	
	if(empty($errors)) {
		require "db.php";
		$stmt = $conn->prepare("INSERT INTO rooms (name, accomodations, price, description, image_path) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("ssiss", $name, $accomodations, $price, $description, $image);
		try{
			$stmt->execute();
			$_SESSION['Notification'] = "Insertion Successful!";
			
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
  <title>Hotel Verdania: Insert Room</title>
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
	<h1>Insert Room</h1>
	<p>Write down the new room's data:</p> 
  </div>
  
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
	<div class="row">
      <div class="col-md-8">
        <div class="form-group">
            <label for="name">Room Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
        </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" name="price" value="<?php echo isset($price) ? $price : ''; ?>"required>
        </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="price">Description:</label>
            <input type="textfield" class="form-control" name="description" value="<?php echo isset($description) ? $description : ''; ?>"required>
        </div>
	 </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="price">Accomodations:</label>
            <input type="text" class="form-control" name="accomodations" value="<?php echo isset($accomodations) ? $accomodations : ''; ?>"required>
        </div>
	 </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="price">Image Path:</label>
            <input type="text" class="form-control" name="image" value="<?php echo isset($image) ? $image : ''; ?>"required>
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