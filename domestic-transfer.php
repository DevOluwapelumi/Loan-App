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

// SQL query to fetch user information using prepared statement
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
    // Fetch and output user data
    while ($row = $result->fetch_assoc()) {
        // Extract necessary user data
        $userData = array(
            "id" => $row['id'],
            "balance" => $row['balance'],
            // ... (other fields)
        );
    }
} else {
    echo json_encode(array("error" => "No records found"));
    exit();
}

$stmt->close();

// Check if required fields are provided
if (isset($_POST['amount'], $_POST['acct_name'], $_POST['bank_name'], $_POST['acct_number'], $_POST['acct_type'], $_POST['acct_remarks'])) {

    // Get other form data
    $amount = $_POST['amount'];
    $acctName = $_POST['acct_name'];
    $bankName = $_POST['bank_name'];
    $acctNumber = $_POST['acct_number'];
    $acctType = $_POST['acct_type'];
    $acctRemarks = $_POST['acct_remarks'];

    // Check if the amount is greater than the user's balance
    if ($amount > $userData['balance']) {
        echo json_encode(array("error" => "Insufficient balance for the domestic transfer."));
        exit();
    }

    // SQL query to insert data into the database using prepared statement
    $sql = "INSERT INTO domestic_transfer (user_id, amount, acct_name, bank_name, acct_number, acct_type, acct_remarks) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("error" => "Error in preparing the SQL query."));
        exit();
    }

    $stmt->bind_param("idssiss", $userData['id'], $amount, $acctName, $bankName, $acctNumber, $acctType, $acctRemarks);

    if ($stmt->execute()) {
        echo json_encode(array("success" => "Domestic transfer successful!"));
    } else {
        echo json_encode(array("error" => "Error: " . $stmt->error));
    }

    $stmt->close();

} else {
    echo json_encode(array("error" => "Please provide all required fields."));
}



// Close the database connection
$conn->close();
?>
