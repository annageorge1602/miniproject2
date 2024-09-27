<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit;
}
?>
<?php
// Include the database connection file
include 'db_connection.php';

// Get the id and user_type from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$user_type = isset($_GET['user_type']) ? $_GET['user_type'] : '';

if ($id != '' && $user_type != '') {
    // Fetch all details for the selected book based on both id and user_type
    $sql = "SELECT * FROM selling WHERE user_type = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_type, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "No book found with that id and user type.";
        exit;
    }
} else {
    echo "Invalid id or user type.";
    exit;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-image: url('https://img.freepik.com/premium-photo/stack-books-stationery-background-school-board_147376-4875.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    /* Navbar styles */
    .navbar {
        background-color: #007bff;
    }
    .navbar-brand {
        display: flex;
        align-items: center;
    }
    .navbar-brand img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .nav-link {
        color: white !important;
    }
    .container {
        margin-top: 50px;
        max-width: 800px;
    }
    .table {
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }
    .table th, .table td {
        padding: 15px;
        text-align: left;
        vertical-align: middle;
    }
    .book-details img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
    }
    .book-details img:hover {
        opacity: 0.8;
    }
    .enlarged-img {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
        z-index: 1000;
        border: 2px solid #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    .btn-primary, .btn-success {
        font-size: 18px;
        padding: 10px 20px;
        width: 150px; /* Make both buttons the same width */
    }
    /* Proceed form */
    #proceedForm {
        display: none;
        margin-top: 20px;
        padding: 20px;
        background-color: rgba(248, 249, 250, 0.9); /* Slightly transparent white background */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="k.jpg" alt="Logo">BooksMart
            </a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sellings.php">Sell</a>
                    </li>
                </ul>
            </div>
            <a class="btn btn-danger" href="signout.php">Sign Out</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center mb-4">Book Details</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Detail</th>
                    <th>Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Book Name</strong></td>
                    <td><?php echo $book['book_name']; ?></td>
                </tr>
                <tr>
                    <td><strong>Price</strong></td>
                    <td>₹<?php echo $book['price']; ?></td>
                </tr>
                <tr>
                    <td><strong>Place</strong></td>
                    <td><?php echo $book['place']; ?></td>
                </tr>
<?php if (!empty($book['category'])): ?>
    <tr>
        <td><strong>Category</strong></td>
        <td><?php echo $book['category']; ?></td>
    </tr>
<?php endif; ?>

                <tr>
                    <td><strong>Available for</strong></td>
                    <td><?php echo $book['rent_or_sell'] ? ucfirst($book['rent_or_sell']) : 'N/A'; ?></td>

                </tr>
                <tr>

<?php if ($book['rent_or_sell'] == 'rent') { ?>
<tr>
    <td><strong>Number of Days for Rent</strong></td>
    <td><?php echo $book['no_of_days']; ?></td>
</tr>
<?php } ?>

                <tr>
                    <td><strong>Owner Name</strong></td>
                    <td><?php echo $book['owner_name']; ?></td>
                </tr>
                  <tr>
                    <td><strong>Phone Number</strong></td>
                    <td><?php echo $book['phone_number']; ?></td>
                </tr>
                  <tr>
                    <td><strong>Email</strong></td>
                    <td><?php echo $book['email']; ?></td>
                </tr>
 <tr>
                    <td><strong>Payment Method</strong></td>
                    <td><?php echo $book['payment_method']; ?></td>
                </tr>
                <tr>
    <td><strong>Images(Front-side & Back-side)</strong></td>
    <td class="book-details">
        <!-- Book Front Image -->
        <img src="data:image/jpeg;base64,<?php echo base64_encode($book['book_image']); ?>" alt="Book Front Image" id="bookImage">
        
        <!-- Book Back Image -->
        <img src="data:image/jpeg;base64,<?php echo base64_encode($book['book_back_image']); ?>" alt="Book Back Image" id="bookBackImage" style="margin-left: 20px;">
    </td>
</tr>

            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Go Back</a>
            <button id="proceedButton" class="btn btn-success">Proceed</button>
        </div>



        <!-- Proceed Form -->
        <form id="proceedForm" class="mt-4">
<h3 class="text-center mb-4">Please Fill in Your Details to Complete the Transaction</h3>

            <div class="mb-3">
                <label for="customerName" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customerName" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label for="customerPhone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="customerPhone" placeholder="Enter your phone number" required>
            </div>
            <div class="mb-3">
                <label for="customerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="customerEmail" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Payment Method</label>
                <select class="form-select" id="paymentMethod" required>
                    <option value="cash">Cash</option>
                    <option value="qrcode">QR Code</option>
                    <option value="any">Any</option>
                </select>
            </div>
<!-- QR Code section, initially hidden -->
<div id="qrCodeRow" class="mb-3" style="display: none;">
    <label for="qrCode" class="form-label">Your QR Code</label>
    <!-- Fetching the QR code image dynamically using base64 encoding in PHP -->
    <img id="qrCodeImage" src="data:image/jpeg;base64,<?php echo base64_encode($book['qr_code_image']); ?>" alt="QR Code" style="width: 100px; cursor: pointer;">
</div>

            <button type="submit" class="btn btn-primary">Purchase</button>
        </form>
    </div>



    <!-- Enlarged Image Modal -->
    <div class="overlay" id="overlay"></div>
    <img id="enlargedImage" class="enlarged-img" src="data:image/jpeg;base64,<?php echo base64_encode($book['book_image']); ?>" alt="Enlarged Book Image">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle form visibility on proceed button click
        const proceedButton = document.getElementById('proceedButton');
        const proceedForm = document.getElementById('proceedForm');

        if (proceedButton && proceedForm) {
            proceedButton.addEventListener('click', function() {
                proceedForm.style.display = (proceedForm.style.display === 'none' || proceedForm.style.display === '') ? 'block' : 'none';
            });
        }

        // Handle image enlargement
        const enlargeImage = function(imageElement, imageUrl) {
            const enlargedImage = document.getElementById('enlargedImage');
            const overlay = document.getElementById('overlay');

            if (enlargedImage && overlay) {
                imageElement.addEventListener('click', function() {
                    enlargedImage.src = imageUrl;
                    enlargedImage.style.display = 'block';
                    overlay.style.display = 'block';
                });
            }
        };

        // Image elements
        const bookImage = document.getElementById('bookImage');
        const bookBackImage = document.getElementById('bookBackImage');
        const qrCodeImage = document.getElementById('qrCodeImage');

        if (bookImage) {
            enlargeImage(bookImage, 'data:image/jpeg;base64,<?php echo base64_encode($book['book_image']); ?>');
        }
        if (bookBackImage) {
            enlargeImage(bookBackImage, 'data:image/jpeg;base64,<?php echo base64_encode($book['book_back_image']); ?>');
        }
        if (qrCodeImage) {
            enlargeImage(qrCodeImage, 'data:image/jpeg;base64,<?php echo base64_encode($book['qr_code_image']); ?>');
        }

        // Hide enlarged image on overlay click
        const overlay = document.getElementById('overlay');
        const enlargedImage = document.getElementById('enlargedImage');

        if (overlay && enlargedImage) {
            overlay.addEventListener('click', function() {
                enlargedImage.style.display = 'none';
                overlay.style.display = 'none';
            });
        }

        // Handle payment method changes
        const paymentMethod = document.getElementById('paymentMethod');
        const qrCodeRow = document.getElementById('qrCodeRow');

        if (paymentMethod && qrCodeRow) {
            paymentMethod.addEventListener('change', function() {
                qrCodeRow.style.display = (this.value === 'qrcode') ? 'block' : 'none';
            });
        }
    });
</script>


</body>
</html>