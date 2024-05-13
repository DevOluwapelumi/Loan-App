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
if (isset($_POST['acct_remarks'])) {

    // Validate and sanitize form inputs
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $acctName = isset($_POST['acct_name']) ? htmlspecialchars($_POST['acct_name']) : '';
    $bankName = isset($_POST['bank_name']) ? htmlspecialchars($_POST['bank_name']) : '';
    $acctNumber = isset($_POST['acct_number']) ? intval($_POST['acct_number']) : 0;
    $acctCountry = isset($_POST['acct_country']) ? htmlspecialchars($_POST['acct_country']) : '';
    $acctSwift = isset($_POST['acct_swift']) ? htmlspecialchars($_POST['acct_swift']) : '';
    $acctRouting = isset($_POST['acct_routing']) ? intval($_POST['acct_routing']) : 0;
    $acctType = isset($_POST['acct_type']) ? htmlspecialchars($_POST['acct_type']) : '';
    $acctRemarks = isset($_POST['acct_remarks']) ? htmlspecialchars($_POST['acct_remarks']) : '';

    // Add any additional validation as needed

    // Perform balance check
    if ($amount > $userData['balance']) {
        echo json_encode(array("error" => "Insufficient balance for the wire transfer."));
        exit();
    }

    // SQL query to insert data into the database
    $sql = "INSERT INTO wire_transfer (user_id, amount, acct_name, bank_name, acct_number, acct_country, acct_swift, acct_routing, acct_type, acct_remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    $stmt->bind_param("idssisisss", $userData['id'], $amount, $acctName, $bankName, $acctNumber, $acctCountry, $acctSwift, $acctRouting, $acctType, $acctRemarks);

    if ($stmt->execute()) {
        // Deduct the transferred amount from the user's balance
        $newBalance = $userData['balance'] - $amount;
        $updateSql = "UPDATE user_registration SET balance = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("di", $newBalance, $userData['id']);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode(array("success" => "Wire transfer successful!"));
    } else {
        echo json_encode(array("error" => "Error: " . $stmt->error));
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
