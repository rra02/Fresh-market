<?php



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

require 'db.php';
//error_reporting(0);
$grand_total = 0;
$allItems = '';
$items = [];

$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(', ', $items);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!--  Bootstrap CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <!--  Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- AJAX LIBRARIES -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />

    <link rel="stylesheet" href="css/style.css">
    <!-- icons cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
   

<style>
    body{
      
        background-image: url("./img/ck.jpg");
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">


                <span class="ti-align-justify navbar-toggler-icon"></span>

            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto " style="font-weight: 500">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.html" style="color:black;">Home</a>
                    </li>
                    

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="logout.php" style="color:black;">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i> <span
                                id="cart-item" class="badge badge-danger"></span></a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    <br>


    <div class="headline text-center mb-5">
        <h2 class="pb-3 position-relative d-inline-block" style="color: rgb(0, 0, 0)">"Checkout Now"</h2>

    </div>


    <!-- Displaying items cart -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 pb-4" id="order">
                <h4 class="text-center text-info p-2">Complete your order!</h4>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
                    <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                    <h5><b>Total Amount Payable : </b><?= number_format($grand_total, 2) ?>/-</h5>
                </div>
                <form action="./thanks.html" method="" id="placeOrder">
                    <input type="hidden" name="products" value="<?= $allItems; ?>">
                    <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                    </div>
                    <div class="form-group">
                        <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
                    </div>
                    <h6 class="text-center lead" style="color: black; font-weight:600 " >Select Payment Mode</h6>
                    <div class="form-group">
                        <select name="pmode" class="form-control">
                            <option value="" selected disabled>-Select Payment Mode-</option>
                            <option value="cod">Cash On Delivery</option>
                            <option value="netbanking">Net Banking</option>
                            <option value="cards">Debit/Credit Card</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <a href="./thanks.html" style="text-decoration: none;">
                            <input type="submit"  name="submit" value="Place Order" class="btn btn-danger btn-block"></a>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <script type="text/javascript">
        $(document).ready(function() {

            // Sending Form data to the server
            $("#placeOrder").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: $('form').serialize() + "&action=order",
                    success: function(response) {
                        $("#order").html(response);
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