<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// SMTP configuration and PHPMailer initialization
$mail = new PHPMailer(true);  // Passing `true` enables exceptions

$mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;  // Enable SMTP authentication
$mail->Username = 'briangetenga3@gmail.com';  // SMTP username (your Gmail address)
$mail->Password = 'brian_Getenga^1';  // SMTP password (or App Password if using 2-step verification)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
$mail->Port = 587;  // TCP port to connect to

// Database connection settings
$dsn = 'mysql:host=localhost;dbname=shop_db';
$username = 'root'; // Default username for XAMPP
$password = ''; // Default password for XAMPP
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
);

// Handle subscription form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a confirmation token
        $token = bin2hex(random_bytes(16));

        try {
            $pdo = new PDO($dsn, $username, $password, $options);
            
            // Insert email and token into subscribers table
            $stmt = $pdo->prepare("INSERT INTO subscribers (email, confirmation_token) VALUES (:email, :token)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            // Send confirmation email using PHPMailer
            try {
                // Recipients
                $mail->setFrom('no-reply@yourwebsite.com', 'Mailer');
                $mail->addAddress($email);

                // Content
                $confirmation_link = "http://localhost/website/demo.php?token=$token";
                $mail->isHTML(true);
                $mail->Subject = 'Confirm your subscription';
                $mail->Body    = "Click the following link to confirm your subscription: <a href=\"$confirmation_link\">$confirmation_link</a>";

                $mail->send();
                echo 'A confirmation email has been sent to your email address. Please check your email to confirm your subscription.';
            } catch (Exception $e) {
                echo "Failed to send confirmation email. Mailer Error: {$mail->ErrorInfo}";
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "This email is already subscribed.";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Invalid email address.";
    }
}

// Handle email confirmation
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);

        // Confirm the subscription
        $stmt = $pdo->prepare("UPDATE subscribers SET confirmed = 1 WHERE confirmation_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Subscription confirmed!";
        } else {
            echo "Invalid confirmation token.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to Newsletter</title>
</head>
<body>
    <form action="demo.php" method="post">
        <label for="email">Subscribe to our newsletter:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Subscribe</button>
    </form>
</body>
</html>
