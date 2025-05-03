<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; //ensures PHPMailer is properly loaded
session_start();
require 'db_connect.php';

$roll_number = $_POST['roll_number'];
$email = $roll_number . "@mvsrec.edu.in";

// Check if the roll number exists in the users table
//$conn = new mysqli('localhost', 'root', '', 'ASK-MVSREC');
$sql = "SELECT * FROM users WHERE roll_number = '$roll_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['roll_number'] = $roll_number;

    // Set expiration time (8 minutes)
    date_default_timezone_set('Asia/Kolkata');
    $expiry_at = date('Y-m-d H:i:s', strtotime('+8 minutes'));
    $_SESSION['expiry_at'] = $expiry_at;


// Checking  if the row with the same roll_number exists
$sql = "SELECT * FROM otp_verification WHERE roll_number = '$roll_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If a record exists, update the OTP and expiry time into the row 
    $update_sql = "UPDATE otp_verification SET otp = '$otp', expires_at = '$expiry_at' WHERE roll_number = '$roll_number'";
    if ($conn->query($update_sql) === FALSE) {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}
 else {
    // If no record exists, insert a new OTP
	echo "no record found,pls register ";
	?><html><body><script>alert("You don't have any account! Please Register");</script></body></html><?php
       // header("Location: register.php"); 
}

$conn->close(); // Close the database connection

    // Send OTP to user's email (PHPMailer)
    // Your PHPMailer code for sending OTP goes here...
	
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
    $mail->Subject = 'Your OTP for reseting password';
    $mail->Body    = "Your OTP is: <b>$otp</b>";  // OTP message in the body

    // Send the email
    $mail->send();
   // echo "OTP sent successfully to $email";  // Success message
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
                    <form action="verify_otp_reset.php" method="post">
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

	<?php
} catch (Exception $e) {
    // If email sending fails
    echo "Error: OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

    //echo "OTP sent to $email. Please check your email to reset your password.";
    // Redirect user to the page to enter OTP
   // header("Location: verify_otp_reset.php");
} else {
    echo "Roll Number not found!";
	?><html><body><script>alert("You don't have any account! Please Register");</script><a href="register.php">Go back to register page</a></body></html><?php
	      // time_nanosleep(5, 0); // Delay for 5 seconds and 0 nanoseconds
		   //header("Location: register.php"); 

}

?>