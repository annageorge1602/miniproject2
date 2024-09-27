<?php
// Include the database connection file
include 'db_connection.php';

// Initialize an array to hold errors
$errors = [];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO selling (book_name, price, owner_name, phone_number, place, email, pincode, user_type, payment_method, book_image, book_back_image, qr_code_image, category, rent_or_sell, no_of_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    $errors[] = "Preparation failed: " . $conn->error;
    echo json_encode(['success' => false, 'message' => implode(", ", $errors)]);
    exit();
}

// Bind parameters
$stmt->bind_param("sissssisssssssi", $book_name, $price, $owner_name, $phone_number, $place, $email, $pincode, $user_type, $payment_method, $book_image, $book_back_image, $qr_code_image, $category, $rent_or_sell, $no_of_days);

// Get the form data
$book_name = $_POST['bookName'];
$price = $_POST['price'];
$owner_name = $_POST['ownerName'];
$phone_number = $_POST['phoneNumber'];
$place = $_POST['place'];
$email = $_POST['email'];
$pincode = $_POST['pincode'];
$user_type = $_POST['userType'];
$payment_method = $_POST['paymentMethod'];
$category = isset($_POST['category']) ? $_POST['category'] : null;
$rent_or_sell = isset($_POST['typeDropdown']) ? $_POST['typeDropdown'] : null;
$no_of_days = isset($_POST['rentDays']) ? (int)$_POST['rentDays'] : null;

// Handle image uploads
if (isset($_FILES['bookImage']) && $_FILES['bookImage']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['bookImage']['tmp_name'];
    $book_image = file_get_contents($fileTmpPath);
} else {
    $book_image = null;
}

if (isset($_FILES['bookBackImage']) && $_FILES['bookBackImage']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['bookBackImage']['tmp_name'];
    $book_back_image = file_get_contents($fileTmpPath);
} else {
    $book_back_image = null;
}

// Handle QR Code image upload if necessary
if ($payment_method == 'qrCode' || $payment_method == 'any') {
    if (isset($_FILES['qrCodeUpload']) && $_FILES['qrCodeUpload']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['qrCodeUpload']['tmp_name'];
        $qr_code_image = file_get_contents($fileTmpPath);

        // Validate file type
        $fileType = mime_content_type($fileTmpPath);
        if (strpos($fileType, 'image/') === false) {
            $errors[] = "Uploaded file is not an image.";
            $qr_code_image = null;
        }
    } else {
        $qr_code_image = null; // No QR code image
    }
} else {
    $qr_code_image = null; // No QR code image
}

// Execute the statement
if ($stmt->execute()) {
    $response = ['success' => true];
} else {
    $errors[] = "Error inserting data: " . $stmt->error;
    $response = ['success' => false, 'message' => implode(", ", $errors)];
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
