<?php
require '../config.php';
session_start();

if (!isset($_SESSION['lemail'])) {
    header("Location: indigene.php");
    exit();
}
$mess = "";
$lemail = $_SESSION['lemail'];

$sqli = "SELECT * FROM users WHERE email = '$lemail' ";
$result = mysqli_query($conn, $sqli);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $fname = $data["first_name"];
    $lname = $data["last_name"];
    $phone = $data["phone"];
    $email = $data["email"];
    $id = $data["id"];
    $profile_pic = $data["passport"];
} else {
    echo "Error fetching user details: " . $conn->error;
    exit();
}
$amount = 3000;
if (!$_GET["sucessfullpaid"]) {
    header("location: payment.php");
} else {
    $ref = $_GET["sucessfullpaid"];
}
$sql = "INSERT INTO `payment`(`email`, `amount`, `user_id`, `trans_id`) 
VALUES ('$email','$amount','$id','$ref')";
$put = mysqli_query($conn, $sql);









?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo 1.jfif">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../sytles.css">
    <link href="curl https://api.paystack.co/transaction/initialize">

    <title>Payment</title>
</head>

<body>
    <style>
        #prof {
            width: 40%;
            height: 15vh;
            border-radius: 100px;
        }

        #nod {
            font-family: Bahnschrift Light;
            font-size: 110%;
            background-color: rgba(0, 0, 255, 0.74);
            color: white;
        }

        #nod:hover {

            background-color: black;
            color: black;
        }

        #nodo {
            font-family: Bahnschrift Light;
            font-size: 110%;
            background-color: rgba(15, 15, 37, 0.74);
            color: white;
        }

        @media only screen and (min-width:768px) {
            #prof {
                width: 45%;
                height: 20vh;
                border-radius: 100px;
                margin-bottom: 3vh;
            }

            #nod:hover {

                background-color: black;
                color: black;
            }

            #nod {
                font-family: Bahnschrift Light;
                font-size: 110%;
                background-color: rgba(0, 0, 255, 0.74);
                color: white;
            }

            #nodo {
                font-family: Bahnschrift Light;
                font-size: 110%;
                background-color: rgba(15, 15, 37, 0.74);
                color: white;
            }

        }
    </style>


    <nav class="navbar navbar-expand-sm navbar-light bg-white shadow mb-1 sticky-top">
        <div class="container">

            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">

                </ul>

                <h5 class="m-2 "><?php echo $fname . " " . $lname ?></h5> <a class="nav-link text-danger" id="nood" href="logout.php"><strong>Logout</strong></a>
            </div>
        </div>
    </nav>
    <div class="row justify-content-center g-0 p-3">
        <div class="col-sm-3 p-3 border-end border-primary text-center">
            <center><img id="prof" src="../image/<?php echo $profile_pic ?>" class="img-fluid " alt="Profile Pic" /> </center>
            <h5><?php echo $fname . " " . $lname ?></h5>
            <h5>indigene ID</h5>
            <h5>Ward</h5>
            <a class="nav-link text-light m-2 rounded p-1 " id="nod" href="user_dashboard.php">Dashboard</a>
            <a class="nav-link text-light m-2 rounded p-1 " id="nod" href="upload_image.php">Upload Passport</a>
            <a class="nav-link text-light m-2 rounded p-1 " id="nod" href="update_details.php">Update Record</a>
            <a class="nav-link text-light m-2 rounded p-1 " id="nodo" href="#">Payment</a>
            <a class="nav-link text-light m-2 rounded p-1 " id="nod" href="check.php">Payment Status</a>
            <a class="nav-link text-light m-2 rounded p-1 " id="nod" href="logout.php">Print Indigene Certificate</a>
            <a class="nav-link text-light m-2 rounded p-1 " id="nod" href="logout.php">Settings</a>

        </div>
        <div class="col-sm-9 p-3  ">
            <div class="container p-2 bg-primary br-3 text-center">
                <h4 class="text-light">Welcome <i><?php echo $fname . " " . $lname  ?></i></h4>
            </div>
            <div class="row justify-content-center align-items-center p-2 g-0">
                <div class=" col-sm-10 border p-3 rounded text-center">
                    <h2 class="text-primary">Congratualation</h2>
                    <p>Your transaction number: <b><?php echo $ref ?></b></p>
                    <p>Amount Paid: <b>N <?php echo $amount ?>.00</b></p>
                </div>

            </div>
        </div>



        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script src="../script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>