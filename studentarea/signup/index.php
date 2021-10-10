
<!doctype html>
<html class="no-js" lang="English" prefix="og: https://ogp.me/ns#">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>IntRevise - Sign Up</title>
	<meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
	<meta property="og:image" content="https://intrevise.axtonprice.com/assets/img/embed-logo.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta property='og:type' content='article' />
	<meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

	<link rel="manifest" href="site.webmanifest">
	<link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">

	<!-- CSS here -->
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="../../assets/css/magnific-popup.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
	<link rel="stylesheet" href="../../assets/css/default.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/responsive.css">

	<link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

	<!-- PHP -->
	<?php
	require "../modules/presets.php";
	require "../modules/functions.php";
	?>
</head>

<body>

	<?php require "../../_partials/navbar.php"; ?>

	<div class="banner-question">
		<div class="opacity-overlay " data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="question-title">
							<h3>Create new account</h3>
							<h6>Create a new account, and get started with IntRevise!</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="our-courses pt-60 pb-60">
		<div class="container">

			<?= errorHandler(); ?>

			<div class="login">
				<h1>Sign Up</h1>
				<br>

				<form action="authenticate" method="post">

					<label for="username">
						<i class="fas fa-user"></i>
					</label>
					<input class="form-input" type="text" name="username" placeholder="Username" id="username" required>
					<br><br>

					<label for="firstname">
						<i class="fas fa-user"></i>
					</label>
					<input class="form-input" type="text" name="firstname" placeholder="First Name" id="firstname" required>
					<br><br>

					<label for="lastname">
						<i class="fas fa-user"></i>
					</label>
					<input class="form-input" type="text" name="lastname" placeholder="Last Name" id="lastname" required>
					<br><br>

					<label for="yeargroup">
						<i class="fas fa-clock"></i>
					</label>
					<input class="form-input" type="number" min="9" max="11" name="yeargroup" placeholder="Yeargroup (9, 10, 11)" id="yeargroup">
					<br><br>

					<label for="email">
						<i class="fas fa-envelope"></i>
					</label>
					<input class="form-input" type="email" name="email" placeholder="Email" id="email" required>
					<br><br>

					<label for="password">
						<i class="fas fa-lock"></i>
					</label>
					<input class="form-input" type="password" name="password" placeholder="Password" id="password" required>
					<br><br>

					<input type="submit" value="Sign Up" style="color: white" class="btn btn-primary btn-round btn-simple"></a>
				</form>
				<br>
				<a href="../login"><i class="fas fa-angle-left"></i> Back to login</a>

			</div>
		</div>
	</section>
</body>

</html>