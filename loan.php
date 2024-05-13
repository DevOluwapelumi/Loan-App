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
if (isset($_POST['loan_remarks'])) {

    // Validate and sanitize form inputs
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $loanRemarks = isset($_POST['loan_remarks']) ? htmlspecialchars($_POST['loan_remarks']) : '';
    $contact1 = isset($_POST['contact1']) ? htmlspecialchars($_POST['contact1']) : '';
    $relationship1 = isset($_POST['relationship1']) ? htmlspecialchars($_POST['relationship1']) : '';
    $contact2 = isset($_POST['contact2']) ? htmlspecialchars($_POST['contact2']) : '';
    $relationship2 = isset($_POST['relationship2']) ? htmlspecialchars($_POST['relationship2']) : '';
    $repaymentPattern = isset($_POST['repayment_pattern']) ? htmlspecialchars($_POST['repayment_pattern']) : '';

    // Add any additional validation as needed

    // Perform balance check
    if ($amount < 1) {
        echo json_encode(array("error" => "Please check your loan amount"));
        exit();
    }

    // SQL query to insert data into the loan table
    $loanSql = "INSERT INTO loan (user_id, amount, loan_remarks, contact1_phone, contact1_relationship, contact2_phone, contact2_relationship, repayment_pattern) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $loanStmt = $conn->prepare($loanSql);

    if ($loanStmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    $loanStmt->bind_param("idssssss", $userData['id'], $amount, $loanRemarks, $contact1, $relationship1, $contact2, $relationship2, $repaymentPattern);

    if ($loanStmt->execute()) {

        $notificationValue = "Your Loan of " . $userData['acct_currency'] . $amount ." is being processed";
        // SQL query to insert data into the notification table
        $notificationSql = "INSERT INTO notification (user_id, type, value) VALUES (?, ?, ?)";
        $notificationStmt = $conn->prepare($notificationSql);

        if ($notificationStmt === false) {
            echo json_encode(array("error" => "Error in preparing the SQL query."));
            exit();
        }

        // Assuming $type is a predefined value for loan notifications
        $type = 1;

        $notificationStmt->bind_param("iss", $userData['id'], $type, $notificationValue);
        $notificationStmt->execute();
        $notificationStmt->close();

        echo json_encode(array("success" => "Your Loan has been submitted. Kindly wait for Approval!"));
    } else {
        echo json_encode(array("error" => "Error: " . $loanStmt->error));
    }

    $loanStmt->close();
}

// Close the database connection
$conn->close();
?>
