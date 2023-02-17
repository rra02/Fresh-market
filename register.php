<?php
require('db.php');
if (isset($_SESSION['isUserLoggedIn'])) {
  if ($_SESSION['role'] == "customer") {
    echo "<script>window.location.href='customer.php?user_alweredy_loggedin';</script>";
  }
  if ($_SESSION['role'] == "admin") {
    echo "<script>window.location.href='admin.php?user_alweredy_loggedin';</script>";
  }
}
if (isset($_POST['register'])) {

  // data insertion to database
  $query = " SELECT * FROM customers WHERE email_id='{$_POST['emailid']}'";
  $run = mysqli_query($db, $query);
  $data = mysqli_fetch_array($run);
  if (count($data) > 0) {
    echo "<script>window.location.href='register.php?user_alweredy_registered';</script>";
  } else {

   
    $query = " INSERT INTO customers(full_name,phone,email_id,password,role)";
    $query .= " VALUES ('{$_POST['fullname']}','{$_POST['phone']}','{$_POST['emailid']}','{$_POST['password']}','customer')";
   

    $run = mysqli_query($db, $query);
    if ($run) {

      echo "<script>window.location.href='login.php?user_registered_suscessfully';</script>";
    }
  }
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/login.css">
  <title>Register</title>

  <!-- font awesome cdn -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


  <!--  Bootstrap CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


  <!--  Bootstrap JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- icons cdn -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <!-- MY CSS -->
  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="css/responsive.css">


</head>

<body>

  <!-- NAV SECTION -->

  <nav class=" shadow  navbar sticky-top  navbar-expand-lg bg-warning">

    <div class="container-fluid">
      <a href="#">
        <img src="img/logo1.png" width="100px" alt="logo_img" class="d-inline-block align-text-top">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">


        <span class="ti-align-justify navbar-toggler-icon"></span>

      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto " style="font-weight: 500">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.html" style="color:black;">Home</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="contact.html" style="color:rgb(7, 4, 4);">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html" style="color:rgb(14, 7, 7);">About-Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="blog.html" style="color:black;">Blogs</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="port.html" style="color:black;">Portfolio's</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:rgb(9, 6, 6);">
              Products
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="fruits.html" style="color:black;">Fresh Fruits</a></li>
              <li>
                <hr class="dropdown-divider">
              <li><a class="dropdown-item" href="veg.html" style="color:black;">Fresh Vegetables</a></li>

            </ul>

          </li>
          <li class="nav-item">
            <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
          </li>
        </ul>
      </div>
    </div>

  </nav>





  <section class="background firstSection" style="height: 70vh;
    background: url(./img/sl.jpg);
    background-size: cover;
    ">

    <div class="box-main">
      <div class="login-box " style="margin: auto; height:auto;">
        <h1 style="color: black;">Sign-up </h1>
        <?php if (isset($_GET['user_already_registered'])) {
        ?>
          <p style="color:red; text-align:center;">Email Id already registered !</p>

        <?php
        }
        ?>
        <form method="post">
          <input type="text" name="fullname" placeholder="Enter Full Name..." class="input" required>
          <input type="text" name="phone" placeholder="Enter Phone Number.." class="input" required>
          <input type="email" name="emailid" placeholder="Enter Email Id..." class="input" required>
          <input type="password" name="password" placeholder="Enter Password..." class="input">
          <div class="row" required>
            <a href="./login.php" class="button" style="
                font-size: 18px;
                background-color: #eb123e;
                color:white;
                border:0px;
                padding:5px 20px;
                text-decoration:none;
                border-radius: 5px;
                cursor: pointer;">Login Now</a></button><input type="submit" value="Register" name="register" class="login-btn">
          </div>

        </form>
      </div>
    </div>
  </section>




  <!-- fotter section -->

  <footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <div class="ftco-footer-widget mb-4 ml-md-5">

              <ul class="list-unstyled">
                <li><a href="index.html" class="py-2 d-block">HOME</a></li>
                <li><a href="about.html" class="py-2 d-block">ABOUT US</a></li>
                <li><a href="contact.html" class="py-2 d-block">SUPPORT</a></li>
                <li><a href="#" class="py-2 d-block">TERMS & CONDITIONS</a></li>
              </ul>
              <a class="footer-icon" href=""><i class="uil uil-youtube"></i></a>

            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4 ml-md-5">

            <ul class="list-unstyled">
              <li><a href="contact.html" class="py-2 d-block">PARTNER WITH US</a></li>
              <li><a href="#" class="py-2 d-block">INVESTOR RELATION</a></li>
              <li><a href="#" class="py-2 d-block">COPYRIGHT POLICIES</a></li>
            </ul>

            <a class="footer-icon" href=""><i class="uil uil-facebook"></i></a>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">

            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block" data-mdb-toggle="modal" data-mdb-target="#sModal">SUGGESTION</a></li>
              <li><a href="#" class="py-2 d-block" data-mdb-toggle="modal" data-mdb-target="#fsModal">FEEDBACK</a></li>
            </ul>
            <a class="footer-icon" href=""><i class="uil uil-twitter" aria-hidden="true"></i></a> |
            <a class="footer-icon" href=""><i class="uil uil-instagram" aria-hidden="true"></i></a>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">

            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker "></span><span class="text" style="color: white;">302, Deepali
                    Building
                    4rd Floor, 92,Nehru Place, New Delhi-110019</span></li>
                <li><span class="icon icon-phone"></span><span class="text" style="color: white;">+91
                    8XXXXXXXX1</span></li>
                <li><a href="contact.html"><span class="icon icon-envelope"> </span><span class="envelop-text">freshmarket.com</span></a></li>
              </ul>
              <br>
              <a class="footer-icon" href=""><i class="uil uil-google" aria-hidden="true"></i></a> |
              <a class="footer-icon" href="contact.html"><i class="uil uil-map" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <p style="color: white;">
          Copyright © 2021 -
          freshmarket.com All rights reserved | Designed and Developed By <a href="index.html" style="color: white" target="_blank">Reshab Raj Anand</a>
        </p>
      </div>
    </div>
  </footer>



</body>

</html>