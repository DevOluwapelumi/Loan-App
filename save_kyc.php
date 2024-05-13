<?php
session_start();
include 'config.php';
header('Content-Type: application/json');

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
$user_id = $userData['id'];

// Retrieve form data
$fullName = $_POST['fullName'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$address = $_POST['address'];
$idType = $_POST['idType'];

// Check if all fields are filled
if (empty($fullName) || empty($dob) || empty($email) || empty($address) || empty($idType) || empty($_FILES['documentUpload'])) {
    $response = ['status' => 'error', 'message' => 'All fields are mandatory'];
    echo json_encode($response);
    exit();
}

// Process file upload
$documentUpload = $_FILES['documentUpload'];

// Check if a file is uploaded
if (!isset($documentUpload) || empty($documentUpload['name'])) {
    $response = ['status' => 'error', 'message' => 'Please upload the ID proof document'];
    echo json_encode($response);
    exit();
}

$uploadPath = 'kyc/'; // Folder to save documents

// Generate a unique filename for the uploaded document
$uniqueFilename = uniqid() . '_' . $documentUpload['name'];
$targetPath = $uploadPath . $uniqueFilename;

// Move the uploaded file to the specified folder
if (move_uploaded_file($documentUpload['tmp_name'], $targetPath)) {
    // Perform SQL insert to save KYC data
    $sql = "INSERT INTO kyc_registrations (email_address,full_name, date_of_birth, address, id_proof_type, id_proof_file) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $email, $fullName, $dob, $address, $idType, $targetPath);

    if ($stmt->execute()) {
        // KYC data saved successfully
        // Now update the users table to set kyc=1 for the user
        $updateSql = "UPDATE user_registration SET kyc=1 WHERE id=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $user_id);

        if ($updateStmt->execute()) {
            $response = ['status' => 'success', 'message' => 'KYC information saved successfully', 'user_id' => $user_id];
        } else {
            $response = ['status' => 'error', 'message' => 'Error updating user information'];
        }

        $updateStmt->close();
    } else {
        // Error saving KYC data
        $response = ['status' => 'error', 'message' => 'Error saving KYC information'];
    }

    $stmt->close();
    $conn->close();
} else {
    // Error uploading file
    $response = ['status' => 'error', 'message' => 'Error uploading document'];
}

echo json_encode($response);
?>
