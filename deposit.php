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

// SQL query to fetch user information
$sql = "SELECT * FROM user_registration WHERE username='$username'";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    // Fetch and output user data
    while ($row = $result->fetch_assoc()) {
        $userData = array(
            "id" => $row['id'],
            "firstname" => $row['firstname'],
            "lastname" => $row['lastname'],
            "fullname" => $row['firstname'] . ' ' . $row['lastname'],
            "acct_currency" => $row['acct_currency'],
            "acct_type" => $row['acct_type'],
            "occupation" => $row['occupation'],
            "country" => $row['country'],
            "address" => $row['address'],
            "suite" => $row['suite'],
            "city" => $row['city'],
            "state" => $row['state'],
            "zipcode" => $row['zipcode'],
            "acct_email" => $row['acct_email'],
            "phoneNumber" => $row['phoneNumber'],
            "username" => $row['username'],
            "acct_pin" => $row['acct_pin'],
            "acct_password" => $row['acct_password'],
            "confirmPassword" => $row['confirmPassword'],
            "profile_pic" => $row['profile_pic'],
            "balance" => $row['balance'],
            "last_login_ip" => $row['last_login_ip'],
            "last_login_time" => $row['last_login_time'],
            "account_limit" => $row['account_limit'],
        );
    }
} else {
    echo json_encode(array("error" => "No records found"));
    exit();
}

// Check if required fields are provided
if (isset($_POST['amount'], $_POST['crypto_name'], $_POST['wallet_address'], $_FILES['image']) &&
    !empty($_POST['amount']) && !empty($_POST['crypto_name']) && !empty($_POST['wallet_address']) && !empty($_FILES['image'])) {

    // Get user ID from the session
    $userId = $userData['id'];

    // Get other form data
    $amount = $_POST['amount'];
    $cryptoName = $_POST['crypto_name'];
    $walletAddress = $_POST['wallet_address'];

    // Handle file upload
    $uploadDir = "uploads/"; // Specify the directory where you want to store uploaded files
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // File uploaded successfully, continue with database insertion
        $imagePath = $uploadFile;

        // SQL query to insert data into the database
        $sql = "INSERT INTO deposits (user_id, amount, crypto_name, wallet_address, image_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(array("error" => "Error in preparing the SQL query."));
            exit();
        }

        $stmt->bind_param("idsbs", $userId, $amount, $cryptoName, $walletAddress, $imagePath);

        if ($stmt->execute()) {
            echo json_encode(array("success" => "Deposit successful!"));
        } else {
            echo json_encode(array("error" => "Error: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "File upload failed!"));
    }
} else {
    echo json_encode(array("error" => "Please provide all required fields."));
}

// Close the database connection
$conn->close();
?>
