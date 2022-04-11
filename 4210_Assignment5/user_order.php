<?php
require __DIR__.'/lib/db.inc.php';
include_once('auth.php');
include_once('db.authenticate.php');
$res = ierg4210_cat_fetchall();
$prod = ierg4210_prod_fetchall();
$prods = ierg4210_prod_fetchall();
$prodoptions = '';
$options = '';
include_once('records.php');
foreach ($prod as $value){
    $prodoptions .= '<option value="'.$value["PID"].'"> '.$value["NAME"].' </option>';
}
foreach ($res as $value){
    $options .= '<option value="'.$value["CATID"].'"> '.$value["NAME"].' </option>';
}

if(auth() == false ) {
    header('Location: index.php');
    exit();
} 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jquery JS-->
    <script src="https://cdn.jsdelivr.net/npm/@webcreate/infinite-ajax-scroll/dist/infinite-ajax-scroll.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="utf-8" />
    <meta name="Online Shop" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="4210 assignment 3" content="" />
    <meta name="Yeung Tang 1155144676" content="" />
    <title>meme shop admin panel</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/Images/terminal.svg" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="Admin_Panel/css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/index.php">IERG 4210 MEME SHOP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                    <li class="nav-item">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-btn burger" href="#!">nav-bar</a>
                        <div class="dropdown-list">
                            <div class="dropdown">
                                <a href="index.php" class="dropdown-btn">Main Page</a>
                            </div>
    
                            <?php
                              foreach($res as $cat_ele){
                                $big_catid = $cat_ele['CATID'];
                                $cat_name = $cat_ele['NAME'];
                    
                            echo'
                            <div class="dropdown">
                                <a href="/index.php?catid='.$big_catid.'" class="dropdown-btn">'.$cat_name.'</a>
                                <div class="dropdown-list dropdown-inner">
                                ';

                                foreach($prods as $prod_element){
                                    $pid =  $prod_element['PID'];
                                    $catid = $prod_element['CATID'];
                                    $name = $prod_element['NAME'];

                                    if($big_catid == $catid){
                                echo'
                                    <a href="/product.php?catid='.$catid.'&pid='.$pid.'">'.$name.'</a>
                                  
                                    ';
                                    }
                                }

                            echo'
                            </div>
                            </div>';
                          
                              }

                              ?>

                        </div>
                    </li>
                    </a>
                    </li>

                </ul>
<!--             
                
                <form class="d-flex">
                    <div class="dropdown">
                    <a id="cart-popover" class="btn btn-outline-dark" data-placement="bottom" title="Shopping Cart"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill" id="cartValue">0</span>
                            <span class="total_price" id="cartValue">$0</span>
                            </a>
                        <div class="dropdown-menu" aria-labelledby="navbar-cart">
                          
                                <section class="container content-section">


                               

                            
				                <span id="cart_details"></span>
                




                                <a href="#" class="btn btn-success" id="check_out_cart">
                                <span class="bi bi-basket2"> Check Out</span> 
                                </a>
                                <a href="#" class="btn btn-dark" id="clear_cart">
                                <span class="bi bi-cart-x-fill"> Clear</span> 
                                </a>
                          
                        </div>



                                </section> -->


                           
    <form class="form-inline my-2 my-lg-0 pr-3" id="logout" method="POST" action="admin-process.php?action=logout" enctype="multipart/form-data">
    <button class="btn btn-success bi bi-box-arrow-right" type="submit" value="Submit"> Logout</button>
    </form>
            </div>
        </div>
    </nav>
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">IERG4210 All User Shop Records </h1>

            </div>
        </div>
    </header>


    <!-- Section-->
    <section class="py-5">
        

    <div class="container-fluid px-5">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order Records</h5>
                    <div class="table-responsive" id="order_table">
                        <table class="table table-bordered table-striped">
                            <tr>  
                                <th width="5%">Order ID</th>   
                                <th width="20%">Product List</th>
                                <th width="10%">Product Quantity</th>
                                <th width="25%">Order Time</th>
                            </tr>
                            <?php echo order_records(); ?>
                        </table>
                    </div>
                </div>
            </div>





    </section>



    <!-- Footer-->
    <footer class="py-2 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; TanTan MEME Online Shop Website 2022
            </p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="/js/scripts.js" async></script>
</body>



</html>