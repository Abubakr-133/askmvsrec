<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .password-box {
            max-width: 400px;
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="password-box"><?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            let pass1 = document.getElementById("password").value;
            let pass2 = document.getElementById("confirm_password").value;
            let error = document.getElementById("error");

            if (pass1.length < 6) {
                error.innerHTML = "Password must be at least 6 characters.";
                return false;
            }
            if (pass1 !== pass2) {
                error.innerHTML = "Passwords do not match!";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Set Your Password</h2>
        <form action="process_password.php" method="post" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <p id="error" class="text-danger"></p>
            <button type="submit" class="btn btn-primary w-100">Set Password</button>
        </form>
    </div>
    <script>
        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('confirm_password').value;
            let errorMsg = document.getElementById('error-msg');

            if (password.length < 6 || password !== confirmPassword) {
                errorMsg.style.display = 'block';
                event.preventDefault(); // Prevent form submission
            } else {
                errorMsg.style.display = 'none';
            }
        });
    </script>
</body>
</html>
