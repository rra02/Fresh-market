<?php

require('db.php');
if (!isset($_SESSION['isUserLoggedIn'])) {
    echo "<script>window.location.href='login.php?user_not_loggedin';</script>";
}
if ($_SESSION['role'] != 'customer') {
    echo "<script>window.location.href='login.php?user_not_loggedin';</script>";
}

if (isset($_POST['submit'])) {

    $query = "INSERT INTO order_detail (fullname, number, email, senderadress, parceldesc, recieveradress)";
    $query .= " VALUES ('{$_POST['fullname']}','{$_POST['number']}','{$_POST['email']}','{$_POST['senderadress']}','{$_POST['parceldesc']}','{$_POST['recieveradress']}')";

    $run = mysqli_query($db, $query);
    $data = mysqli_fetch_array($run);
    if (count($data) > 0) {
        echo "<script>window.location.href='customer.php?data_inserted';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>customer</title>
    <!--  Bootstrap CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- icons cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!--  Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- AJAX LIBRARIES -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <link rel="stylesheet" href="css/pakage.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">





</head>

<body>


    <!-- navbar -->

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
                        <a class="nav-link active" aria-current="page" href="#" style="color:black;">Home</a>
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

                    <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><span style="color: black;">Profile</span> </a>
                   
  
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">


                            <div class="dropdown-item noti-title">
                                <h5 class="text-overflow"><small>Welcome ! User </small> </h5>
                            </div>

                        
                            <!-- item-->
                            <a href="logout.php" class="dropdown-item notify-item">
                                <i class="zmdi zmdi-power"></i> <span>Logout</span>
                            </a>

                        </div>
                    </li>

                    

                    <li class="nav-item">
                        <a class="nav-link active" href="cart1.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    <br>


    <div class="headline text-center mb-5">
        <h2 class="pb-3 position-relative d-inline-block" style="color: rgb(0, 0, 0)">"FRUITS & VEGETBLES"</h2>

    </div>


    <!-- Displaying Products Start -->
    <div class="container">
        <div id="message"></div>
        <div class="row mt-2 pb-3">
            <?php
            require 'db.php';
            $stmt = $db->prepare('SELECT * FROM product');
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) :
            ?>
                <div class="col-sm-6 col-md-4 col-lg-4 mb-2">
                    <div class="card-deck">
                        <div class="card p-2 border-secondary mb-2">
                            <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
                            <div class="card-body p-1">
                                <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4>
                                <h5 class="card-text text-center text-danger"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'], 2) ?>/-</h5>

                            </div>
                            <div class="card-footer p-1">
                                <form action="" class="form-submit">
                                    <div class="row p-2">
                                        <div class="col-md-6 py-1 pl-4">
                                            <b>Quantity :<h6>Enter Value Inside</h6></b>

                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control pqty" value="<?= $row['product_qty'] ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                    <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                                    <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                    <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                                    <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                                    <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                                        cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>


    <script type="text/javascript">
        $(document).ready(function() {

            // Send product details in the server
            $(".addItemBtn").click(function(e) {
                e.preventDefault();
                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();

                var pqty = $form.find(".pqty").val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {
                        pid: pid,
                        pname: pname,
                        pprice: pprice,
                        pqty: pqty,
                        pimage: pimage,
                        pcode: pcode
                    },
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                        load_cart_item_number();
                    }
                });
            });

            // Load total no.of items added in the cart and display in the navbar
            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        cartItem: "cart_item"
                    },
                    success: function(response) {
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>





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

    <!--footer sec ends -->



</body>

</html>