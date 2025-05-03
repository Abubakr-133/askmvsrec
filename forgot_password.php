<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 shadow">
                    <h3 class="mb-3">Forgot Password</h3>
                    <form action="send_otp_for_reset.php" method="post">
                        <div class="mb-3">
                            <label for="roll_number" class="form-label">Enter Roll Number</label>
                            <input type="text" id="roll_number" name="roll_number" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
