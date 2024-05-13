<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // Use the correct path to the autoload.php file


function sendEmail($email, $subject, $body) {
    // Create a new PHPMailer instance
    GLOBAL $sitename;
    $mailer = new PHPMailer(true);
    

    try {
        // Server settings
        $mailer->isSMTP();
        $mailer->Host = 'smtp_server'; // Your SMTP server
        $mailer->SMTPAuth = true;
        $mailer->Username = 'smtp_email'; // Your SMTP username
        $mailer->Password = 'smtp_password'; // Your SMTP password
        $mailer->SMTPSecure = 'tls'; // Use 'ssl' or 'tls'
        $mailer->Port = 587; // Port for 'tls'

        // Sender info
        $mailer->setFrom('smtp_email', $sitename);
        $mailer->addAddress($email);
        
        // Additional recipient (email forwarding)
        $mailer->addAddress('your_email');

        // Email content
        $mailer->isHTML(true);
        $mailer->Subject = $subject;
        $mailer->Body = $body;

        // Send the email
        if ($mailer->send()) {
            return "sent";
        } else {
            return "not sent";
        }
    } catch (Exception $e) {
        // Handle errors
        return "Email could not be sent. Error: {$mailer->ErrorInfo}";
    }
}

include('config.php');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Personal Info
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $acct_currency = $_POST["acct_currency"];
    $acct_type = $_POST["acct_type"];
    $occupation = $_POST["occupation"];
    $country = $_POST["country"];
    $address = $_POST["address"];
    $suite = $_POST["suite"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipcode"];
    $accountNumber = "9911" . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

    // Create your login
    $acct_email = $_POST["acct_email"];
    $phoneNumber = $_POST["phoneNumber"];
    $username = $_POST["username"];
    $acct_pin = $_POST["acct_pin"];
    $acct_password = $_POST["acct_password"];
    $confirmPassword = $_POST["confirmPassword"];

    // File upload
    $profile_pic_tmp = $_FILES["profile_pic"]["tmp_name"];
    $profile_pic_name = $_FILES["profile_pic"]["name"];
    $profile_pic_extension = pathinfo($profile_pic_name, PATHINFO_EXTENSION);

    // Generate a unique filename
    $new_profile_pic_name = "profilepic_" . $username . "_" . rand(time(), 50000) . "." . $profile_pic_extension;
    $profile_pic_path = "uploads/" . $new_profile_pic_name;

    // Check if username or email already exists
    $checkSql = "SELECT * FROM user_registration WHERE username = ? OR acct_email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $acct_email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $last_login_ip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

    if ($checkResult->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'Username or email already exists.';
    } elseif (strlen($acct_password) < 6) {
        $response['status'] = 'error';
        $response['message'] = 'Password must be at least 6 characters long.';
    } else {
        if (move_uploaded_file($profile_pic_tmp, $profile_pic_path)) {
            // Insert data into the database
            $sql = "INSERT INTO user_registration 
                    SET firstname = '$firstname', 
                        lastname = '$lastname', 
                        acct_currency = '$acct_currency', 
                        acct_type = '$acct_type', 
                        occupation = '$occupation', 
                        country = '$country', 
                        address = '$address', 
                        suite = '$suite', 
                        city = '$city', 
                        state = '$state', 
                        zipcode = '$zipcode', 
                        acct_email = '$acct_email', 
                        phoneNumber = '$phoneNumber', 
                        username = '$username', 
                        acct_pin = '$acct_pin', 
                        accountNumber = '$accountNumber', 
                        last_login_ip = '$last_login_ip', 
                        acct_password = '$acct_password', 
                        confirmPassword = '$confirmPassword', 
                        profile_pic = '$profile_pic_path'";

            if ($conn->query($sql) === TRUE) {
                // Set session variables
                session_start();
                $_SESSION['username'] = $username;

                // Set a cookie with username
                $cookie_name = "user";
                $cookie_value = $username;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 seconds = 1 day

                // Email content with improved formatting
                $body = "
                    <p>Hello {$firstname},</p>
                    <p>Your account has been created successfully.</p>
                    <p>Your account number is: <strong>{$accountNumber}</strong></p>
                    <p>Thank you for choosing <?php echo $sitename?> !</p>
                ";

                $subject = "$sitename  - Account Created Successfully";
                sendEmail($acct_email, $subject, $body);

                $response['status'] = 'success';
                $response['message'] = 'Registration successful!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error: ' . $conn->error;
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'File upload failed!';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method or missing regSubmit parameter.';
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
