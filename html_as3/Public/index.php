<?php
require __DIR__.'/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$prods = ierg4210_prod_fetchall();
$pid = $_GET['pid'];
$prodoptions = '';
$options = '';
foreach ($prod as $value){
    $prodoptions .= '<option value="'.$value["PID"].'"> '.$value["NAME"].' </option>';
}
foreach ($res as $value){
    $options .= '<option value="'.$value["CATID"].'"> '.$value["NAME"].' </option>';
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
    <title>Gamer Girl's Secret Online Shop</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="Images/icon.webp" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">IERG 4210 MEME SHOP</a>


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
                                <a href="index.php?catid='.$big_catid.'" class="dropdown-btn">'.$cat_name.'</a>
                                <div class="dropdown-list dropdown-inner">
                                ';

                                foreach($prods as $prod_element){
                                    $pid =  $prod_element['PID'];
                                    $catid = $prod_element['CATID'];
                                    $name = $prod_element['NAME'];
                                    if($big_catid == $catid){
                                echo'
                                    <a href="product.php?catid='.$catid.'&pid='.$pid.'">'.$name.'</a>
                                  
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


                               

                            <!-- <div id="popover_content_wrapper" style="display: none"> -->
                            
				                <span id="cart_details"></span>
                




                                <a href="#" class="btn btn-success" id="check_out_cart">
                                <span class="bi bi-basket2"> Check Out</span> 
                                </a>
                                <a href="#" class="btn btn-dark" id="clear_cart">
                                <span class="bi bi-cart-x-fill"> Clear</span> 
                                </a>
                          
                        </div>



                                </section>
                          
                          
                            <!-- <ul class="dropdown-item"><button class="btn btn-outline-dark mt-auto buy"
                                    type="button">PURCHASE</button>
                            <button class="btn btn-outline-dark mt-auto clear"
                                    type="button">CLEAR ALL</button></ul> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">IERG 4210 GGSOS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">  
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-btn burger" href="#!">Home</a>
                            <div class="dropdown-list">
                                <div class="dropdown">
                                <a href="#" class="dropdown-btn">Virtual Products <i class="fas fa-caret-right"></i></a>
                                <div class="dropdown-list dropdown-inner">
                                  <a href="#">Simp a Flower!</a>
                                  <a href="#">SIMP card</a>                                                 
                                  </div>
                              </div>
                              <div class="dropdown">
                                  <a href="#" class="dropdown-btn"
                                    >Secret Special<i class="fas fa-caret-right"></i
                                  ></a>
                                  <div class="dropdown-list dropdown-inner">
                                    <a href="#">Panties</a>
                                    <a href="#">Bath Water</a>                                                 
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>                
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav> -->
    <!-- Header-->
    <header class="bg-dark py-5">




        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Support & Donate <3</h1>
                        <p class="lead fw-normal text-white-50 mb-0">SIMP everyday~</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
      <?php
                $switch_catid = $_GET['catid'];
                $flag = 0;
                if($switch_catid == null || $switch_catid == 0){
                    $flag = 1;
                }
                    echo'
                    <input hidden type="text" name="quantity" id="666GGG" class="form-control" value="1" />
                    <div class="card-container container px-4 px-lg-5 mt-5">
                    <div class="item row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    ';
                
                foreach($prods as $prod_element){
                $pid =  $prod_element['PID'];
                $catid = $prod_element['CATID'];
                $name = $prod_element['NAME'];
                $price = $prod_element['PRICE'];
                if($switch_catid == null){
                echo '<div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->

                         <a href="product.php?catid='.$catid.'&pid='.$pid.'">
                            <img class="card-img-top" src="Images/'.$pid.'.jpg" alt="..." />
                        </a>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <a href="product.php?catid='.$catid.'&pid='.$pid.'">
                                    <h5 class="fw-bolder">'.$name.'</h5>
                                </a>
                                <!-- Product price-->
                                $'.$price.'
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent abc">
                        
                        <input hidden type="text" name="quantity" id="quantity'.$pid.'" class="form-control" value="1" />
                        <input hidden type="text" name="name" id="name'.$pid.'" class="form-control" value = "'.$name.'"/>
                        <input hidden type="text" name="price" id="price'.$pid.'" class="form-control" value = "'.$price.'" />
                        
                        <div class="text-center"><input type="button" name="add_to_cart" id="'.$pid.'"  class="btn btn-success form-control add_to_cart" value="Add to Cart" />

                            </div>
                        </div>
                    </div>
                </div>';
                
                }else if($switch_catid == $catid){
                    echo '<div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <a href="product.php?catid = '.$catid.'&pid='.$pid.'">
                            <img class="card-img-top" src="Images/'.$pid.'.jpg" alt="..." />
                        </a>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <a href="flower.html" class="image" title="flower">
                                    <h5 class="fw-bolder">'.$name.'</h5>
                                </a>
                                <!-- Product price-->
                                $'.$price.'
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent abc">
                        
                        <input hidden type="text" name="quantity" id="quantity'.$pid.'" class="form-control" value="1" />
                        <input hidden type="text" name="name" id="name'.$pid.'" class="form-control" value = "'.$name.'"/>
                        <input hidden type="text" name="price" id="price'.$pid.'" class="form-control" value = "'.$price.'" />
                        
                        <div class="text-center"><input type="button" name="add_to_cart" id="'.$pid.'"  class="btn btn-success form-control add_to_cart" value="Add to Cart" />

                            </div>
                        </div>
                    </div>
                </div>';
                }
                }
                if($flag == 1){
                    echo '
                    </div>
                    <div class="pagination">
                        <a href="index.php" class="next">Next</a>
                    </div>
                    ';
                }else{
                    $switch_catid = $_GET['catid'];
                    echo '
                    </div>
                    <div class="pagination">
                        <a href="index.php?catid='.$switch_catid.'" class="next">Next</a>
                    </div>
                    ';
                }


            ?>

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
    <script src="js/scripts.js" async></script>
</body>

</html>