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
// SQL query to fetch all records from a table (replace 'your_table_name' with your actual table name)
$sql = "SELECT * FROM user_registration WHERE username='$username'";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    // Fetch and output data
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $fullname = $firstname . ' ' . $lastname;
        $acct_currency = $row['acct_currency'];
        $acct_type = $row['acct_type'];
        $occupation = $row['occupation'];
        $kyc = $row['kyc'];
        $country = $row['country'];
        $address = $row['address'];
        $suite = $row['suite'];
        $city = $row['city'];
        $card = $row['card'];
        $state = $row['state'];
        $zipcode = $row['zipcode'];
        $acct_email = $row['acct_email'];
        $phoneNumber = $row['phoneNumber'];
        $username = $row['username'];
        $acct_pin = $row['acct_pin'];
        $acct_password = $row['acct_password'];
        $confirmPassword = $row['confirmPassword'];
        $profile_pic = $row['profile_pic'];
        $balance = $row['balance'];
        $last_login_ip = $row['last_login_ip'];
        $last_login_time = $row['last_login_time'];
        $account_limit = $row['account_limit'];


    }
} else {
    echo "No records found";
}

?>
<?php
// Function to generate a random card number
function generateRandomCardNumber()
{
    // You can customize the logic to generate a random card number based on your requirements
    $cardNumber = rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999);
    return $cardNumber;
}

// Function to generate a random expiration date
function generateRandomExpirationDate()
{
    $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
    $year = date("y") + rand(1, 5); // Generate an expiration year between the current year and the next 5 years
    return $month . '/' . $year;
}

// Function to generate a random security code
function generateRandomSecurityCode()
{
    // You can customize the logic to generate a random security code based on your requirements
    return rand(100, 999);
}


$card_name = $fullname;
$card_number = generateRandomCardNumber();
$card_expiration = generateRandomExpirationDate();
$security_code = generateRandomSecurityCode();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type; encoding" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Virtual Card - <?php echo $sitename?>  </title>
    <link rel="icon" type="image/x-icon" href="assets/images/logo/favicon.png" />
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
        <script src="./assets/js/loader.js"></script>
    <!--     BEGIN GLOBAL MANDATORY STYLES-->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Rock+Salt|Source+Code+Pro:300,400,600" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/forms/custom-clipboard.css">
    <!--     END GLOBAL MANDATORY STYLES-->

    <link rel="stylesheet" href="./plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="./plugins/font-icons/fontawesome/css/fontawesome.css">

    <!--     BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES-->
    <link href="./plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="./assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/components/cards/card.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap-select/bootstrap-select.min.css">
    <!--    profile css-->
    <link rel="stylesheet" type="text/css" href="plugins/dropify/dropify.min.css">
    <link href="./assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="./assets/css/card/card.css">
    <link rel="stylesheet" href="./assets/css/card/displayCard.css">
    <!--    <link href="./assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />-->

    <!--    end of table css-->


    <!-- toaster -->
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
    <link href="./plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="./plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <script src="./plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="./assets/js/libs/jquery-3.1.1.min.js"></script>




    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <style>
    @media screen and (max-width: 600px) {
        .layout-visible {
            visibility: hidden;
            clear: both;
            float: left;
            margin: 10px auto 5px 20px;
            width: 28%;
            display: none;
        }
    }
    .header-logo-box{
        background-image:url('assets/images/logo/logo.png');
        background-size:contain;
        background-repeat:no-repeat;
        height:3em;
        align-self: center;
        margin-left:1em;
    }
    .margin-right-2{
        margin-right:1em;
    }
    @media (max-width:991px){
        .header-container .navbar-nav.theme-brand {
            width: 164px;
        }
    }
    </style>
    <link rel="stylesheet" href="assets/css/extras-added.css">

</head>

<body class="sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-nav theme-brand flex-row  text-center">
                <div id="logoBtn" class="w-100 d-flex align-items-center justify-content-center bg-white rounded-3">
                                                     <img src="logo.png" style="width: 8rem;" alt="">


                </div>
                <li  class="nav-item toggle-sidebar margin-right-2">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-list">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3" y2="6"></line>
                            <line x1="3" y1="12" x2="3" y2="12"></line>
                            <line x1="3" y1="18" x2="3" y2="18"></line>
                        </svg></a>
                </li>
            </ul>


            <ul class="navbar-item flex-row search-ul">
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">


                

                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg><span class="badge badge-success"></span>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                 <?php include 'notification.php'; ?>
                                            </div>
                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-settings">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
<!--                                <img src="./assets/profile/--><!--" class="img-fluid mr-2" alt="avatar">-->
                                <div class="media-body">
                                    <h5><?php echo $fullname ?></h5>
                                    <p><?php echo $acct_type ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="?p=profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>My Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="?p=loan-transaction">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-inbox">
                                    <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                    <path
                                        d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                    </path>
                                </svg> <span>My Inbox</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="?p=logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">
                <div class="profile-info">
                    <figure class="user-cover-image"></figure>
                    <div class="user-info" aria-expanded="true">
<!--                        <img src="./assets/profile/--><!--" alt="avatar">-->
                        <h5><?php echo $fullname ?></h5>
                        <p class=""><?php echo $acct_type ?></p>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu ">
                        <a href="?p=dashboard" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Dashboard</span>
                            </div>


                        </a>
                    </li>

                    <li class="menu ">
                        <a href="?p=deposit" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Make a Deposit</span>
                            </div>


                        </a>
                    </li>

                    <li class="menu  ">
                        <a href="?p=loan" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>Loan</span>
                            </div>


                        </a>
                    </li>

                    <li class="menu ">
                      <a href="?p=withdrawal" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Withdrawal</span>
                            </div>


                        </a>
                    </li>
                                        <li class="menu active">
                        <a href="?p=card" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-credit-card">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <span>Virtual Card</span>
                            </div>


                        </a>
                    </li>
                    
                     



                    <li class="menu">
                        <a href="#starkit" data-toggle="collapse" aria-expanded="" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-credit-card">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <span>All Transaction Logs</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="starkit" data-parent="#accordionExample">
                            
                            <li>
                                <a href="?p=loan-transaction"> Loan Transaction </a>
                            </li>
                            <li>
                                <a href="?p=withdrawal-transaction"> All Withdrawal</a>
                            </li>
                            
                        </ul>
                    </li>



                     <li class="menu ">
                        <a href="?p=account-manager" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Account Manager</span>
                            </div>


                        </a>
                    </li>

                    <li class="menu">
                        <a href="#starter-kit" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-settings">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                    </path>
                                </svg>
                                <span>Settings</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="starter-kit" data-parent="#accordionExample">
                            <li>
                                <a href="?p=profile"> Profile </a>
                            </li>
                            <li>
                                <a href="?p=edit-profile"> Account </a>
                            </li>
                        </ul>
                    </li>

                </ul>

            </nav>

        </div>
        <!--  END SIDEBAR  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            
            <div class="payment-title bodyTag">

                <h1>Generate Credit Card</h1>
            </div>

            <?php
            if (($card == 1)) {
                $sql = "SELECT * FROM creditcard WHERE user_id='$id' LIMIT 1";
                $result = $conn->query($sql);

                // Check if there are any records
                if ($result->num_rows > 0) {
                    // Fetch and output data
                    while ($row = $result->fetch_assoc()) {
                        $card_number = $row['card_number'];
                        $expiration_date = $row['expiration_date'];
                        $cvv = $row['cvv'];
                         

                    }
                } else {
                    echo "No records found";
                }
                ?>
                                 <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 offset-md-3 layout-spacing">

                        <div class="widget widget-account-invoice-three">

                            <div class="card-wrapper-box">
                                <div class="card-wrapper">
                                    <ul class="card-wrapper__row-list">
                                        <li class="card-wrapper__row">
                                            <div class="card-wrapper__row-div">
                                                <div class="card-wrapper__reward">
                                                    <h4><?php echo $sitename?> </h4>
                                                    <h1>Debit Card</h1>
                                                </div>
                                            </div>
                                            <div class="card-wrapper__row-div">
                                                <!--<div class="card-wrapper__logo">-->
                                                <!-- <span><img src="../assets/settings/Azure.PNG" alt="" width="15%"></span>-->
                                                <!--    <h2 class="brand-name">Azure Credit Union</h2>-->
                                                <!--</div>-->
                                                <span class="brand-title">We understand your world</span>
                                            </div>
                                        </li>
                                        <li class="card-wrapper__row row-2">
                                            <ul class="list-unstyled card-wrapper__item-list">
                                                <li>
                                                    <div class="card-petrol__wrapper">
                                                        <div class="card-petrol__wrapper-box"></div>
                                                        <div class="card-petrol__wire"></div>
                                                    </div>
                                                    <div class="card-chip__wrapper">
                                                        <div class="card-chip__wrapper-box">
                                                            <div class="card-chip_wrapper-box-line-1"></div>
                                                            <div class="card-chip_wrapper-box-line-2"></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card-cart__wrapper">

                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card-sb__wrapper">

                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card-train__wrapper">

                                                </div></li>
                                                <li>

                                                </li>
                                            </ul>
                                        </li>
                                        <li class="card-wrapper__row row-3">
                                            <div class="card-wrapper__card-number">
                                                <p class="card-num text-white"><span><?php echo $card_number; ?></span></p>
                                                <span class="card-month text-white">month/year</span>
                                                <p class="card-date text-white"><span class="valid-up-to text-white">valid up to</span> <span class="text-white"><?php echo $expiration_date ?></span></p>
                                            </div>
                                            <ul class="list-unstyled card-wrapper__item-list">
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                            </ul>
                                        </li>
                                        <li class="card-wrapper__row row-4">
                                            <div class="card-wrapper__visa">
                                                <span class="visa-electronic">electronic use only</span>
                                                <span class="visa-no text-uppercase"><?php echo $fullname ?></span>
                                                <div class="visa-platinum text-white">
                                                    <h4 class="text-white">MAESTRO</h4>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="widget-content">

                                <div class="bills-stats; text-center">
                                    <button class="btn btn-primary btn-sm ">PROCESSING</button>                            </div>

                                <div class="invoice-list">

                                    <div class="inv-detail">
                                        <div class="info-detail-1">
                                            <p>Card Limit</p>
                                            <p><span class="w-currency">€</span> <span class="bill-amount">5000</span></p>
                                        </div>
                                        <div class="info-detail-2">
                                            <p>Card Limit Remain</p>
                                            <p class=""><span class="w-currency text-danger">€</span> <span class="bill-amount text-danger">5000 </span></p>
                                        </div>
                                    </div>

                                    <div class="inv-action">
                                        <form method="POST">
                                           <div class="row">
                                                                                          <div class="col-md-12 mb-3">
                                                   <span class="badge outline-badge-secondary shadow-none col-md-12">New Card On Progress</span>
                                               </div>
                                                                                      
                                                                                                                                 </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Card Request</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Card Type</label>
                                                    <div class="input-group">
                                                        <div class="btn-group bootstrap-select input-group-btn" style="width: 100%;"><button type="button" class="dropdown-toggle btn mb-2" data-toggle="dropdown" role="button" title="Select"><span class="filter-option float-left">Select</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu select-dropdown open" role="combobox"><div class="dropdown-menu inner" role="listbox" aria-expanded="false"><a tabindex="0" class="dropdown-item selected" data-original-index="0"><span class="dropdown-item-inner " data-tokens="null" role="option" tabindex="0" aria-disabled="false" aria-selected="true"><span class="text">Select</span><span class="  check-mark"></span></span></a><a tabindex="0" class="dropdown-item" data-original-index="1"><span class="dropdown-item-inner " data-tokens="null" role="option" tabindex="0" aria-disabled="false" aria-selected="false"><span class="text">Master CARD</span><span class="  check-mark"></span></span></a><a tabindex="0" class="dropdown-item" data-original-index="2"><span class="dropdown-item-inner " data-tokens="null" role="option" tabindex="0" aria-disabled="false" aria-selected="false"><span class="text">VISA</span><span class="  check-mark"></span></span></a><a tabindex="0" class="dropdown-item" data-original-index="3"><span class="dropdown-item-inner " data-tokens="null" role="option" tabindex="0" aria-disabled="false" aria-selected="false"><span class="text">AMERICAN EXPRESS</span><span class="  check-mark"></span></span></a><a tabindex="0" class="dropdown-item" data-original-index="4"><span class="dropdown-item-inner " data-tokens="null" role="option" tabindex="0" aria-disabled="false" aria-selected="false"><span class="text">Discover</span><span class="  check-mark"></span></span></a></div></div><select name="card_type" class="selectpicker" data-width="100%" tabindex="-98">
                                                            <option>Select</option>
                                                            <option value="mastercard">Master CARD</option>
                                                            <option value="visa">VISA</option>
                                                            <option value="american express">AMERICAN EXPRESS</option>
                                                            <option value="discover">Discover</option>
                                                        </select></div>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Request Reason</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Request Reason" name="card_reason"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-4 mt-4 text-center">
                                                    <button class="btn btn-primary" name="card_request">Submit Request</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                </div>




 
                                <?php
            } else { ?>
                <div class="container preload">
                    <div class="creditcard">
                        <div class="front">
                            <div id="ccsingle"></div>
                            <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                        <g id="Front">
                            <g id="CardBackground">
                                <g id="Page-1_1_">
                                    <g id="amex_1_">
                                        <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                            C0,17.9,17.9,0,40,0z" />
                                    </g>
                                </g>
                                <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                            </g>
                            <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4"><?php echo $card_number ?></text>
                            <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6"><?php echo $fullname ?></text>
                            <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
                            <text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
                            <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
                            <g>
                                <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9"><?php echo $card_expiration ?></text>
                                <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
                                <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
                                <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
                            </g>
                            <g id="cchip">
                                <g>
                                    <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                        c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                </g>
                                <g>
                                    <g>
                                        <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                    </g>
                                    <g>
                                        <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                    </g>
                                    <g>
                                        <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                            c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                            C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                            c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                            c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                    </g>
                                    <g>
                                        <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                    </g>
                                    <g>
                                        <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                    </g>
                                    <g>
                                        <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                    </g>
                                    <g>
                                        <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                    </g>
                                </g>
                            </g>
                        </g>
                                <g id="Back">
                                </g>
                    </svg>
                        </div>
                        <div class="back">
                            <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                        <g id="Front">
                            <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
                        </g>
                                <g id="Back">
                                    <g id="Page-1_2_">
                                        <g id="amex_2_">
                                            <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                        C0,17.9,17.9,0,40,0z" />
                                        </g>
                                    </g>
                                    <rect y="61.6" class="st2" width="750" height="78" />
                                    <g>
                                        <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                    C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                        <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
                                        <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
                                        <path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                    </g>
                                    <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7"><?php echo $security_code ?></text>
                                    <g class="st8">
                                        <text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">security code</text>
                                    </g>
                                    <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
                                    <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
                                    <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13"><?php echo $fullname ?></text>
                                </g>
                    </svg>
                        </div>
                    </div>
                </div>
           
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-container">
                                <div class="field-container">
                                    <label for="name">Name</label>
                                    <input id="name" maxlength="20" value="<?php echo $fullname ?>" name="card_name" type="text" readonly>
                                </div>
                                <div class="field-container">
                                    <label for="cardnumber">Card Number</label><span id="generatecard" class="btn btn-primary">Generate Card</span>
                                    <input id="cardnumber" type="text" inputmode="numeric" value="<?php echo $card_number ?>" name="card_number" readonly required>
                                    <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink">

                                    </svg>
                                </div>
                                <div class="field-container">
                                    <label for="expirationdate">Expiration (mm/yy)</label>
                                    <input id="expirationdate" type="text"  inputmode="numeric" name="card_expiration" value="<?php echo $card_expiration ?>" readonly required>
                                </div>
                                <div class="field-container">
                                    <label for="securitycode">Security Code</label>
                                    <input id="securitycode" type="text"  inputmode="numeric" name="security" value="<?php echo $security_code ?>" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" name="card_generate">Create card</button>
                        </div>
                    </div>
                </form>

            <?php } ?>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Card Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Card Type</label>
                                                <div class="input-group">
                                                    <select name="card_type" class='selectpicker'  data-width='100%'>
                                                        <option>Select</option>
                                                        <option value="mastercard">Master CARD</option>
                                                        <option value="visa">VISA</option>
                                                        <option value="american express">AMERICAN EXPRESS</option>
                                                        <option value="discover">Discover</option>
                                                    </select>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Request Reason</label>
                                                <div class="input-group">
                                                    <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Request Reason" name="card_reason" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-4 mt-4 text-center">
                                                <button class="btn btn-primary" name="card_request">Submit Request</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        </div>
                    </div>
                </div>
            </div>





</div>

</div>
<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © 2022 <?php echo $sitename?> , All rights reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class=""><?php echo $sitename?>  </p>
    </div>
    
    
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</div>
</div>
<!--  END CONTENT AREA  -->


</div>
</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<!--<script src="./assets/js/libs/jquery-3.1.1.min.js"></script>-->
<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script src="./plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="./plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="./plugins/file-upload/file-upload-with-preview.min.js"></script>
<script src="./assets/js/app.js"></script>
<script src="./assets/js/users/account-settings.js"></script>
<script src="./plugins/dropify/dropify.min.js"></script>
<script src="./plugins/blockui/jquery.blockUI.min.js"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="./assets/js/custom.js"></script>
<script>
    var data = null;
    console.log(data);
    function crypto_type(id){
        for(var i =0; i < data.length; i++){
            if(id == data[i].id){
                $("#wallet_address").val(data[i].wallet_address);
            }
        }
    }
    var firstUpload = new FileUploadWithPreview('myFirstImage')
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="./plugins/table/datatable/datatables.js"></script>
<script>
    $('#default-ordering').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        //"order": [[ 3, "desc" ]],
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered'); }
    } );
</script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
    }
</script>

<script>
    // Get the Toast button
    var toastButton = document.getElementById("toast-btn");
    // Get the Toast element
    var toastElement = document.getElementsByClassName("toast")[0];

    toastButton.onclick = function() {
        $('.toast').toast('show');
    }


</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="./plugins/apex/apexcharts.min.js"></script>
<script src="./assets/js/custom.js"></script>
<script src="./assets/js/dashboard/dash_1.js"></script>
<script src="./plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="./plugins/sweetalerts/custom-sweetalert.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->



<script src="./plugins/notification/snackbar/snackbar.min.js"></script>
<script src="./assets/js/clipboard/clipboard.min.js"></script>
<script src="./assets/js/forms/custom-clipboard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>
<script src="./assets/js/card/card.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="./assets/js/components/notification/custom-snackbar.js"></script>

</body>
</html>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
  $(document).ready(function() {
    // Intercept the form submission
    $("form").submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Get form data
      var formData = new FormData($(this)[0]);

      // Perform Ajax request
      $.ajax({
        url: "addcard.php", // Replace with the actual path to your PHP script
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Handle the success response
          try {
            var responseData = JSON.parse(response);
            if (responseData.success) {
              // Show success message using SweetAlert
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: responseData.success
              }).then(function() {
                // Redirect to dashboard after clicking "OK"
                window.location.href = "?p=card";
              });
            } else if (responseData.error) {
              // Show error message using SweetAlert
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: responseData.error
              });
            } else {
              // Handle other response cases
              console.log(responseData);
            }
          } catch (error) {
            console.error(response)
            console.error("Error parsing JSON response:", error);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Handle the error using SweetAlert
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Ajax request failed: " + textStatus + "\n" + errorThrown
          });
        }
      });
    });
  });
</script>
