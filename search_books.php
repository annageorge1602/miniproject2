

<?php
header('Content-Type: application/json');

$servername = "127.0.0.1";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "project"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['query'];
$sql = "SELECT book_name FROM selling WHERE book_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$bookNames = array();
while ($row = $result->fetch_assoc()) {
    $bookNames[] = $row['book_name'];
}

echo json_encode($bookNames);

$stmt->close();
$conn->close();
?>

