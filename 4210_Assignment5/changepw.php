<?php
    require __DIR__.'/db.authenticate.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jquery JS-->
    <script src="https://cdn.jsdelivr.net/npm/@webcreate/infinite-ajax-scroll/dist/infinite-ajax-scroll.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<meta charset="utf-8">
	<meta name="description" content="Login for edition">
	<title>Change Password Page</title>
	<link rel="icon" type="image/x-icon" href="Images/file-lock.svg" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">IERG 4210 MEME SHOP</a>
		</div>
</nav>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="Images/200w.gif" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Change Password</h1>
							<form id="login" method="POST" action="admin-process.php?action=changepw" enctype="multipart/form-data">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" placeholder="example@gmail.com" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
									
										<label class="text-muted" for="password">Current Password</label>
										
									
									<input id="password" type="password" placeholder="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Current Password is required
							    	</div>
								</div>

                                <div class="mb-3">
									
										<label class="text-muted" for="password">New Password</label>
										
									
									<input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password" required>
								    <div class="invalid-feedback">
								    	New Password is required
							    	</div>
								</div>
								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
                                        Change PW
									</button>
								</div>
								<input type="hidden" name="nonce" value="<?php echo csrf_getNonce('changepw'); ?>"/>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Don't have an account? <a href="register.php" class="text-dark">Create One</a>
							</div>
						</div>
					</div>
					    <footer class="py-2 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; TanTan MEME Online Shop Website 2022
            </p>
        </div>
    </footer>
				</div>
			</div>
		</div>
	</section>

	<script src="/Admin_Panel/js/login.js"></script>
</body>
</html>