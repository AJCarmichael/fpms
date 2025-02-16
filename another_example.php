<?php
// ...existing code...

// Example of vulnerable SQL query
// $sql = "INSERT INTO users (username, email) VALUES ('$username', '$email')";
// mysqli_query($conn, $sql);

// Secure version using prepared statements
$stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();

// ...existing code...
?>
