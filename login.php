<?php
include('config.php');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountNumber = $_POST["accountNumber"];
    $password = $_POST["password"];

    // Get the current IP address
    $currentIP = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

    // Check if the account number and password exist in the database
    $checkSql = "SELECT * FROM user_registration WHERE accountNumber = ? AND acct_password = ? ||  acct_email = ? AND acct_password = ? ";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ssss", $accountNumber, $password, $accountNumber, $password);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Valid login
        $userRow = $checkResult->fetch_assoc();

        // Update last login IP and time
        $updateSql = "UPDATE user_registration SET last_login_ip = ?, last_login_time = CURRENT_TIMESTAMP WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $currentIP, $userRow['id']);
        $updateStmt->execute();

        session_start();
        $_SESSION['username'] = $userRow['username'];

        // Set a cookie with username
        $cookie_name = "user";
        $cookie_value = $username;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 seconds = 1 day


        $response['status'] = 'success';
        $response['message'] = 'Login successful!';
    } else {
        // Invalid login
        $response['status'] = 'error';
        $response['message'] = 'Invalid email or password.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method or missing parameters.';
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
