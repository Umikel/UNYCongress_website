<?php 
require '../config.php';
session_start(); // Start the session
$errors = [
    "title" => "", "event_content" => "", "date" => "", "venue" => "", "pic" => "", "general" => ""];
    $title = $venue = $pic = $date = $event_content ="";

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Fetch user details from the database
$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT name, position, phone FROM president WHERE id = ?");
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
// Check if the connection was successful
if ($conn) {
    // Prepare the query to fetch the latest 3 events
    $sql = "SELECT id, title, content, date, venue, image FROM events  WHERE status = 'upcoming' ORDER BY id DESC ";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch all results as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    } else {
        echo "<p>No events found.</p>";
    }
} else {
    // Output an error if the connection failed
    echo "Connection Error: " . mysqli_connect_error();
}

if ($conn) {
    // Prepare the query to fetch the latest 3 events
    $sql = "SELECT id, title, content, date, venue, image FROM events  WHERE status = 'done' ORDER BY id DESC ";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch all results as an associative array
        while ($row1 = mysqli_fetch_assoc($result)) {
            $events1[] = $row1;
        }
    } else {
        $errors["general"] = "No events found.";
    }
} else {
    // Output an error if the connection failed
    echo "Connection Error: " . mysqli_connect_error();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event_id']) && filter_var($_POST['event_id'], FILTER_VALIDATE_INT)) {
        $event_id = $_POST['event_id'];

        // Prepare the delete statement
        $sql = "DELETE FROM events WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("i", $event_id);

        if ($stmt->execute()) {
            // Redirect to the finished events page or any success page
            header("Location: view_event.php");
            exit();
        } else {
            // Log or display error details
            echo "Error deleting the event: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid Event ID.";
    }
} else {
    // You can omit this or show a form if accessed via GET request
    // Do not display an error message here
}


// Fetch all members from the database 2
$stmt0 = $conn->prepare("SELECT id, name, email, phone, gender, state, local_govt, dob, occupation, why_join FROM members WHERE status ='pending'");
$stmt0->execute();
$result0 = $stmt0->get_result();



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


    <title>view events</title>

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
                <a class="nav-link" href="dashboard.php">
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
                <a class="nav-link" href="view_members.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>All Members</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_event.php">
                    <i class="fas fa-fw fa-calendar-plus"></i>
                    <span>Add Event</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_event.php">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>View Events </span></a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link" href="view_donation.php">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>View donation </span></a>
            </li>
             

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                settings
            </div>

         
            <!-- Nav Item - Tables -->
             
         
         
            <li class="nav-item">
                <a class="nav-link" href="president_setting.php">
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
                         

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter"><?php echo number_format($totalpending); ?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6> <?php
            if ($result0->num_rows > 0) {
                while ($row = $result0->fetch_assoc()) { ?>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                    alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi I want to join United Nigerian Youths Congress..</div>
                                        <div class="small text-gray-500"><?php echo htmlspecialchars($row['name']) ?></div>
                                    </div>
                                </a>
                                <?php
                            }
            } else {
                echo "<tr><td colspan='9'>No members found.</td></tr>";
            }
            ?>    
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

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
                        <h1 class="h3 mb-0 text-gray-800">All Members</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                 
                    <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 text-center">Upcoming Events</h1>
                 

                    <!-- DataTales Example -->
                    <div class="col-lg-12">
            <div class="row align-items-md-stretch mb-4">

            <?php if (!empty($events)): ?>
    <?php foreach ($events as $event): ?>
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <?php if (!empty($event['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars(basename($event['image'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                    <p class="card-text">
                        <?php echo htmlspecialchars($event['content']); ?>
                        <br><b>Date:</b> <?php echo htmlspecialchars($event['date']); ?>
                        <br><b>Venue:</b> <?php echo htmlspecialchars($event['venue']); ?>.

                    </p>

                    <!-- Edit and Mark as Done Buttons -->
                    <a href="edit_event.php?event_id=<?php echo $event['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="mark_event_done.php?event_id=<?php echo $event['id']; ?>" class="btn btn-success">Mark as Done</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No events found.</p>
<?php endif; ?>
               
            </div>
            <!-- End of Main Content -->
              <!-- Page Heading -->
              <h1 class="h3 mb-2 text-gray-800 text-center">Finished Events</h1>
                 

                 <!-- DataTales Example -->
                 <div class="col-lg-12">
         <div class="row align-items-md-stretch mb-4">

             <?php if (!empty($events1)): ?>
                 <?php foreach ($events1 as $event): ?>
                         <div class="col-md-4">
                             <div class="card" style="width: 18rem;">
                                 <?php if (!empty($event['image'])): ?>
                                         <img src="uploads/<?php echo htmlspecialchars(basename($event['image'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" style="width: 100%; height: 200px; object-fit: cover;" >
                                     <?php endif; ?>
                                 
                                 <div class="card-body">
                                     <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                     <p class="card-text">
                                         <?php echo htmlspecialchars($event['content']); ?>
                                         <br><b>Date:</b> <?php echo htmlspecialchars($event['date']); ?>
                                         <br><b>Venue:</b> <?php echo htmlspecialchars($event['venue']); ?>.
                                     </p>
                                     <!-- Delete Button -->
                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>     </div>
                             </div>
                         </div>
                     
                 <?php endforeach; ?>
             <?php else: ?>
                 <p>No events found.</p>
             <?php endif; ?>
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