<?php
session_start();
include 'config.php';

// Check if the session is set
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header("Location: ?p=login");
    exit();
}

$username = $_SESSION['username'];

// Fetch user information
$sql = "SELECT * FROM user_registration WHERE username=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(array("error" => "Error in preparing the SQL query."));
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

// Check if there are any records
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo json_encode(array("error" => "No records found"));
    exit();
}

$stmt->close();

// Check if the form is submitted
if (isset($_POST['withdraw_method'])) {

    // Validate and sanitize form inputs
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $withdraw_method = isset($_POST['withdraw_method']) ? htmlspecialchars($_POST['withdraw_method']) : '';
    $wallet_address = isset($_POST['wallet_address']) ? htmlspecialchars($_POST['wallet_address']) : '';

    // Add any additional validation as needed

    // Perform balance check
    if ($amount < 1) {
        echo json_encode(array("error" => "Please check your Withdrawal amount"));
        exit();
    }
    if($amount > $userData['balance']){
        echo json_encode(array("error" => "Insufficient Balance."));
        exit();
    }

    // SQL query to insert data into the database
    $sql = "INSERT INTO withdrawal (user_id, amount, withdraw_method,wallet_address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    $stmt->bind_param("idss", $userData['id'], $amount, $withdraw_method,$wallet_address);

    if ($stmt->execute()) {
        // Deduct the transferred amount from the user's balance
        $newBalance = $userData['balance'] - $amount;
        $updateSql = "UPDATE user_registration SET balance = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("di", $newBalance, $userData['id']);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode(array("success" => "Your Withdrawal request have been submitted, Kindly wait for Approval!"));
    } else {
        echo json_encode(array("error" => "Error: " . $stmt->error));
    }

    $stmt->close();
}

if(isset($_POST['fullname'])) {
    // Include your database connection code here

    // Retrieve form data
    $amount = $_POST['amount'];
    $fullname = $_POST['fullname'];
    $bankAddress = $_POST['bankAddress'];
    $postcode = $_POST['postcode'];
    $state = $_POST['state'];
    $routingNumber = $_POST['routingNumber'];
    $accountNumber = $_POST['accountNumber'];
    $bankName = $_POST['bankName'];
    $sortcode = $_POST['sortcode'];
    $pattern = 2; // Assuming $pattern is a predefined value

    // Perform balance check
    if ($amount < 1) {
        echo json_encode(array("error" => "Please check your withdrawal amount"));
        exit();
    }
    if($amount > $userData['balance']){
        echo json_encode(array("error" => "Insufficient Balance."));
        exit();
    }
    if (empty($amount) || empty($fullname) || empty($bankAddress)|| empty($state) || empty($routingNumber) || empty($accountNumber) || empty($bankName)) {
        echo json_encode(array("error" => "All fields are required."));
        exit();
    }
    // SQL query to insert withdrawal request into the database
    $sql = "INSERT INTO withdrawal (user_id, amount, full_name, bank_address, postcode, state, routing_number, account_number, bank_name, pattern,sortcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("idsssssssss", $userData['id'], $amount, $fullname, $bankAddress, $postcode, $state, $routingNumber, $accountNumber, $bankName, $pattern,$sortcode);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Deduct the transferred amount from the user's balance
        $newBalance = $userData['balance'] - $amount;
        $updateSql = "UPDATE user_registration SET balance = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("di", $newBalance, $userData['id']);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode(array("success" => "Your withdrawal request has been submitted. Please wait for approval."));
    } else {
        echo json_encode(array("error" => "Error: Unable to submit withdrawal request."));
    }

    // Close prepared statement and database connection
    $stmt->close();
    // $conn->close();
}

// Close the database connection
$conn->close();
?>
