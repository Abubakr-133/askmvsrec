<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; //ensuring PHPMailer is properly loaded

session_start();


$roll_number = $_POST['roll_number'];
$email = $roll_number . "@mvsrec.edu.in"; // Generating email ID


$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;  // Storing OTP in session
$_SESSION['email'] = $email;  // Storing email in the session
$_SESSION['roll_number']=$roll_number;

date_default_timezone_set('Asia/Kolkata');

$current_time = date('Y-m-d H:i:s'); // time in Y-m-d H:i:s format

// Adding 8 minutes to the current time for OTP expiration
$expiry_at = date('Y-m-d H:i:s', strtotime($current_time . ' +8 minutes'));
$_SESSION['expiry_at'] = $expiry_at;  // Storing the expiry time in session

require 'db_connect.php';


// Checking if the row with the same roll_number exists
$sql = "SELECT * FROM otp_verification WHERE roll_number = '$roll_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If a record exists, update the OTP and expiry time
    $update_sql = "UPDATE otp_verification SET otp = '$otp', expires_at = '$expiry_at' WHERE roll_number = '$roll_number'";
    if ($conn->query($update_sql) === TRUE) {
        //echo "OTP updated successfully.";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
} else {
    // If there is no record exists, inserting a new row and adding OTP to it 
    $insert_sql = "INSERT INTO otp_verification (roll_number, otp, expires_at) VALUES ('$roll_number', '$otp', '$expiry_at')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "OTP stored successfully.";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close(); 

// Sending OTP email using PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'adkmvsrec@gmail.com'; // Gmail ID
    $mail->Password = 'vkkx qrmk ztst auie'; // Gmail app password (use App Passwords if 2FA is enabled)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender and recipient settings
    $mail->setFrom('adkmvsrec@gmail.com', 'ASK-MVSREC');
    $mail->addAddress($email);  // Add the user’s email address

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for Login/Register';
    $mail->Body    = "Your OTP is: <b>$otp</b>";  // OTP message in the body

    // Send the email
    $mail->send();
    //echo "OTP sent successfully to $email";  // Success message
} catch (Exception $e) {
    // If email sending fails
    echo "Error: OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 shadow-lg border-0">
                    <h3 class="mb-3 text-primary">OTP Verification</h3>
                    <p class="text-muted">Enter the OTP sent to your email</p>
                    <form action="verify_otp.php" method="post">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" id="otp" name="otp" class="form-control" placeholder="6-digit OTP" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Verify OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
