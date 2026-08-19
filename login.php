<?php
session_start(); // Start the session

require '../config.php';

$errors = ["password" => "", "email" => "", "general" => ""];
$password = $email = "";

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (empty($email)) {
        $errors["email"] = 'Enter your email';
    } elseif (!validate_email($email)) {
        $errors["email"] = 'Invalid email';
    }

    // Proceed only if there are no validation errors
    if (empty($errors["email"]) && empty($errors["password"])) {

        // Check if the user is a president
        $stmt = $conn->prepare("SELECT * FROM president WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify password (using plain comparison for now, consider using password_hash)
            if ($password === $row['password']) {
                // Create session variables for president
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];

                // Redirect to president dashboard
                header("Location: dashboard.php");
                exit;
            } else {
                $errors["general"] = "Invalid password.";
            }

        } else {
            // Check if the user is a media admin
            $stmt = $conn->prepare("SELECT * FROM media_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify password (using plain comparison for now, consider using password_hash)
                if ($password === $row['password']) {
                    // Create session variables for media admin
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];

                    // Redirect to media admin dashboard
                    header("Location: media_admin.php");
                    exit;
                } else {
                    $errors["general"] = "Invalid password.";
                }
            } else {
                $errors["general"] = "No account found with that email.";
            }
        }
        $stmt->close();
    }
}
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/themify-icons.css">
    <link rel="stylesheet" href="../css/nice-select.css">
    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/gijgo.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/slicknav.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->


    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div class="header-top_area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-md-12 col-lg-8">
                            <div class="short_contact_list">
                                <ul>
                                    <li><a href="#"> <i class="fa fa-phone"></i> 0805 353 2281</a></li>
                                    <li><a href="#"> <i class="fa fa-envelope"></i>Email us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-lg-4">
                            <div class="social_media_links d-none d-lg-block">
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-instagram"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-4">
                            <div class="logo">
                                <a href="index.html">
                                    <h5 class="text-light text=center">United Nigerian Youth congress</h5>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="../index.php">home</a></li>
                                        <li><a href="../About.php">About us</a></li>
                                        <li><a href="../event.php">Events</a></li>
                                        <li><a href="../gallery.php">Gallery</a></li>
                                        <li><a href="#">Register/Login <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="../register.php">Register </a></li>
                                                <li><a href="login.php">Admin</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="../contact.php">Contact</a></li>
                                    </ul>
                                </nav>
                                <div class="Appointment">
                                    <div class="book_btn d-none d-lg-block">
                                        <a data-scroll-nav='1' href="../donate.php">Make a Donate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->
      <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Admin Login</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->
    
    <!-- ================ contact section start ================= -->
    <section class="contact-section">
            <div class="container">
                
        
                <div class="row">
                    <div class="col-12">
                        <div class="section_title text-center">
                            <h3> <span>Welcome to UNYC Admin Portal! </span></h3>
                        </div><p>Thank you for your interest in joining the United Nigerian Youth Congress (UNYC) <br>
                        Please fill out the form accurately and completely to ensure successful registration. <br></p>
                        <small class="text-danger"><?php echo $errors['general'] ?></small>
                        <form action="login.php" method="post" enctype="multipart/form-data">
                      
                          <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $email ?>" name="email" placeholder="Enter your email">
                            <small class="text-danger"><?php echo $errors['email'] ?></small>
                        </div>
                          <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" value="<?php echo $password ?>" name="password" placeholder="Enter your password">
                            <small class="text-danger"><?php echo $errors['password'] ?></small>
                        </div>
                <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                       </div>
            </div>
        </section>
    <!-- ================ contact section end ================= -->
    

    <!-- footer_start  -->
   <!-- footer_start  -->
   <footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6 col-lg-4 ">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#">
                               <h2>UNY Congress</h2>
                            </a>
                        </div>
                        <p class="address_text">The United Nigerian Youths Congress (UNY) is
                             an organization that aims to promote national unity, patriotism,
                              and sustainable development among Nigerian youths.</p>
                       
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 col-lg-2">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Quick Links
                        </h3>
                        <ul class="links">
                            <li><a href="#">Donate</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Register</a></li>
                            <li><a href="#">Event</a></li>
                            <li><a href="#">Gallery</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Contacts
                        </h3>
                        <div class="contacts">
                            <p>+234 805 353 2281 <br>
                                unitednigerianyouth@gmail.com <br>
                                Flat 20, Zoo Road kano state, Nigeria.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Social Media
                        </h3>
                        <div class="socail_links">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="ti-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="ti-twitter-alt"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-dribbble"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="row">
                <div class="bordered_1px "></div>
                <div class="col-xl-12">
                    <p class="copy_right text-center">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Powered by <a href="https://colorlib.com" target="_blank">UmsadTech Company</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer_end  -->

<!-- link that opens popup -->

<!-- JS here -->
<script src="../js/vendor/modernizr-3.5.0.min.js"></script>
<script src="../js/vendor/jquery-1.12.4.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/isotope.pkgd.min.js"></script>
<script src="../js/ajax-form.js"></script>
<script src="../js/waypoints.min.js"></script>
<script src="../js/jquery.counterup.min.js"></script>
<script src="../js/imagesloaded.pkgd.min.js"></script>
<script src="../js/scrollIt.js"></script>
<script src="../js/jquery.scrollUp.min.js"></script>
<script src="../js/wow.min.js"></script>
<script src="../js/nice-select.min.js"></script>
<script src="../js/jquery.slicknav.min.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="../js/gijgo.min.js"></script>
<!--contact js-->
<script src="../js/contact.js"></script>
<script src="../js/jquery.ajaxchimp.min.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<script src="../js/mail-script.js"></script>

<script src="../js/main.js"></script>
</body>

</html>