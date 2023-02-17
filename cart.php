<?php
session_start();
error_reporting(0);


require('db.php');
if(!isset($_SESSION['isUserLoggedIn'])){
    echo "<script>window.location.href='login.php?user_not_loggedin';</script>";

}
if($_SESSION['role']!='customer'){
    echo "<script>window.location.href='login.php?user_not_loggedin';</script>";
}

if(isset($_POST['submit'])){
    
$query="INSERT INTO order_detail (fullname, number, email, senderadress, parceldesc, recieveradress)";
$query.=" VALUES ('{$_POST['fullname']}','{$_POST['number']}','{$_POST['email']}','{$_POST['senderadress']}','{$_POST['parceldesc']}','{$_POST['recieveradress']}')";

$run = mysqli_query($db,$query);
    $data = mysqli_fetch_array($run);
    if(count($data)>0){
        echo "<script>window.location.href='checkout.php?checkout_now';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>


    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--  Bootstrap CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <!--  Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- AJAX LIBRARIES -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />

    <link rel="stylesheet" href="css/pakage.css">
    <link rel="stylesheet" href="css/style.css">



    <style>
        body {

            background-color: aliceblue;
            background-size: cover;
        }
    </style>


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
                        <a class="nav-link active" aria-current="page" href="logout.php" style="color:black;">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="port.html" style="color:black;">Portfolio's</a>
                    </li>
                    

                    
                </ul>
            </div>
        </div>

    </nav>


    <br>


    <div class="headline text-center mb-5">
        <h2 class="pb-3 position-relative d-inline-block" style="color: rgb(0, 0, 0)">"My- Cart Items"</h2>

    </div>


    <!-- Displaying Products Start -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="display:<?php if (isset($_SESSION['showAlert'])) {
                                        echo $_SESSION['showAlert'];
                                    } else {
                                        echo 'none';
                                    }
                                    unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><?php if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                            }
                            unset($_SESSION['showAlert']); ?></strong>

                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    <h4 class="text-center text-info m-0">Products in your cart!</h4>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>
                                    <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require 'db.php';
                            $stmt = $db->prepare('SELECT * FROM cart');
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $grand_total = 0;
                            while ($row = $result->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                    <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                                    <td><?= $row['product_name'] ?></td>
                                    <td>
                                        <i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'], 2); ?>
                                    </td>
                                    <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                    <td>
                                        <input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;">
                                    </td>
                                    <td><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= number_format($row['total_price'], 2); ?></td>
                                    <td>
                                        <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php $grand_total += $row['total_price']; ?>
                            <?php endwhile; ?>
                            <tr>
                                <td colspan="3">
                                    <a href="customer.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                                        Shopping</a>
                                </td>
                                <td colspan="2"><b>Grand Total</b></td>
                                <td><b><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= number_format($grand_total, 2); ?></b></td>
                                <td>
                                    <a href="checkout.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Change the item quantity
            $(".itemQty").on('change', function() {
                var $el = $(this).closest('tr');

                var pid = $el.find(".pid").val();
                var pprice = $el.find(".pprice").val();
                var qty = $el.find(".itemQty").val();
                location.reload(true);
                $.ajax({
                    url: 'db.php',
                    method: 'post',
                    cache: false,
                    data: {
                        qty: qty,
                        pid: pid,
                        pprice: pprice
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });

            // Load total no.of items added in the cart and display in the navbar
            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'db.php',
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
              <li><a href="#" class="py-2 d-block" data-mdb-toggle="modal"
                  data-mdb-target="#sModal">SUGGESTION</a></li>
              <li><a href="#" class="py-2 d-block" data-mdb-toggle="modal"
                  data-mdb-target="#fsModal">FEEDBACK</a></li>
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
                <li><a href="contact.html"><span class="icon icon-envelope"> </span><span
                      class="envelop-text">freshmarket.com</span></a></li>
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
          freshmarket.com All rights reserved | Designed and Developed By <a href="index.html"
            style="color: white" target="_blank">Reshab Raj Anand</a>
        </p>
      </div>
    </div>
  </footer>


    <!--footer sec ends -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>



</body>
</html>