<?php
session_start();

$errors = [];

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = test_input($_POST['name']);
	
	if (empty($name)) {
        $errors[] = "Name is required.";
    }
	
	if (empty(test_input($_POST['pass']))) {
		$errors[] = "Password is required.";
	}

	if(empty($errors)) {
		require "db.php";
		$stmt = $conn->prepare("SELECT * FROM admins WHERE name = ?");
		$stmt->bind_param("s", $name);
		try{
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0 &&
				password_verify(test_input($_POST['pass']), $result->fetch_assoc()['password'])) 
			{
				$_SESSION['user'] = "admin";
				$_SESSION['name'] = $name;
			
			} else {
				$errors[] = "Invalid Name or Password...";
			}
		} catch(Exception $e) {
		$errors[] = "A server error has occured!";
		}
		$stmt->close();
		$conn->close();
	}
}

if (isset($_SESSION['user'])) {
	if ($_SESSION["user"] == 'admin') {
		header("Location: Admin_Main.php");
		exit;
	}
}

?>

<html lang="en">
<head>
  <title>Hotel Verdania: Admin Login</title>
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

<div class="container" id="main">
  <div class="jumbotron text-center">
	<h2>Note: Operator site</h2> <br>
	<p>This is a login form for Hotel Workers.</p>
	<p>If you are a visitor, you can simply revert to</p>
	<a class="nav-link" href="Entry_Page.php">the Home page.</a>
  </div>
  
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
	<div class="row">
      <div class="col-md-8">
        <div class="form-group">
            <label for="name">Admin Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
        </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-8">
        <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" class="form-control" id="pass" name="pass" required>
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
	  </div>
	</div>
	
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