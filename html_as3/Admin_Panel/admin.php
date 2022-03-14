<?php
require __DIR__.'/lib/db.inc.php';
$res = ierg4210_cat_fetchall();
$prod = ierg4210_prod_fetchall();
$prods = ierg4210_prod_fetchall();
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
            <a class="navbar-brand" href="../Public/index.php">IERG 4210 MEME SHOP</a>
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
                                <a href="../Public/index.php" class="dropdown-btn">Main Page</a>
                            </div>
    
                            <?php
                              foreach($res as $cat_ele){
                                $big_catid = $cat_ele['CATID'];
                                $cat_name = $cat_ele['NAME'];
                    
                            echo'
                            <div class="dropdown">
                                <a href="../Public/index.php?catid='.$big_catid.'" class="dropdown-btn">'.$cat_name.'</a>
                                <div class="dropdown-list dropdown-inner">
                                ';

                                foreach($prods as $prod_element){
                                    $pid =  $prod_element['PID'];
                                    $catid = $prod_element['CATID'];
                                    $name = $prod_element['NAME'];
                                    if($big_catid == $catid){
                                echo'
                                    <a href="../Public/product.php?catid='.$catid.'&pid='.$pid.'">'.$name.'</a>
                                  
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
            </div>
        </div>
    </nav>
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">IERG4210 Shop Admin Panel<3</h1>

            </div>
        </div>
    </header>


    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <fieldset>
                            <legend>Add New Category</legend>
                            <form id="cat_insert" method="POST" action="admin-process.php?action=cat_insert"
                                enctype="multipart/form-data">
                                <label for="cat_name"> Name *</label>
                                <div> <input class="form-control" id="cat_name" type="text" name="name" required="required"
                                        pattern="^[\w\-]+$" /></div>
                                <button class="btn btn-secondary" type="submit">Add</button>
                            </form>
                        </fieldset>
                    </div>
                </div>

                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <fieldset>
                            <legend>Edit Category</legend>
                            <form id="cat_edit" method="POST" action="admin-process.php?action=cat_edit"
                                enctype="multipart/form-data">
                                <label for="prod_catid"> Category *</label>
                                <div> <select id="prod_catid" name="catid"><?php echo $options; ?></select></div>
                                <label for="prod_name"> Name *</label>
                                <div> <input class="form-control" id="cat_name" type="text" name="name" required="required"
                                        pattern="^[\w\-]+$" /></div>
                                        <button class="btn btn-secondary" type="submit">Edit</button>
                            </form>
                        </fieldset>
                    </div>
                </div>


                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->

                        <fieldset>
                            <legend>Delete Category</legend>
                            <form id="cat_delete" method="POST" action="admin-process.php?action=cat_delete"
                                enctype="multipart/form-data">
                                <label for="prod_catid"> Category *</label>
                                <div> <select id="prod_catid" name="catid"><?php echo $options; ?></select></div>
                                <button class="btn btn-secondary" type="submit">Delete</button>
                            </form>
                        </fieldset>
                    </div>
                </div>


            </div>
    </section>


    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <fieldset>
                            <legend>ADD New Product</legend>
                            <form id="prod_insert" method="POST" action="admin-process.php?action=prod_insert"
                                enctype="multipart/form-data">
                                <label for="prod_catid"> Category *</label>
                                <div> <select id="prod_catid" name="catid"><?php echo $options; ?></select></div>
                                <label for="prod_name"> Name *</label>
                                <div> <input class="form-control" id="prod_name" type="text" name="name" required="required"
                                        pattern="^[\w\-]+$" /></div>
                                       
                                <label for="prod_price"> Price *</label>
                                <div> <input class="form-control" id="prod_price" type="text" name="price" required="required"
                                        pattern="^\d+\.?\d*$" /></div>
                                <label for="prod_price"> Quantities *</label>
                                <div> <input class="form-control" id="prod_quantities" type="text" name="quantities" required="required"
                                        pattern="^\d+\.?\d*$" /></div>
                                <label for="prod_desc"> Description *</label>
                                <div> <textarea id="prod_desc" type="text" name="description" > </textarea></div>
                                <label for="prod_image"> Image *</label>




                                <div class="image-preview" id="imagePreview"> 
                                    <input class="input" type="file" name="file" id="file" required="true" accept="image/jpeg" />
                                    <img src="" alt="Image Preview" class="image-preview__image">
                                    <span class="image-preview__default-text">Or Drop to the dotted box above!</span> 
                                </div>
                                <button class="btn btn-secondary" type="submit">Add</button>

              
                            </form>
                        </fieldset>
                    </div>
                </div>


                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <fieldset>
                            <legend>Edit Product</legend>
                            <form id="prod_edit" method="POST" action="admin-process.php?action=prod_edit"
                                enctype="multipart/form-data">
                                <label for="prod_catid"> Product *</label>
                                <div> <select id="prod_catid" name="pid"><?php echo $prodoptions; ?></select></div>
                                <label for="prod_name"> Name *</label>
                                <div> <input class="form-control" id="prod_name" type="text" name="name" required="required"
                                        pattern="^[\w\-]+$" /></div>
                                <label for="prod_price"> Price *</label>
                                <div> <input class="form-control" id="prod_price" type="text" name="price" required="required"
                                        pattern="^\d+\.?\d*$" /></div>
                                <label for="prod_price"> Quantities *</label>
                                <div> <input class="form-control" id="prod_quantities" type="text" name="quantities" required="required"
                                        pattern="^\d+\.?\d*$" /></div>
                                <label for="prod_desc"> Description *</label>
                                <div> <textarea id="prod_desc" type="text" name="description" > </textarea></div>
                                <button class="btn btn-secondary" type="submit">Edit</button>
                            </form>
                        </fieldset>
                    </div>
                </div>



                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <fieldset>
                            <legend>Delete Product</legend>
                            <form id="prod_delete" method="POST" action="admin-process.php?action=prod_delete"
                                enctype="multipart/form-data">
                                <label for="prod_pid"> Product *</label>
                                <div> <select id="prod_pid" name="pid"><?php echo $prodoptions; ?></select></div>
                                <button class="btn btn-secondary" type="submit">Delete</button>
                            </form>
                        </fieldset>
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
    <script src="../Admin_Panel/js/scripts.js" async></script>
</body>



</html>