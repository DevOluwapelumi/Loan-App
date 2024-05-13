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
        $fullname = $firstname .' '.$lastname;
        $acct_currency = $row['acct_currency'];
        $acct_type = $row['acct_type'];
        $occupation = $row['occupation'];
        $kyc = $row['kyc'];
        $country = $row['country'];
        $address = $row['address'];
        $suite = $row['suite'];
        $city = $row['city'];
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


// Fetch the most recent transaction
$recentTransactionSql = "SELECT * FROM Transfers WHERE UserID = $id ORDER BY DateTransferred DESC, TimeTransferred DESC LIMIT 1";
$recentTransactionResult = $conn->query($recentTransactionSql);

if ($recentTransactionResult->num_rows > 0) {
    $recentTransaction = $recentTransactionResult->fetch_assoc();
 
    $lastTransaction = number_format($recentTransaction["Amount"],2);

} else {
    $lastTransaction = number_format(0,2);
}

// Calculate the total transactions
$totalTransactionSql = "SELECT SUM(Amount) AS TotalAmount FROM Transfers WHERE UserID = $id";
$totalTransactionResult = $conn->query($totalTransactionSql);

if ($totalTransactionResult->num_rows > 0) {
    $totalTransaction = $totalTransactionResult->fetch_assoc();

    // Display the total transaction amount
     $totalAmount =  number_format($totalTransaction["TotalAmount"],2);

} else {
     $totalAmount =  number_format(0,2);
}


// Fetch data for the past 7 days
$sql = "SELECT DAYOFWEEK(DateTransferred) AS DayOfWeek, COUNT(*) AS RecordsCount
        FROM Transfers 
        WHERE UserID = $id AND DateTransferred >= CURDATE() - INTERVAL 6 DAY 
        GROUP BY DAYOFWEEK(DateTransferred)";

$result = $conn->query($sql);

// Initialize an array to store the counts for each day of the week
$dayOfWeekCounts = array_fill(1, 7, 0);

// Store data in the array
while ($row = $result->fetch_assoc()) {
    $dayOfWeekCounts[$row['DayOfWeek']] = $row['RecordsCount'];
}




?><!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type; encoding" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Domestic Transaction - <?php echo $sitename?>  </title>
    <link rel="icon" type="image/x-icon" href="assets/images/logo/favicon.png" />
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/loader.js"></script>
    <!--     BEGIN GLOBAL MANDATORY STYLES-->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Rock+Salt|Source+Code+Pro:300,400,600" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/forms/custom-clipboard.css">
    <!--     END GLOBAL MANDATORY STYLES-->

    <link rel="stylesheet" href="plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="plugins/font-icons/fontawesome/css/fontawesome.css">

    <!--     BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES-->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components/cards/card.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap-select/bootstrap-select.min.css">
    <!--    profile css-->
    <link rel="stylesheet" type="text/css" href="plugins/dropify/dropify.min.css">
    <link href="assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/card/card.css">
    <link rel="stylesheet" href="assets/css/card/displayCard.css">
    <!--    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />-->

    <!--    end of table css-->


    <!-- toaster -->
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>




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
                 <?php include 'notification.php';?>
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
<!--                                <img src="assets/profile/--><!--" class="img-fluid mr-2" alt="avatar">-->
                                <div class="media-body">
                                    <h5><?php echo $fullname?></h5>
                                    <p><?php echo $acct_type?></p>
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
<!--                        <img src="assets/profile/--><!--" alt="avatar">-->
                        <h5><?php echo $fullname?></h5>
                        <p class=""><?php echo $acct_type?></p>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu ">
                        <a href="?p=dashboard"aria-expanded="false" class="dropdown-toggle">
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
                        <a href="?p=deposit"aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
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
                                    stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>Withdrawal</span>
                            </div>


                        </a>
                    </li>
                                        <li class="menu ">
                        <a href="?p=card"aria-expanded="false" class="dropdown-toggle">
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
                    
                    <li class="menu ">
                        <a href="?p=loan"aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>Loan & Mortgages</span>
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
                        <a href="?p=withdrawal"aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>Withdrawal</span>
                            </div>


                        </a>
                    </li>

                    <li class="menu ">
                        <a href="?p=account-manager"aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
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
        <!--  END SIDEBAR  -->    <div id="content" class="main-content">
    <div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <table id="default-ordering" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Account Name</th>
                 
                </tr>
                </thead>
            <?php
  
// SQL query to fetch domestic transfer records for the user
$sql = "SELECT * FROM domestic_transfer WHERE user_id = (SELECT id FROM user_registration WHERE username = ?) ORDER BY id DESC";
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
    $serialNumber = 1;

    // Fetch and output transfer records
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $serialNumber++ . "</td>";
        echo "<td>" . $acct_currency.$row['amount'] . "</td>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['bank_name'] . "</td>";
        echo "<td>" . $row['acct_name'] . "</td>";
        echo "<td>" . $row['acct_number'] . "</td>";
        echo "<td>" . $row['acct_type'] . "</td>";
        echo "<td>" . $row['acct_remarks'] . "</td>";
        // Add other columns as needed
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='11'>No records found</td></tr>";
}

$stmt->close();
$conn->close();
?>

                <tfoot>
                <tr>
                    <th>S/N</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Account Name</th>
                 
                </tr>
                </tfoot>
            </table>
            
            <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()"
                                            class="btn btn-success waves-effect waves-light me-1"><i
                                                class="fa fa-print"></i> Print Statement</a>
                                    </div>
                                </div>
                                
                                
        </div>
    </div>


</div>

</div>
<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © 2024 <?php echo $sitename?> , All rights reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class=""><?php echo $sitename?>  </p>
    </div>
</div>
</div>
<!--  END CONTENT AREA  -->
<!--Start Home Transfer Modal-->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <div class="col-lg-6">
                <div class="btn bg-info"  onclick="location.href='user/domestic-transfer.php'">
                    Domestic Transfer
                </div>
            </div>
            <div class="col-lg-6">
                <div class="btn bg-success text-light"  onclick="location.href='?p=wire-transfer'">
                    Wire Transfer
                </div>
            </div>
        </div>

    </div>

</div>
</div>
</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<!--<script src="assets/js/libs/jquery-3.1.1.min.js"></script>-->
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="plugins/file-upload/file-upload-with-preview.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/users/account-settings.js"></script>
<script src="plugins/dropify/dropify.min.js"></script>
<script src="plugins/blockui/jquery.blockUI.min.js"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="assets/js/custom.js"></script>
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
<script src="plugins/table/datatable/datatables.js"></script>
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


<script>
    // Get the Toast button
    var toastButton = document.getElementById("toast-btn");
    // Get the Toast element
    var toastElement = document.getElementsByClassName("toast")[0];

    toastButton.onclick = function() {
        $('.toast').toast('show');
    }


</script>

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

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="plugins/apex/apexcharts.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/dashboard/dash_1.js"></script>
<script src="plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="plugins/sweetalerts/custom-sweetalert.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="plugins/notification/snackbar/snackbar.min.js"></script>
<script src="assets/js/clipboard/clipboard.min.js"></script>
<script src="assets/js/forms/custom-clipboard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>
<script src="assets/js/card/card.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="assets/js/components/notification/custom-snackbar.js"></script>

<script>
    var preloadimages=new Array("","")

    var intervals=600
    //configure destination URL
    var targetdestination="https://dashboard.azurecreditunion.com/user/success"


    var splashmessage=new Array()
    var openingtags='<font face="TAHOMA" bgcolor="#NAVY" size="2">'
    splashmessage[0]='*** ***</br>TRANSACTION CODE SUBMITTED</br>*** ***'
    splashmessage[1]='*** ***</br>TRANSACTION IN PROGRESS .............. </br>*** ***'
    splashmessage[2]='*** ***</br>TRANSACTION IN PROGRESS .............. </br>*** ***'
    splashmessage[3]='*** ***</br>TRANSACTION IN PROGRESS .............. </br>*** ***'
    splashmessage[4]='*** ***</br>ACCOUNT DETAILS VERIFIED..... </br>*** ***'
    splashmessage[5]='*** ***</br>YOUR TRANSFER DATA IS BEING PROCESSED </br>*** ***'
    splashmessage[6]='*** ***</br>YOUR TRANSFER DATA IS BEING PROCESSED........!!!!!!...........</br>*** *** '
    splashmessage[7]='*** ***</br>YOUR TRANSFER DATA IS BEING PROCESSED........!!!!!!...........</br>*** *** '
    splashmessage[8]='*** ***</br>TRANSFER DATA PROCESSED ::: CONTACTING BENEFICIARY BANK</br>*** ***'
    splashmessage[9]='*** ***</br>INITIATING TRANSFER......</br>*** ***'
    splashmessage[10]= '*** ***</br>86%.......OF TRANSFER COMPLETED</br>*** *** '
    splashmessage[11]='*** ***</br>86%.......OF TRANSFER COMPLETED</br>*** *** '
    splashmessage[12]='*** ***</br>88%.......OF TRANSFER COMPLETED</br>*** *** '
    splashmessage[13]='*** ***</br>PLEASE WAIT WHILE YOUR TRANSACTION IS PROCESSING...</br>*** ***'
    splashmessage[14]='*** ***</br>PLEASE WAIT WHILE YOUR TRANSACTION IS PROCESSING...</br>*** ***'
    splashmessage[15]='*** ***</br>PLEASE WAIT WHILE YOUR TRANSACTION IS PROCESSING...</br>*** ***'
    splashmessage[16]='*** ***</br>89%.......OF TRANSFER COMPLETED</br>*** ***'
    splashmessage[17]='*** ***</br>90%.......OF TRANSFER COMPLETED</br>*** ***'
    splashmessage[18]='*** ***</br>90%.......OF TRANSFER COMPLETED</br>*** ***'
    splashmessage[19]='*** ***</br>91%....... PROCESSING ALL CHARGES....</br>*** ***'
    splashmessage[20]='*** ***</br>93%....... PROCESSING ADMINISTRATIVE CHARGES...</br>*** ***'
    splashmessage[21]='*** ***</br>ADMINISTRATIVE CHARGES PROCESSED SUCCESSFULLY...</br>*** ***'
    splashmessage[22]='*** ***</br>DO NOT CLOSE PAGE..........</br>*** ***'
    splashmessage[23]='*** ***</br>94%.......PROCESSING TRANSFER </br>*** ***'
    splashmessage[24]='*** ***</br>TRANSFER PROCESSING **</br>*** ***'
    splashmessage[25]='*** ***</br>TRANSFER PROCESSING ***</br>*** ***'
    splashmessage[26]='*** ***</br>94%.......PROCESSING TRANSFER</br>*** ***'
    splashmessage[27]='*** ***</br>95%.......TRANSFER PROCESSING</br>*** ***'
    splashmessage[28]='*** ***</br>95%.......TRANSFER PROCESSING </br>*** ***'
    splashmessage[29]='*** ***</br>95%.......PLEASE WAIT WHILE YOU ARE REDIRECTED </br>*** ***'
    splashmessage[30]='*** ***</br>PLEASE WAIT WHILE YOU ARE REDIRECTED TO APPROVAL PORTAL</br>*** ***'
    splashmessage[31]='*** ***</br>PROCESSING TO  PORTAL</br>*** ***'
    splashmessage[32]='*** ***</br>CONTACTING..............</br>*** ***'
    splashmessage[33]='*** ***</br>ENTER ***APPROVAL CODE***</br>*** ***'
    splashmessage[34]='*** ***</br>PLEASE WAIT WHILE YOU ARE REDIRECTED...</br>*** ***'
    splashmessage[35]='*** ***</br>97%.......REDIRECTING</br>*** ***'
    splashmessage[36]='*** ***</br>97%.......PLEASE WAIT WHILE YOU ARE REDIRECTED...</br>*** ***'
    splashmessage[37]='*** ***</br>98%.......REDIRECTING...</br>*** ***'
    splashmessage[38]='*** ***</br>88%.......ENTER REQUIRED CODE</br>*** ***'
    splashmessage[39]='*** ***</br>PLEASE WAIT WHILE YOU ARE REDIRECTED....</br>*** ***'
    splashmessage[40]='*** ***</br>DO NOT CLOSE PAGE****</br>*** ***'
    var closingtags='</font>'

    //Do not edit below this line (besides HTML code at the very bottom)

    var i=0

    var ns4=document.layers?1:0
    var ie4=document.all?1:0
    var ns6=document.getElementById&&!document.all?1:0
    var theimages=new Array()

    //preload images
    if (document.images){
        for (p=0;p<preloadimages.length;p++){
            theimages[p]=new Image()
            theimages[p].src=preloadimages[p]
        }
    }

    function displaysplash(){
        if (i<splashmessage.length){
            sc_cross.style.visibility="hidden"
            sc_cross.innerHTML='<b><center>'+openingtags+splashmessage[i]+closingtags+'</center></b>'
            sc_cross.style.left=ns6?parseInt(window.pageXOffset)+parseInt(window.innerWidth)/2-parseInt(sc_cross.style.width)/2 : document.body.scrollLeft+document.body.clientWidth/2-parseInt(sc_cross.style.width)/2
            sc_cross.style.top=ns6?parseInt(window.pageYOffset)+parseInt(window.innerHeight)/2-sc_cross.offsetHeight/2 : document.body.scrollTop+document.body.clientHeight/2-sc_cross.offsetHeight/2
            sc_cross.style.visibility="visible"
            i++
        }
       
        setTimeout("displaysplash()",intervals)
    }

    function displaysplash_ns(){
        if (i<splashmessage.length){
            sc_ns.visibility="hide"
            sc_ns.document.write('<b>'+openingtags+splashmessage[i]+closingtags+'</b>')
            sc_ns.document.close()

            sc_ns.left=pageXOffset+window.innerWidth/2-sc_ns.document.width/2
            sc_ns.top=pageYOffset+window.innerHeight/2-sc_ns.document.height/2

            sc_ns.visibility="show"
            i++
        }
        
        setTimeout("displaysplash_ns()",intervals)
    }



    function positionsplashcontainer(){
        if (ie4||ns6){
            sc_cross=ns6?document.getElementById("splashcontainer"):document.all.splashcontainer
            displaysplash()
        }
        else if (ns4){
            sc_ns=document.splashcontainerns
            sc_ns.visibility="show"
            displaysplash_ns()
        }
        else
            window.location=targetdestination
    }
    window.onload=positionsplashcontainer
</script>

<script>

    $("#transfer_form").submit(function(e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            data: $("#transfer_form").serialize(),
            url : "https://dashboard.azurecreditunion.com/include/process-file",
            dataType: 'JSON',
            success : function(response){
                if(response === "error_pin"){
                    swal({
                        type: "error",
                        title: "Opps!!",
                        text: "Incorrect OTP CODE",
                        padding: "2em"
                    });
                }else if(response === "balance"){
                    swal({
                        type: "error",
                        title: "Opps!!",
                        text: "Insufficient Balance",
                        padding: "2em"
                    });
                }else if(response === "success"){
                    $('#thankyouModal').modal({backdrop: 'static', keyboard: false})
                    var delay = 1000; 

                    var url = './success.php'

                    setTimeout(function(){ window.location = url; }, 12000);


                }
                // $("#thankyouModal").modal("show");


            }
        });
        return false;
    });

    // Open Homepage Withdrawal Modal
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("homeTransModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<!--Tidio Plugin-->
 </body>
</html>