<?php
require "db.php";

$stmt = $conn->prepare("INSERT INTO rooms (name,price,description,accomodations,image_path)
		VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $price, $description, $accomodations, $image);

$name = "Modest Suite";
$price = "199.99";
$description = "Here on business, to explore the city, or perhaps on the way elsewhere? The Modest Suite offers an economic option just for you!";
$accomodations = "1 person";
$image = "modest_main.jpg";
$stmt->execute();

$name = "Luxury Suite";
$price = "499.99";
$description = "Our Hotel's finest is found here, within the Luxury Suite. Enjoy the very best we have to offer now.";
$accomodations = "6 people";
$image = "luxury_main.jpg";
$stmt->execute();

$name = "Stay for Two";
$price = "249.99";
$description = "One room not cutting it? Our dual rooms have belonged to some of our highest reviewing customers yet!";
$accomodations = "2 people";
$image = "duo_main.jpg" ;
$stmt->execute();

$name = "Nice and Spacious";
$price = "299.99";
$description = "Here with family? Treat them to all the room they can possibly need right here on Verdania Hotel.";
$accomodations = "5 people";
$image = "spacious_main.jpg" ;
$stmt->execute();

$name = "Fair and Fine";
$price = "299.99";
$description = "Come alone, and looking for a compromise between price and luxury? We have just the thing for you in this offer!";
$accomodations = "1 person";
$image = "fine_main.jpg" ;
$stmt->execute();


echo "New records created successfully!";
$stmt->close();
$conn->close();
?>
