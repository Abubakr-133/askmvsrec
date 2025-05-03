<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 shadow">
                    <h3 class="mb-3">Login</h3>
                    <form action="validate_login.php" method="post">
                        <div class="mb-3">
                            <label for="roll_number" class="form-label">Roll Number</label>
                            <input type="text" id="roll_number" name="roll_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="mt-3">
                        <a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a>
                    </div>
					 <div class="mt-3">
                        <a href="register.php" >Register ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
