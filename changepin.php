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
    $pin = $userData['acct_pin'];
} else {
    echo json_encode(array("error" => "No records found"));
    exit();
}

$stmt->close();

// Check if the form is submitted
if (isset($_POST['current_pin'])) {

    // Validate and sanitize form inputs
    $current_pin = isset($_POST['current_pin']) ? htmlspecialchars($_POST['current_pin']) : '';
    $new_pin = isset($_POST['new_pin']) ? htmlspecialchars($_POST['new_pin']) : '';
    $confirm_pin = isset($_POST['confirm_pin']) ? htmlspecialchars($_POST['confirm_pin']) : '';
    
    // Check if the current PIN is correct
    if ($pin == $current_pin) {
        
        // Check if the new PIN and confirm PIN match
        if ($new_pin === $confirm_pin) {

            // Update the PIN in the database
            $updateSql = "UPDATE user_registration SET acct_pin = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $confirm_pin, $userData['id']);
            $updateStmt->execute();
            $updateStmt->close();

            echo json_encode(array("success" => "PIN updated successfully!"));
        } else {
            echo json_encode(array("error" => "New PIN and Confirm PIN do not match"));
        }

    } else {
        echo json_encode(array("error" => "Current PIN is incorrect"));
    }
} else {
    echo json_encode(array("error" => "Error: Form not submitted"));
}

// Close the database connection
$conn->close();
?>
