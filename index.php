<?php
require 'config.php';
$events = []; // Initialize an empty array to store events

// Check if the connection was successful
if ($conn) {
    // Prepare the query to fetch the latest 3 events
    $sql = "SELECT id, title, content, date, venue, image FROM events  WHERE status = 'upcoming' ORDER BY id DESC LIMIT 3 ";
    
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
// Query to count the total number of records in the 'finished event' table
$query = "SELECT COUNT(*) AS total FROM events WHERE status ='done'";

// Execute the query
$result1 = $conn->query($query);

if ($result1) {
    // Fetch the result
    $row = $result1->fetch_assoc();
    
    // Get the total number of members
    $totalevent = $row['total'];
} else {
    // Handle query error
    $totalevent = "Error: " . $conn->error;
}



if ($conn) {
    // Prepare the query to fetch the latest 3 events
    $sql1 = "SELECT id, title, content, date, image FROM news  ORDER BY id DESC LIMIT 3 ";
    
    // Execute the query
    $result01 = mysqli_query($conn, $sql1);
    
    // Check if any rows were returned
    if (mysqli_num_rows($result01) > 0) {
        // Fetch all results as an associative array
        while ($row = mysqli_fetch_assoc($result01)) {
            $news[] = $row;
        }
    } else {
        echo "<p>No events found.</p>";
    }
} else {
    // Output an error if the connection failed
    echo "Connection Error: " . mysqli_connect_error();
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>United Nigerian Youth</title>
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

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider  d-flex align-items-center slider_bg_1 overlay2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="slider_text ">
                            <span>Get Started Today.</span>
                            <h3> Theme: Building a New Nation</h3>
                            <p>Join us in building a Nigeria where diversity strengthens our unity.</p>
                            <a href="register.php" class="boxed-btn3">Register As a Member
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- reson_area_start  -->
    <div class="reson_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>Our Objectives</span></h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="img/help/1.png" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h5> Promote National Unity</h5>
                            <p>To promote a culture of
                                patriotism among Nigerian
                                youth through sensitization
                                and awareness campaigns.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="img/help//5.png" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h5>Empower Youths to become Active Change-makers</h5>
                            <p>To Foster National unity and
                                create an atmosphere for
                                One Nigeria.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="img/help/4.png" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h5>Support Youth-led Initiatives</h5>
                            <p>Provide support and resources to youth-led initiatives
                                 and projects that drive positive change.</p>
                           
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="img/help/2.png" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h5>Promote Patriotism</h5>
                            <p>Promote patriotism and national pride among Nigerian youths, 
                                encouraging them to value and contribute to their country's growth and development.</p>
                           
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="img/help/3.png" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h5>Foster a Sense of Belonging and Ownership</h5>
                            <p>Encourage Nigerian youths to take ownership of their country's 
                                development, fostering a sense of belonging and responsibility among them.</p>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- reson_area_end  -->

    <!-- latest_activites_area_start  -->
    <div class="latest_activites_area">
        <div class=" video_bg_1 video_activite  d-flex align-items-center justify-content-center">
            <a class="popup-video" href="https://www.youtube.com/watch?v=MG3jGHnBVQs">
                <i class="flaticon-ui"></i>
            </a>
        </div>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="activites_info">
                        <div class="section_title">
                            <h3> <span>Who We Are? </span><br>
                                UNY Congress</h3>
                        </div>
                        <p class="para_1">The United Nigerian Youths Congress (UNY) is a non-governmental, non-partisan, and non-profit organization that brings together Nigerian youths from diverse backgrounds, ages 18-40, who share a common vision of building a united, prosperous, and secure nation.
                            .</p class="para_1">
                        <p class="para_2">
                            The United Nigerian Youths Congress (UNY) is an organization that aims to promote national unity, patriotism, and sustainable development among Nigerian youths.
                        </p>
                        <a href="donate.php" data-scroll-nav='1' class="boxed-btn4">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest_activites_area_end  -->

    <!-- popular_causes_area_start  -->
    
    <!-- popular_causes_area_end  -->

    <!-- counter_area_start  -->
    <div class="counter_area mt-4">
        <div class="container">
            <div class="counter_bg overlay">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-calendar"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter"><?php echo number_format($totalevent); ?></h3>
                                <p>Finished Event</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-heart-beat"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">5</h3>
                                <p>Gallery</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-in-love"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">10</h3>
                                <p>Leaders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-hug"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter"><?php echo number_format($totalMembers); ?></h3>
                                <p>Members</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter_area_end  -->

    <!-- our_volunteer_area_start  -->
    <div class="our_volunteer_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>National Excos</span></h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single_volenteer">
                        <div class="volenteer_thumb">
                            <img src="img/volenteer/1.png" alt="">
                        </div>
                        <div class="voolenteer_info d-flex align-items-end">
                            <div class="social_links">
                                <ul>
                                    <li>
                                        <a href="#"> <i class="fa fa-facebook"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-pinterest"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-linkedin"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-twitter"></i> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="info_inner">
                                <h4>Arc. Naseer Suleman C</h4>
                                <p>National President & Convener</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_volenteer">
                        <div class="volenteer_thumb">
                            <img src="img/volenteer/2.png" alt="">
                        </div>
                        <div class="voolenteer_info d-flex align-items-end">
                            <div class="social_links">
                                <ul>
                                    <li>
                                        <a href="#"> <i class="fa fa-facebook"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-pinterest"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-linkedin"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-twitter"></i> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="info_inner">
                                <h4>First Name</h4>
                                <p>Kano State Chapter</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_volenteer">
                        <div class="volenteer_thumb">
                            <img src="img/volenteer/3.png" alt="">
                        </div>
                        <div class="voolenteer_info d-flex align-items-end">
                            <div class="social_links">
                                <ul>
                                    <li>
                                        <a href="#"> <i class="fa fa-facebook"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-pinterest"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-linkedin"></i> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-twitter"></i> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="info_inner">
                                <h4>Abdullahi A Abdullahi</h4>
                                <p>secretary</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- our_volunteer_area_end  -->

    <!-- news__area_start  -->
    <div class="news__area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>News & Updates</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="news_active owl-carousel">
                        
                <?php if (!empty($news)): ?>
                    <?php foreach ($news as $new): ?>

                        <div class="single__blog d-flex align-items-center">
                            <div class="thum">
                            <img src="./auth/news/<?php echo htmlspecialchars(basename($new['image'])); ?>" alt=""style="width: 100%; height: 400px; object-fit: cover;">
                            </div>
                            <div class="newsinfo">
                                <span><?php echo htmlspecialchars($new['date']); ?></span>
                                <a href="single-blog.html">
                                    <h3><?php echo htmlspecialchars($new['title']); ?></h3>
                                </a>
                                <p><?php echo htmlspecialchars($new['content']); ?></p>
                                <a class="read_more" href="single-blog.html">Read More</a>
                            </div>
                    </div>
                            <?php endforeach; ?>
                <?php else: ?>
                    <p>No events found.</p>
                <?php endif; ?>
                        </div>
                </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- news__area_end  -->

    <div data-scroll-index='1' class="make_donation_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center mb-55">
                    <h3><span>Upcoming Events</span></h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
            <div class="row align-items-md-stretch mb-4">

                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <?php if (!empty($event['image'])): ?>
                                            <img src="./auth/uploads/<?php echo htmlspecialchars(basename($event['image'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" style="width: 100%; height: 200px; object-fit: cover;" >
                                        <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                        <p class="card-text">
                                            <?php echo htmlspecialchars($event['content']); ?>
                                            <br><b>Date:</b> <?php echo htmlspecialchars($event['date']); ?>
                                            <br><b>Venue:</b> <?php echo htmlspecialchars($event['venue']); ?>.
                                        </p>
                                        <a href="book_event_form.php?event_id=<?php echo $event['id']; ?>" class="btn btn-primary">Book Your Place</a>
                                    </div>
                                </div>
                            </div>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No events found.</p>
                <?php endif; ?>
            </div>
        </div>
                </div>
                </div>
                </div>



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
                                <li><a href="donate.html">Donate</a></li>
                                <li><a href="#">News</a></li>
                                <li><a href="#">Register</a></li>
                                <li><a href="event.html">Event</a></li>
                                <li><a href="gallery.html">Gallery</a></li>
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