<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login – Pick n Go</title>

    <!-- Include Bootstrap for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        /* Aesthetic styling */
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .logo {
            width: 120px;
            display: block;
            margin: 0 auto 15px;
        }
        .btn-custom {
            background: #28a745;
            color: white;
        }
        .btn-custom:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <main class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="login-container">
            <!-- Logo -->
            <img src="/frontend/public/picknGologo.png" alt="Pick n Go Logo" class="logo">

            <h2 class="text-center text-dark fw-bold">Customer Login</h2>

            <form action="customer_login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn btn-custom w-100">Login</button>
            </form>

            <p class="text-center mt-3">
                Don't have an account? <a href="customer_register.php" class="text-success fw-bold">Sign up</a>
            </p>
        </div>
    </main>
</body>
</html>
