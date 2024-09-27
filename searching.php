<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['query'];
$sql = "SELECT id, book_name, price, place, book_image, user_type FROM selling WHERE book_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center; /* Center content in card */
        }
        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            background: #fff;
            padding: 20px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .card-title {
            color: #007bff;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            color: #555;
        }
        h2 {
            color: #007bff;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }
        .btn-more {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 25px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 10px; /* Space above the button */
        }
        .btn-more:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
        /* Navbar styles */
        .navbar {
            margin-bottom: 50px;
        }
        .navbar-nav {
            flex-direction: row;
            justify-content: center; /* Center menu items */
        }
        .nav-item {
            margin-left: 15px;
            margin-right: 15px;
        }
        .nav-link {
            font-size: 1.1rem;
            font-weight: bold;
            color: #007bff;
            text-transform: uppercase;
        }
        .nav-link:hover {
            color: #0056b3;
        }
        .navbar-brand {
            flex-grow: 1;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">BookSmart</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="proceed.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="proceed.php">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="proceed.php">Sell</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Sign Out</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if (!is_null($row['book_image']) && !empty($row['book_image'])): ?>
                            <?php $imageData = base64_encode($row['book_image']); ?>
                            <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($imageData); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['book_name']); ?>">
                        <?php else: ?>
                            <img src="placeholder.jpg" class="card-img-top" alt="Placeholder Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['book_name']); ?></h5>
                            <p class="card-text">Place: <?php echo htmlspecialchars($row['place']); ?></p>
                            <p class="card-text">Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                            <a href="proceed.php?id=<?php echo urlencode($row['id']); ?>&user_type=<?php echo urlencode($row['user_type']); ?>" class="btn-more">More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    No results found for "<?php echo htmlspecialchars($query); ?>".
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
