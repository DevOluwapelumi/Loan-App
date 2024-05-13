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
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    // Fetch loan information
    $sql = "SELECT * FROM loan WHERE loan_id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if there are any records
    if ($result->num_rows > 0) {
        $loanData = $result->fetch_assoc();
        
        // Check if the loan has already been Repaid
        if ($loanData['status'] == 2) { // Assuming '2' represents the Repaid status
            echo json_encode(array("status" => "error", "message" => "This loan has already been Repaid."));
            exit();
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Loan not found."));
        exit();
    }

    $amount = $loanData['amount'];
    $loanAmount = $loanData['amount'];
    $extraInterest = 0.16 * $loanAmount; // Calculate 16% extra interest

    // Add the extra interest to the loan amount
    $amount = $loanAmount + $extraInterest;
    $status = 2; // Assuming this is the status you want to set

    // Perform balance check
    if ($amount < 1) {
        echo json_encode(array("status" => "error", "message" => "Please check your loan amount"));
        exit();
    }

    // Fetch user's balance from the database
    $userBalance = $userData['balance'];

    // Check if the balance is sufficient for the loan amount
    if ($userBalance < $amount) {
        echo json_encode(array("status" => "error", "message" => "Insufficient balance for this loan amount"));
        exit();
    }

    // Deduct the loan amount from the user's balance
    $newBalance = $userBalance - $amount;

    // SQL query to update loan status
    $updateLoanSql = "UPDATE loan SET status=? WHERE loan_id=?";
    $updateLoanStmt = $conn->prepare($updateLoanSql);

    if ($updateLoanStmt === false) {
        echo json_encode(array("status" => "error", "message" => "Error in preparing the SQL query."));
        exit();
    }

    $updateLoanStmt->bind_param("ii", $status, $id);
    $updateLoanStmt->execute();
    $updateLoanStmt->close();

    // SQL query to update user's balance
    $updateBalanceSql = "UPDATE user_registration SET balance=? WHERE id=?";
    $updateBalanceStmt = $conn->prepare($updateBalanceSql);

    if ($updateBalanceStmt === false) {
        echo json_encode(array("status" => "error", "message" => "Error in preparing the SQL query."));
        exit();
    }

    $updateBalanceStmt->bind_param("di", $newBalance, $userData['id']);
    $updateBalanceStmt->execute();
    $updateBalanceStmt->close();

    // Insert notification
    $notificationValue = "Your Loan of " . $userData['acct_currency'] . $amount . " has been Repaid";
    $type = 1; // Assuming $type is a predefined value for loan notifications

    $notificationSql = "INSERT INTO notification (user_id, type, value) VALUES (?, ?, ?)";
    $notificationStmt = $conn->prepare($notificationSql);

    if ($notificationStmt === false) {
        echo json_encode(array("status" => "error", "message" => "Error in preparing the SQL query."));
        exit();
    }

    $notificationStmt->bind_param("iss", $userData['id'], $type, $notificationValue);
    $notificationStmt->execute();
    $notificationStmt->close();

    echo json_encode(array("status" => "success", "message" => "Your Loan has been Repaid."));
} else {
    echo json_encode(array("status" => "error", "message" => "No loan ID provided."));
}

// Close the database connection
$conn->close();
?>
