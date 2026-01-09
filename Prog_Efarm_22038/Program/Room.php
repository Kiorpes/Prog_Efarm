<?php
require "db.php";

if (!isset($_GET['id'])) {
	header("Location: View_Rooms.php");
	exit;
}

$roomId =  test_input($_GET['id']);

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->bind_param("i", $roomId);
$stmt->execute();
$room = $stmt->get_result()->fetch_assoc();

if (!$room) {
    die("Room not found");
}

$secStmt = $conn->prepare(
    "SELECT image_path, section_text
     FROM room_details 
     WHERE room_id = ?
     ORDER BY sort_order ASC"
);
$secStmt->bind_param("i", $roomId);
$secStmt->execute();
$sections = $secStmt->get_result();

$stmt->close();
$secStmt->close();
$conn->close();
?>

<html lang="en">
<head>
  <title>Hotel Verdania: <?= htmlspecialchars($room['name']) ?></title>
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
	<h1><?= htmlspecialchars($room['name']) ?></h1>
  </div>

<?php $i = 0; ?>
<?php while ($section = $sections->fetch_assoc()): ?>
<div class="row align-items-center my-5">
    
    <div class="col-md-6 <?= ($i % 2 !== 0) ? 'order-md-2' : '' ?>">
        <img src="db_images/<?= htmlspecialchars($section['image_path']) ?>"
             class="img-fluid rounded shadow-lg mb-5"
             alt="Room image">
    </div>
	
    <div class="col-md-6">
        <p><?= nl2br(htmlspecialchars($section['section_text'])) ?></p>
    </div>
	
</div>
<?php $i++; endwhile; ?>

<?php if ($i == 0): ?>  <!-- If no section data was posted, post the room data again instead (yes I couldn't find a better way to do this I'm sorry Mr. Reader) -->
<div class="row align-items-center my-5">
    
    <div class="col-md-6 <?= ($i % 2 !== 0) ? 'order-md-2' : '' ?>">
        <img src="db_images/<?= htmlspecialchars($room['image_path']) ?>"
             class="img-fluid rounded shadow-lg mb-5"
             alt="Room image">
    </div>

    <div class="col-md-6">
        <p><?= nl2br(htmlspecialchars($room['description'])) ?></p>
    </div>

</div>
<?php endif; ?>


<br>
<div class="text-center my-4">
  <form method="get" action="Reservations.php">
	<p>Like what you see?</p>
	<input type="text" name="id" value="<?= $roomId ?>" hidden>
	<input type="text" name="room_name" value="<?= htmlspecialchars($room['name']) ?>" hidden>
	<button type="submit" class="btn btn-outline-light btn-lg">Make a Reservation!</button>
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
