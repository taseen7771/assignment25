<?php
include "db.php";

$username = 'admin'; // Change this if needed
$password = password_hash('admin123', PASSWORD_DEFAULT); // Password is 'admin123'

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "✅ Admin created successfully.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
