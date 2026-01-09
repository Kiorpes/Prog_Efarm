<?php

$roomsPerPage = 5;

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['name'])) {
	header("Location: Admin_Login.php");
	exit;
}

require "db.php";

function test_input($data) {
  $data = strtolower($data);
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  
  return $data;
}

function sort_arrow($column, $sort, $order) { // for putting ▲ or ▼ next to the headers of the table when sorting
	if ($sort == $column) {
		if ($order == 'asc') 
			return '<span class="ml-1">▲</span>';
		else
			return '<span class="ml-1">▼</span>';
	}
}

$allowed_columns = ['name','price','description', 'accomodations','image'];
$allowed_directions = ['asc', 'desc'];

$sort = test_input($_GET['sort'] ?? 'name');
$order = test_input($_GET['order'] ?? 'asc');

$notification = $_SESSION['Notification'] ?? '';
$_SESSION['Notification'] = '';

if (!in_array($sort, $allowed_columns, true)) {
    $sort = 'name';
}
if (!in_array($order, $allowed_directions, true)) {
    $order = 'asc';
}

$sort_order = $sort . " " . $order;

/* Get total room count */
$countResult = $conn->query("SELECT COUNT(*) AS total FROM rooms");
$totalRooms = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRooms / $roomsPerPage);

$page = test_input($_GET['page'] ?? 1);
if ($page > $totalPages) {
	$page = $totalPages;
}
$offset = ($page - 1) * $roomsPerPage;

/* Get rooms */
$stmt = $conn->prepare("SELECT *
						FROM rooms
						ORDER BY " . $sort_order ."
						LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $roomsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<html lang="en">
<head>
  <title>Hotel Verdania: Manage Rooms</title>
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
	<h2>Room Management</h2> <br>
	<p> <?= $notification	 ?> </p>
  </div>
	
<table class="table table-hover table-warning table-striped text-center">
    <thead class="thead">
        <tr>
            <th width="20%">
                <a href="?page=<?= $page ?>&sort=name&order=<?= $order === 'asc' ? 'desc' : 'asc' ?>">
                    Room Name <?= sort_arrow('name', $sort, $order) ?>
                </a>
            </th>
            <th width="10%">
                <a href="?page=<?= $page ?>&sort=price&order=<?= $order === 'asc' ? 'desc' : 'asc' ?>">
                    Price <?= sort_arrow('price', $sort, $order); ?>
                </a>
            </th>
            <th width="35%">
                <a href="?page=<?= $page ?>&sort=description&order=<?= $order === 'asc' ? 'desc' : 'asc' ?>">
                    Description <?= sort_arrow('description', $sort, $order); ?>
                </a>
            </th>
            <th width="10%">
                <a href="?page=<?= $page ?>&sort=accomodations&order=<?= $order === 'asc' ? 'desc' : 'asc' ?>">
                    Accomodations <?= sort_arrow('accomodations', $sort, $order); ?>
                </a>
            </th>
			<th width="20%">
                <a href="?page=<?= $page ?>&sort=image&order=<?= $order === 'asc' ? 'desc' : 'asc' ?>">
                    Image Path <?= sort_arrow('image', $sort, $order); ?>
                </a>
            </th>
			<th width="5%">
                <a href="Insert_Room.php">
                    <h2>+</h2>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['price']) ?></td>
				<td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['accomodations']) ?></td>
                <td><?= htmlspecialchars($row['image_path']) ?></td>
				<td>
					<form action="Update_Room.php" method="get">
						<input type="text" name="id" value="<?= $row['id'] ?>" hidden>
						<input type="text" name="name" value="<?= $row['name'] ?>" hidden>
						<input type="text" name="price" value="<?= $row['price'] ?>" hidden>
						<input type="text" name="description" value="<?= $row['description'] ?>" hidden>
						<input type="text" name="accomodations" value="<?= $row['accomodations'] ?>" hidden>
						<input type="text" name="image" value="<?= $row['image_path'] ?>" hidden>
						<input type="image" alt="edit" src="site_images/edit.png" width="25" height="25">
					</form>
					
					<form action="Delete_Rooms.php" method="get">
						<input type="text" name="id" value="<?= $row['id'] ?>" hidden>
						<input type="text" name="name" value="<?= $row['name'] ?>" hidden>
						<input type="text" name="price" value="<?= $row['price'] ?>" hidden>
						<input type="text" name="description" value="<?= $row['description'] ?>" hidden>
						<input type="text" name="accomodations" value="<?= $row['accomodations'] ?>" hidden>
						<input type="text" name="image" value="<?= $row['image_path'] ?>" hidden>
						<input type="image" alt="delete" src="site_images/delete.png" width="25" height="25"> </button>
					</form>
				</td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>


<nav>
<ul class="pagination justify-content-center">

    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page - 1 ?>&sort=<?= $sort ?>&order=<?= $order ?>">Previous</a>

<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link"
           href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>">
            <?= $i ?>
        </a>
    </li>
<?php endfor; ?>
	<li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page + 1 ?>&sort=<?= $sort ?>&order=<?= $order ?>">Next</a>
    </li>
</ul>
</nav> <br>
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