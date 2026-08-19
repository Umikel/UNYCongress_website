<?php
require 'config.php';

$errors = [
    "name" => "", "email" => "", "phone" => "", "gender" => "", "nationality" => "", "state" => "",
    "local_govt" => "", "address" => "", "dob" => "", "occupation" => "", "hear_about_us" => "",
    "why_join" => "", "general" => "", "agree" => ""
];
$sent_message = false;
$name = $email = $phone = $gender = $nationality =
$state = $local_govt = $address = $dob = $occupation =
$hear_about_us = $why_join = "";

// Define validation functions
function validate_name($name) {
    return preg_match('/^[a-zA-Z ]+$/', $name);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    return preg_match('/^[0-9]+$/', $phone);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $nationality = trim($_POST['nationality']);
    $state = trim($_POST['state']);
    $local_govt = trim($_POST['local_govt']);
    $address = trim($_POST['address']);
    $dob = trim($_POST['dob']);
    $occupation = trim($_POST['occupation']);
    $hear_about_us = trim($_POST['hear_about_us']);
    $why_join = trim($_POST['why_join']);
    $agree = isset($_POST['terms']) && $_POST['terms'] == 'on';

    // Validate form data

    // name
    if (empty($name)) {
        $errors["name"] = 'Enter your Name';
    } elseif (!validate_name($name)) {
        $errors["name"] = 'Invalid name';
    }

    // email
    if (empty($email)) {
        $errors["email"] = 'Enter your email';
    } elseif (!validate_email($email)) {
        $errors["email"] = 'Invalid email';
    }

    // phone number
    if (empty($phone)) {
        $errors["phone"] = 'Enter your phone number';
    } elseif (!validate_phone($phone)) {
        $errors["phone"] = 'Invalid phone number';
    }

    // gender
    if (empty($gender)) {
        $errors["gender"] = 'Select your gender';
    }

    // nationality
    if (empty($nationality)) {
        $errors["nationality"] = 'Select your nationality';
    }

    // state
    if (empty($state)) {
        $errors["state"] = 'Select your state';
    }

    // local_govt
    if (empty($local_govt)) {
        $errors["local_govt"] = 'Enter your Local Government';
    }

    // address
    if (empty($address)) {
        $errors["address"] = 'Enter your address';
    }

    // dob
    if (empty($dob)) {
        $errors["dob"] = 'Enter your Date of Birth';
    }

    // occupation
    if (empty($occupation)) {
        $errors["occupation"] = 'Enter your occupation';
    }

    // hear_about_us
    if (empty($hear_about_us)) {
        $errors["hear_about_us"] = 'Enter how you heard about us';
    }

    // why_join
    if (empty($why_join)) {
        $errors["why_join"] = 'Enter why you want to join';
    }

    // agree
    if (!$agree) {
        $errors["agree"] = 'Please agree to the terms';
    }

    // Check for errors
    if (!array_filter($errors)) {
        // Check for existing email and phone
        $stmt = $conn->prepare("SELECT * FROM members WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Check if email is already used
            $stmt->prepare("SELECT * FROM members WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $errors["email"] = "Email has already been used";
            }

            // Check if phone number is already used
            $stmt->prepare("SELECT * FROM members WHERE phone = ?");
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $errors["phone"] = "This phone number has already been used";
            }
        } else {
            // Insert data into database
            $stmt = $conn->prepare("INSERT INTO members (name, email, phone, gender, nationality, state, local_govt, address, dob, occupation, hear_about_us, why_join) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssss", $name, $email, $phone, $gender, $nationality, $state, $local_govt, $address, $dob, $occupation, $hear_about_us, $why_join);
            if ($stmt->execute()) {
                $sent_message = true;
            } else {
                $errors["general"] = $stmt->error;
            }
        }
    }
}

$conn->close();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Register</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
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
                                <a href="index.php">
                                    <h5 class="text-light text=center">United Nigerian Youth congress</h5>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.php">home</a></li>
                                        <li><a href="About.php">About us</a></li>
                                        <li><a href="event.php">Events</a></li>
                                        <li><a href="gallery.php">Gallery</a></li>
                                        <li><a href="#">Register/Login <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="register.php">Register </a></li>
                                                <li><a href="auth/login.php">Admin</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact.php">Contact</a></li>
                                    </ul>
                                </nav>
                                <div class="Appointment">
                                    <div class="book_btn d-none d-lg-block">
                                        <a href="donate.php">Make a Donate</a>
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
                        <h3>Be a Member</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->
    
    <!-- ================ contact section start ================= -->
    <section class="contact-section">
            <div class="container">
                
            <?php
            if ($sent_message) { ?>
                  <div class="row">
                  <div class="col-12">
                        <h2 class="text-center text-secondary">Registration Sucessful</h2>
                        <p class="text-center"> Dear, <?php echo $_POST['name'] ?> you have sucessful register as a member of UNYC <br />
                            We will send the mail to <?php echo $_POST['email'] ?>  when your register approve </p>
                    </div>
                </div>
            </div>




            <?php } else {
            ?>
    
                <div class="row">
                    <div class="col-12">
                        <div class="section_title text-center">
                            <h3> <span>Welcome to UNYC Registration! </span></h3>
                        </div><p>Thank you for your interest in joining the United Nigerian Youth Congress (UNYC) <br>
                        Please fill out the form accurately and completely to ensure successful registration. <br></p>
                        <small class="text-danger"><?php echo $errors['general'] ?></small>
                        <form action="register.php" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" placeholder="Enter your name">
                            <small class="text-danger"><?php echo $errors['name'] ?></small>
                          </div>
                          <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $email ?>" name="email" placeholder="Enter your email">
                            <small class="text-danger"><?php echo $errors['email'] ?></small>
                        </div>
                          <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" value="<?php echo $phone ?>" name="phone" placeholder="Enter your phone number">
                            <small class="text-danger"><?php echo $errors['phone'] ?></small>
                        </div>
                          <div class="form-group">
                            <label for="state">Gender:</label>
                            <select class="form-control" id="gender" value="<?php echo $gender ?>" name="gender">
                            <option value="">Select</option>
                              <option value="M">Male</option>
                              <option value="F">Female</option>
                              <!-- Add state options here -->
                            </select>
                            <small class="text-danger"><?php echo $errors['gender'] ?></small>
                          </div>
                          <div class="form-group">
                            <label for="state">Nationality:</label>
                            <select class="form-control" id="nationality" value="<?php echo $nationality ?>" name="nationality">
                              <option value="">Select</option>
                              <option value="Nigeria">Nigeria</option>
                              <!-- Add state options here -->
                            </select>
                            <small class="text-danger"><?php echo $errors['nationality'] ?></small>
                          </div>
                          <div class="form-group">
                            <label for="state">State:</label>
                            <select class="form-control" id="state" value="<?php echo $state ?>" name="state">
                              <option value="">Select</option>
                              <option value="kano">kano</option>
                              <!-- Add state options here -->
                            </select>
                            <small class="text-danger"><?php echo $errors['state'] ?></small>
                          </div>
                          <div class="form-group">
                            <label for="city">Local Government:</label>
                            <input type="text" class="form-control" id="Local Government" value="<?php echo $local_govt ?>" name="local_govt" placeholder="Enter your Local Government">
                          </div>
                          <small class="text-danger"><?php echo $errors['local_govt'] ?></small>
                          <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address ?>" placeholder="Enter your address">
                            <small class="text-danger"><?php echo $errors['address'] ?></small>
                        </div>
                          <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" class="form-control" id="dob" value="<?php echo $dob ?>" name="dob">
                            <small class="text-danger"><?php echo $errors['dob'] ?></small>
                          </div>
                          <div class="form-group">
                            <label for="occupation">Occupation:</label>
                            <input type="text" class="form-control" id="occupation" value="<?php echo $occupation ?>" name="occupation" placeholder="Enter your occupation">
                            <small class="text-danger"><?php echo $errors['occupation'] ?></small>
                        </div>
                          
                          <div class="form-group">
                            <label for="hear-about-us">How did you hear about UNYC?</label>
                            <input type="text" class="form-control" id="hear-about-us" value="<?php echo $hear_about_us ?>" name="hear_about_us" placeholder="Enter how you heard about us">
                            <small class="text-danger"><?php echo $errors['hear_about_us'] ?></small>
                        </div>
                         
                          <div class="form-group">
                            <label for="why-join">Why do you want to join UNYC?</label>
                            <textarea class="form-control" id="why-join" name="why_join" value="<?php echo $why_join ?>" placeholder="Enter why you want to join"></textarea>
                            <small class="text-danger"><?php echo $errors['why_join'] ?></small>
                        </div>
                          <p>I accept membership into United Nigerian Youth Congress and that the standards are limited to person of good moral 
                            character and reputation. I also recognize the importance of rendering personal service to my country in cooperation with 
                        other patriotic youths. </p>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms">
                            <label class="form-check-label" for="terms" >I agree to UNYC's terms and conditions</label>
                            <small class="text-danger"><?php echo $errors['agree'] ?></small>
                        </div>
                          <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                       </div>
            </div>
        </section>
    <!-- ================ contact section end ================= -->
    <?php } ?>

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
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
<script src="js/ajax-form.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/scrollIt.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/nice-select.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/gijgo.min.js"></script>
<!--contact js-->
<script src="js/contact.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/mail-script.js"></script>

<script src="js/main.js"></script>
</body>

</html>