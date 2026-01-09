<?php
require "db.php";

$sql1 = "CREATE TABLE rooms (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(70) NOT NULL,
		price VARCHAR(20) NOT NULL,
		description TEXT NOT NULL, 
		accomodations VARCHAR(20) NOT NULL, 
		image_path VARCHAR(30) NOT NULL);";
		
$sql2 = "CREATE TABLE room_details (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		section_text TEXT NOT NULL,
		image_path VARCHAR(30) NOT NULL,
		room_id INT(6) UNSIGNED NOT NULL,
		sort_order INT(2),
		FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE);";
		
$sql3 = "CREATE TABLE reservations (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		start Date NOT NULL,
		end Date NOT NULL,
		name VARCHAR(50) NOT NULL,
		room INT(6) UNSIGNED NOT NULL,
		FOREIGN KEY (room) REFERENCES rooms(id) ON DELETE CASCADE);";
		
$sql4 = "CREATE TABLE admins (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(30) UNIQUE NOT NULL,
		password VARCHAR(60) NOT NULL);";
		
		
		
		if($conn->query($sql1) === TRUE) {
			echo "Table 'rooms' created successfully!";
		} else {
			echo "Error creating 'rooms' table: " . $conn->error;
		}
		
		echo "<br/>";
		
		if($conn->query($sql2) === TRUE) {
			echo "Table 'room_details' created successfully!";
		} else {
			echo "Error creating 'room_details' table: " . $conn->error;
		}
		
		echo "<br/>";
		
		if($conn->query($sql3) === TRUE) {
			echo "Table 'reservations' created successfully!";
		} else {
			echo "Error creating 'reservations' table: " . $conn->error;
		}
		
		echo "<br/>";
		
		if($conn->query($sql4) === TRUE) {
			echo "Table 'reservations' created successfully!";
		} else {
			echo "Error creating 'reservations' table: " . $conn->error;
		}
		
		mysqli_close($conn);