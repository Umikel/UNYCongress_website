<?php 
require '../config.php';
session_start(); // Start the session

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
$sql = "SELECT id, image FROM gallery ORDER BY id DESC LIMIT 3";
$result4 = $conn->query($sql);

// Check if there are results
if ($result4 && $result4->num_rows > 0): 
    $images = $result4->fetch_all(MYSQLI_ASSOC); // Fetch all images as an associative array


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $memberId = $_POST['member_id'];
        // Update member status to approved
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
$query = "SELECT COUNT(*) AS total FROM gallery  ";

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
    $image_id = $_POST['image_id'];
    $image_file = $_POST['image_file'];

    // Delete the image from the database
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    
    if ($stmt->execute()) {
        // If the query is successful, delete the image file from the server (if it exists)
        $file_path = "gallery/" . $image_file;
        if (file_exists($file_path)) {
            unlink($file_path); // Delete the file
        }

        // Redirect back to the gallery page or display a success message
        header("Location: media_admin.php"); // Replace with your gallery page
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

// Close the connection
$conn->close();
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


    <title>Media Dashboard</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo htmlspecialchars($user['position']); ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="media_admin">
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
                <a class="nav-link" href="view_news.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>View News</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="add_gallery.php">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Add To Gallery </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_gallery.php">
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Registered Members</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">  <?php echo number_format($totalMembers); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Gallery</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalgallery); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-image fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- events Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">events
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo number_format($totalevents); ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: <?php echo number_format($totalpending); ?>%" aria-valuenow="<?php echo number_format($totalpending); ?>" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                News</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalpending); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 text-center">Recent gallery images</h1>
                 

                   
                    <!-- DataTales Example -->
                    <div class="col-lg-12">
                    <div class="row">
        <?php foreach ($images as $image): ?>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <?php if (!empty($image['image'])): ?>
                        <!-- Display image from gallery -->
                        <img src="gallery/<?php echo htmlspecialchars(basename($image['image'])); ?>" class="card-img-top" alt="" style="width: 100%; height: 200px; object-fit: cover;">
                    <?php endif; ?>

                    <!-- Edit and Mark as Done Buttons (optional) -->
<!-- Delete Button -->
<form action="media_admin.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
    <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
    <input type="hidden" name="image_file" value="<?php echo htmlspecialchars(basename($image['image'])); ?>">
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <p>No images found in the gallery.</p>
<?php endif; ?>



               
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