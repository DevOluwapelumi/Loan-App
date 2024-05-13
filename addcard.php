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
if (isset($_POST['card_number'])) {

    // Validate and sanitize form inputs
    $card_number = isset($_POST['card_number']) ? htmlspecialchars($_POST['card_number']) : '';
    $card_expiration = isset($_POST['card_expiration']) ? htmlspecialchars($_POST['card_expiration']) : '';
    $security = isset($_POST['security']) ? htmlspecialchars($_POST['security']) : '';

    // Additional validation if needed

    // SQL query to insert data into the database
    $sql = "INSERT INTO creditcard (user_id, card_number, expiration_date,cvv) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    $stmt->bind_param("isss", $userData['id'], $card_number, $card_expiration, $security);

    if ($stmt->execute()) {
        $updateSql = "UPDATE user_registration SET card = 1 WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $userData['id']);
        $updateStmt->execute();
        $updateStmt->close();


        echo json_encode(array("success" => "Credit card request submitted successfully!"));
    } else {
        echo json_encode(array("error" => "Error: " . $stmt->error));
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
