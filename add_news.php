<?php 
require '../config.php';
session_start(); // Start the session

$errors = [
    "news_title" => "", "news_content" => "", "news_date" => "", "pic" => "", "general" => ""];
    $news_title = $pic = $news_date = $news_content ="";


// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Fetch user details from the database
$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT name, position, phone FROM media_admin WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and fetch details
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle case where user details are not found
    echo "User details not found.";
    exit;
}

// Query to count the total number of records in the 'members' table
$query = "SELECT COUNT(*) AS total FROM members WHERE status ='approved'";

// Execute the query
$result = $conn->query($query);

if ($result) {
    // Fetch the result
    $row = $result->fetch_assoc();
    
    // Get the total number of members
    $totalMembers = $row['total'];
} else {
    // Handle query error
    $totalMembers = "Error: " . $conn->error;
}
// Query to count the total number of records in the 'members' table
$query = "SELECT COUNT(*) AS total FROM members WHERE status ='pending'";

// Execute the query
$result1 = $conn->query($query);

if ($result1) {
    // Fetch the result
    $row1 = $result1->fetch_assoc();
    
    // Get the total number of members
    $totalpending = $row1['total'];
} else {
    // Handle query error
    $totalpending = "Error: " . $conn->error;
}
//fetch all event from the database 
$query = "SELECT COUNT(*) AS total FROM events";

// Execute the query
$result3 = $conn->query($query);

if ($result3) {
    // Fetch the result
    $row3 = $result3->fetch_assoc();
    
    // Get the total number of members
    $totalevents = $row3['total'];
} else {
    // Handle query error
    $totalevents = "Error: " . $conn->error;
}
// Fetch all members from the database
$stmt = $conn->prepare("SELECT id, name, email, phone, gender, state, local_govt, dob, occupation, why_join FROM members WHERE status ='pending'");
$stmt->execute();
$result = $stmt->get_result();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $memberId = $_POST['member_id'];
        // Upnews_date member status to approved
        $stmt = $conn->prepare("UPDATE members SET status = 'approved' WHERE id = ?");
        $stmt->bind_param("i", $memberId);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['reject'])) {
        $memberId = $_POST['member_id'];
        // Delete the member from the table
        $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
        $stmt->bind_param("i", $memberId);
        $stmt->execute();
        $stmt->close();
    }
}
//fetch all event from the database 
$query = "SELECT COUNT(*) AS total FROM gallery";

// Execute the query
$result5 = $conn->query($query);

if ($result5) {
    // Fetch the result
    $row0 = $result5->fetch_assoc();
    
    // Get the total number of members
    $totalgallery = $row0['total'];
} else {
    // Handle query error
    $totalgallery = "Error: " . $conn->error;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $news_title = $_POST['news_title'];
    $news_content = $_POST['news_content'];
    $news_date = $_POST['news_date'];

    // Handle file upload
    $pic = '';
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == UPLOAD_ERR_OK) {
        $pic = 'news/' . basename($_FILES['pic']['name']);
        if (!move_uploaded_file($_FILES['pic']['tmp_name'], $pic)) {
            $errors['pic'] = 'Failed to upload picture.';
        }
    }

    // Validate inputs
    if (empty($news_title)) {
        $errors['news_title'] = 'news_title is required';
    }
    if (empty($news_content)) {
        $errors['news_content'] = 'Event content is required';
    }
    if (empty($news_date)) {
        $errors['news_date'] = 'Event date is required';
    }

    // If no errors, insert into database
    if (empty(array_filter($errors))) {
        $stmt = $conn->prepare("INSERT INTO news (title, content, date, image) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$news_title, $news_content, $news_date, $pic])) {
            $errors['general'] = 'You have successfully added the News';
            $news_title = $pic = $news_date = $news_content = "";
        } else {
            $errors['general'] = 'Failed to add the event: ' . $stmt->error;
        }
    }

    // Close the statement after execution (optional)
    $stmt->close();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png">


    <title>Add News</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
     <!-- Custom styles for this page -->
     <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="media_admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo htmlspecialchars($user['position']); ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="media_admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Membership
            </div>

         
            <li class="nav-item">
                <a class="nav-link" href="add_news.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Add News</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_members.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>View News</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="add_gallery.php">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Add To Gallery </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_event.php">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>View Gallery </span></a>
            </li>
             

            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-cog"></i>
               <span>Settings</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
         

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                   

                    <!-- Topbar Navbar -->
                     <ul class="navbar-nav ml-auto">

                       
                            
                        </li>

                        <!-- Nav Item - Alerts -->
                         

                       
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($user['name']); ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                          
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                     <!-- Page Heading -->
                     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">News Section</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                 
                    <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 text-center">Add News</h1>
                 

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">News</h6>
                        </div>
                        <div class="card-body">
                        <h3 class="text-secondary text-center"><?php echo $errors['general'] ?></h3>
                        <form action="add_news.php" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="name">News Title:</label>
                            <input type="text" class="form-control" id="name" name="news_title" value="<?php echo $news_title ?>" placeholder="News Title">
                            <small class="text-danger"><?php echo $errors['news_title'] ?></small>
                          </div>
                          <div class="form-group">
                            <label for="email">News Content:</label>
                            <input type="text" class="form-control" id="email" value="<?php echo $news_content ?>" name="news_content" placeholder="Event Content">
                            <small class="text-danger"><?php echo $errors['news_content'] ?></small>
                        </div>
                          <div class="form-group">
                            <label for="phone">News date:</label>
                            <input type="date" class="form-control" id="phone" value="<?php echo $news_date ?>" name="news_date" placeholder="Date of the News">
                            <small class="text-danger"><?php echo $errors['news_date'] ?></small>
                        </div>

                         
                         
                          <div class="form-group">
                            <label for="occupation">picture:</label>
                            <input type="file" class="form-control" id="occupation" value="<?php echo $pic ?>" name="pic">
                            <small class="text-danger"><?php echo $errors['pic'] ?></small>
                        </div>
                          
                          
                         
                          <button type="submit" class="btn btn-primary">Add News Image</button>
                        </form>
                       
                        </div>
                    </div>

                </div>
               
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Powered by <a href="https://colorlib.com" target="_blank">UmsadTech Company</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>