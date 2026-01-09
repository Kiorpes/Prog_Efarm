<?php
require "db.php";

$roomsPerPage = 4;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $roomsPerPage;

/* Get total room count */
$countResult = $conn->query("SELECT COUNT(*) AS total FROM rooms");
$totalRooms = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRooms / $roomsPerPage);

/* Get rooms */
$stmt = $conn->prepare("SELECT * FROM rooms LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $roomsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<html lang="en">
<head>
  <title>Hotel Verdania: Rooms</title>
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
	<h1>Rooms for you</h1>
	<p>Browse and find the perfect match!</p> 
  </div>

<div class="container" id="main">
<?php while ($room = $result->fetch_assoc()): ?>
<div class="container-fluid shadow-lg p-4 mb-5 rounded" style="border:5px solid brown">
	 <div class="room-section left">
		<img src="db_images/<?= htmlspecialchars($room['image_path']) ?>" width="300">
        <div class="text">
			<h3><?= htmlspecialchars($room['name']) ?></h3>
			<p><?= htmlspecialchars($room['description']) ?></p>
			<p>Accomodations: <?= htmlspecialchars($room['accomodations']) ?></p>
			<p><strong>$<?= $room['price'] ?>/night</strong></p>
		</div>

		<form action="Room.php" method="get">
			<input type="text" name="id" value="<?= $room['id'] ?>" hidden>
			<button type="submit" class="btn btn-outline-light">View Details</button>
		</form>

    </div>
</div>
<?php endwhile; ?>

<nav>
  <ul class="pagination justify-content-center nowrap">
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
    </li>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
    </li>
  </ul>
</nav>

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