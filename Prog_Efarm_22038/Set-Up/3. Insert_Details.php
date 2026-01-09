<?php
require "db.php";

$sql1 = "Select id FROM rooms WHERE name = \"Modest Suite\"";
$result1 = $conn->query($sql1);
$room1 = $result1->fetch_assoc()["id"];

$sql2 = "Select id FROM rooms WHERE name = \"Luxury Suite\"";
$result2 = $conn->query($sql2);
$room2 = $result2->fetch_assoc()["id"];

$stmt = $conn->prepare("INSERT INTO room_details (section_text,image_path,room_id,sort_order)
		VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $section_text,$image_path,$room_id,$sort_order);

$section_text = "Though limited in space, you will find the Modest Suite knows how to make the most of what it is given! Never has a customer complained about tight space. Efficiency is this appartment's point of pride.";
$image_path = "modest_compact.jpg";
$room_id = $room1;
$sort_order = 1;
$stmt->execute();

$section_text = "Finished from a business meeting or a pleasant trip across the city? Get some well-deserved rest in our carefully made, well cleaned beds.";
$image_path = "modest_bed.jpg";
$room_id = $room1;
$sort_order = 2;
$stmt->execute();

$section_text = "Come morning, enjoy the pleasant sights of the outdoors through your curtains. A little something to signal your incredible day ahead at Hotel Verdania!";
$image_path = "modest_view.jpg";
$room_id = $room1;
$sort_order = 3;
$stmt->execute();

$section_text = "Enjoy all the space and comfort you could possibly want, right here in the Luxury Suite! Be it for your family, a group of friends out seeing the world, or an important business meeting. We are here to provide!";
$image_path = "luxury_hub.jpg";
$room_id = $room2;
$sort_order = 1;
$stmt->execute();

$section_text = "When all is said and done, enjoy the finest and most comfortable mattresses we have to offer. No insomnia is going to stop you from sleeping here!";
$image_path = "luxury_bed.jpg";
$room_id = $room2;
$sort_order = 2;
$stmt->execute();

$section_text = "Enjoy your mornings witnessing the sunrise from beneath your comfortable bed or atop the cozy balcony overlooking the forest surrounding the city. Let this be a dawn to remember.";
$image_path = "luxury_view.jpg";
$room_id = $room2;
$sort_order = 3;
$stmt->execute();

echo "New records created successfully!";
$stmt->close();
$conn->close();
?>