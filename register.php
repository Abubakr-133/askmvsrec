<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roll_number = $_POST['roll_number'];
    
    $email = $roll_number . '@mvsrec.edu.in';

    $_SESSION['roll_number'] = $roll_number;
    $_SESSION['email'] = $email;

    header("Location: send_otp.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register / Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 shadow-lg border-0">
                    <h3 class="mb-3 text-primary">Welcome to ASK-MVSREC</h3>
                    <p class="text-muted">Register with your Roll Number or Login</p>
                    <form action="send_otp.php" method="post">
                        <div class="mb-3">
                            <label for="roll_number" class="form-label">Enter Roll Number(without hyphens)</label>
                            <input type="text" id="roll_number" name="roll_number" class="form-control" placeholder="Ex: 245122733133" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                    <div class="mt-3">
                        <a href="index.php" >Already have an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>





</body>
</html>
