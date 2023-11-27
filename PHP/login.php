<?php

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Check if fields are empty
if (empty($username) || empty($password)) {
    echo json_encode(array('message' => 'Fill all the fields'));
    exit();
}

// Database connection
$servername = "localhost";
$username = "KRCT";
$password = "0088";
$dbname = "KRCE";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute a query to check if the email and password match
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);

$stmt->execute();

// Check the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('message' => 'Invalid email or password'));
}

$stmt->close();
$conn->close();

?>
