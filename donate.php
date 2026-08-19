<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Donate</title>
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
    <script src="https://js.paystack.co/v1/inline.js"></script>

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
                        <h3>Donate</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end  -->

    <!-- ================ contact section start ================= -->
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
    <div class="section-top-border">
        <div class="row">
            <div class="col-lg-6 col-md-6 text-center">
                <div class="section_title">
                    <h3> <span>Donate</span></h3>
                </div>
                <form id="paymentForm" onsubmit="event.preventDefault(); payWithPaystack();">
    <div class="mt-10">
        <input type="text" name="first_name" placeholder="First Name"
            onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required
            class="single-input">
    </div>
    <div class="mt-10">
        <input type="text" name="last_name" placeholder="Last Name"
            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required
            class="single-input">
    </div>
    <div class="mt-10">
        <input type="email" name="EMAIL" placeholder="Email address"
            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email address'" required
            class="single-input">
    </div>
    <div class="mt-10">
        <input type="number" name="amout" placeholder="Amount in Naira"
            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Amount in Naira'" required
            class="single-input-primary">
    </div>
    <button class="btn btn-primary mb-5 mt-2" name="pay" id="lo">Donate Now</button> 
</form>

<script src="https://js.paystack.co/v1/inline.js"></script><script src="https://js.paystack.co/v1/inline.js"></script>

<script>
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: 'pk_test_803a9504c55c0845a3208ceb5d1cd735936c92b8', // Replace with your Paystack public key
            email: document.querySelector('input[name="EMAIL"]').value,
            amount: document.querySelector('input[name="amout"]').value * 100, // Amount in kobo
            currency: "NGN",
            firstname: document.querySelector('input[name="first_name"]').value,
            lastname: document.querySelector('input[name="last_name"]').value,
            ref: '' + Math.floor(Math.random() * 1000000000 + 1), // Generate a random reference
            callback: function(response) {
                // Send the transaction details to PHP for processing and storage
                $.ajax({
                    url: 'process_donation.php',
                    method: 'POST',
                    data: {
                        first_name: document.querySelector('input[name="first_name"]').value,
                        last_name: document.querySelector('input[name="last_name"]').value,
                        email: document.querySelector('input[name="EMAIL"]').value,
                        amount: document.querySelector('input[name="amout"]').value,
                        reference: response.reference
                    },
                    success: function(response) {
                        alert("Donation successfully processed!");
                        window.location.href = 'thank_you.php'; // Redirect to a thank you page
                    },
                    error: function() {
                        alert("Error processing donation. Please try again.");
                    }
                });
            },
            onClose: function() {
                alert('Transaction was not completed, window closed.');
            }
        });
        handler.openIframe(); // Open Paystack payment interface
    }
</script>


            </div>
            <div class="col-lg-6 col-md-6 mt-sm-30">
                <div class="single-element-widget ">
                    <div class="section_title text-center">
                        <h3> <span> Support the United Nigerian Youth Congress (UNYC)</span></h3>
                    </div>
                    <div class="switch-wrap d-flex justify-content-between">
                        <p>01. Your donation will help us continue to empower Nigerian youths through education, 
                            skill acquisition, and community development programs.</p>
                        
                    </div>
                    <div class="switch-wrap d-flex justify-content-between">
                        <p>02. Every donation counts, and your contribution will bring us closer 
                            to achieving our mission of building a better Nigeria</p>
                        
                    </div>
                    <div class="switch-wrap d-flex justify-content-between">
                        <p>03. Support the next generation of Nigerian leaders by donating to UNYC today!</p>
                        
                    </div>
                </div>
                <div class="single-element-widget mt-30">
                     <div class="section_title text-center">
                        <h3> <span> Specific Donation Purposes</span></h3>
                    </div>
                    <div class="switch-wrap d-flex justify-content-between">
                        <p>01. Donate to support our Education Initiative: Providing scholarships and educational
                             resources to disadvantaged Nigerian youths.</p>
                        
                    </div>
                    <div class="switch-wrap d-flex justify-content-between">
                        <p>02. Donate to support our Skill Acquisition Program: Empowering 
                            Nigerian youths with vocational skills and training.</p>
                        
                    </div>
                    <div class="switch-wrap d-flex justify-content-between">
                        <p>03. Donate to support our Community Development Projects: Building better communities through 
                            healthcare, sanitation, and infrastructure development.</p>
                        
                    </div>            </div>
        </div>
    </div>
</div>
</div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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