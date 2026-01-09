<?php
require "db.php";

$sql1 = "Select id FROM rooms WHERE name = \"Modest Suite\"";
$result1 = $conn->query($sql1);
$room1 = $result1->fetch_assoc()["id"];

$sql2 = "Select id FROM rooms WHERE name = \"Luxury Suite\"";
$result2 = $conn->query($sql2);
$room2 = $result2->fetch_assoc()["id"];

$stmt = $conn->prepare("INSERT INTO reservations (start, end, name, room)
		VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $start, $end, $name, $room_id);

$start = "2026-06-06";
$end = "2026-06-07";
$name = "George";
$room_id = $room1;
$stmt->execute();

$start = "2026-07-07";
$end = "2026-07-08";
$name = "Lucas";
$room_id = $room1;
$stmt->execute();

$start = "2026-08-06";
$end = "2026-09-06";
$name = "Evonne";
$room_id = $room2;
$stmt->execute();

$start = "2026-10-06";
$end = "2026-10-07";
$name = "Maria";
$room_id = $room1;
$stmt->execute();

$start = "2026-06-11";
$end = "2026-06-12";
$name = "Nick";
$room_id = $room2;
$stmt->execute();

$start = "2026-01-06";
$end = "2026-02-06";
$name = "George";
$room_id = $room1;
$stmt->execute();

echo "New records created successfully!";
$stmt->close();
$conn->close();
?>