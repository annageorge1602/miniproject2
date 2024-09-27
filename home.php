<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BooksMart-Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css">
    <style>
        /* Logo */
        .logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* Company name */
        .company-name {
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Centered Navbar styling */
        .navbar-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar-nav .nav-link {
            padding-left: 20px;
            padding-right: 20px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #00bfff; /* Tint color on hover */
        }

        /* Increase space between 'Sell' and the search bar */
        .search-bar {
            width: 250px;
            margin-left: 40px; /* Increased margin to move search bar further away from 'Sell' */
        }

        /* Toast container styling */
        #toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            z-index: 1000;
        }

        /* Toast visible */
        #toast.show {
            opacity: 1;
        }

        /* Carousel styling */
        .carousel-item img {
            width: 100%;
            height: 100vh; /* Full viewport height */
            object-fit: cover;
        }

        .carousel-caption {
            bottom: 20%;
            text-align: center;
        }

        .carousel-caption h1 {
            font-size: 3rem;
            font-style: italic;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <!-- Logo and Company Name -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://via.placeholder.com/40" alt="Logo" class="logo">
                <span class="company-name ms-2">BooksMart</span>
            </a>

            <!-- Toggler for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Centered menu and search bar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-center">
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

                    <!-- Search bar with more space between 'Sell' -->
                    <form class="d-flex" action="searching.php" method="GET" id="search-form">
    <input class="form-control search-bar" type="search" placeholder="Search" name="query" aria-label="Search">
</form>


                </div>

                <!-- Sign Out button on the far right -->
              <form class="d-flex ms-auto" action="logout.php" method="post">
            <button class="btn btn-outline-danger" type="submit">Sign Out</button>
        </form>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
   <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find your favorite classics and rare finds</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find your favorite classics and rare finds</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img3.jpg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find your favorite classics and rare finds</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img4.jpg" class="d-block w-100" alt="Slide 4">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find your favorite classics and rare finds</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img6.jpg" class="d-block w-100" alt="Slide 5">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find your favorite classics and rare finds</h1>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="x.jpg" class="card-img-top" alt="Book 1">
                    <div class="card-body">
                        <h5 class="card-title">Students</h5>
                        <p class="card-text">Unlock academic success with affordable textbooks just a click away!</p>
                        <a href="student_db.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="y.jpg" class="card-img-top" alt="Book 2">
                    <div class="card-body">
                        <h5 class="card-title">Professionals</h5>
                        <p class="card-text">Upgrade your expertise with rare and valuable professional reads!</p>
                        <a href="professional_db.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="z.jpg" class="card-img-top" alt="Book 3">
                    <div class="card-body">
                        <h5 class="card-title">Casuals</h5>
                        <p class="card-text">Discover hidden gems and timeless classics at unbeatable prices!</p>
                        <a href="casuals_db.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark text-white text-center">
        <div class="container">
            <span>&copy; 2024 BooksMart. All rights reserved.</span>
        </div>
    </footer>

    <!-- Toast container -->
    <div id="toast"></div>

    <!-- Bootstrap and JS Scripts -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

$(document).ready(function() {
    // Initialize typeahead on the search input
$('.search-bar').typeahead({
    source: function(query, process) {
        return $.ajax({
            url: 'search_books.php',
            type: 'GET',
            data: { query: query },
            dataType: 'json',
            success: function(data) {
                return process(data);
            }
        });
    },
    afterSelect: function(item) {
        // Redirect to searching.php with the selected book name
        window.location.href = 'searching.php?query=' + encodeURIComponent(item);
    }
});

});

        function showToast(message) {
            var toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'show';

            setTimeout(function() {
                toast.className = toast.className.replace('show', '');
            }, 3000); // Toast visibility duration (3 seconds)
        }

    // Pass the PHP username into JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        var username = '<?php echo $username; ?>';
        showToast('Welcome, ' + username + '!'); // Show the username in the toast
    });
    </script>
</body>
</html>
