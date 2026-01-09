<?php
require "db.php";

$stmt = $conn->prepare("INSERT INTO admins (name,password)
		VALUES (?, ?)");
$stmt->bind_param("ss", $name,$password);

$name = "kapoios";
$password = "$2y$10\$wH0k00DVpKhr3RA94tLM3.LHlU1dScmEQFyNu9/A.BH8F7K0Eadyq"; // allos
$stmt->execute();

$name = "Vasilis";
$password = "$2y$10\$zE9gUPU5libvzx1gGO7.kewHDgFMsc/e/3ko7BszJ3Tb3GnkAukXq"; // kior
$stmt->execute();

echo "New records created successfully!";
$stmt->close();
$conn->close();
?>