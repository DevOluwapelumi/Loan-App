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
    $password = $userData['acct_password'];
} else {
    echo json_encode(array("error" => "No records found"));
    exit();
}

$stmt->close();

// Check if the form is submitted
if (isset($_POST['old_password'])) {

    // Validate and sanitize form inputs
    $old_password = isset($_POST['old_password']) ? htmlspecialchars($_POST['old_password']) : '';
    $new_password = isset($_POST['new_password']) ? htmlspecialchars($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : '';
    
    // Check if the current password is correct
    if ($password == $old_password) {
        
        // Check if the new password and confirm password match
        if ($new_password === $confirm_password) {

            // Update the password in the database
            $updateSql = "UPDATE user_registration SET acct_password = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $confirm_password, $userData['id']);
            $updateStmt->execute();
            $updateStmt->close();

            echo json_encode(array("success" => "password updated successfully!"));
        } else {
            echo json_encode(array("error" => "New password and Confirm password do not match"));
        }

    } else {
        echo json_encode(array("error" => "Current password is incorrect"));
    }
} else {
    echo json_encode(array("error" => "Error: Form not submitted"));
}

// Close the database connection
$conn->close();
?>
