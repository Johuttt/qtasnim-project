<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?= base_url() ?>assets/images/qtasnim.jpg">

	<title>PT. Qtasnim Digital Teknologi</title>

	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/vendors_css.css">

	<!-- Style-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/skin_color.css">

	<style>
		.toast-container {
			position: fixed;
			top: 20px;
			left: 50%;
			transform: translateX(-50%);
			z-index: 1050;
		}

		.toast-body{
			color: red;
		}
	</style>
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(<?= base_url() ?>assets/images/download1.jpeg)">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<img src="<?= base_url() ?>assets/images/logo-bulat.jpg" alt="">
							</div>
							<div class="p-40">
								<form action="<?= base_url() ?>login" method="post">
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" class="form-control ps-15 bg-transparent" name="username" placeholder="Username">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" class="form-control ps-15 bg-transparent" name="password" placeholder="Password">
										</div>
									</div>
									<div class="row">
										<div class="col-12 text-end">
											<!-- <a href="<?= base_url() ?>login/forgot_password" class="text-decoration-underline">Lupa Password?</a> -->
										</div>
										<!-- /.col -->
									</div>
									<div class="row">
										<div class="col-12 text-center">
											<button type="submit" class="btn btn-primary mt-10">LOGIN</button>
										</div>
										<!-- /.col -->
									</div>
									<div class="row">
										<div class="col-12 text-center">
											<p class="mt-10 mb-0">Belum punya akun? <a href="<?= base_url() ?>register" class="text-primary text-decoration-underline">Register</a></p>
										</div>
										<!-- /.col -->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Toast Notification -->
	<div class="toast-container">
		<div class="toast" id="submitToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
			<div class="toast-header">
				<strong class="me-auto">Notifications</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body" style="font-size: medium;">
				<?= session()->getFlashdata('gagal')?>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', (event) => {
			var submitToast = document.getElementById('submitToast');
			if (submitToast && submitToast.querySelector('.toast-body').innerHTML.trim() !== '') {
				var toast = new bootstrap.Toast(submitToast);
				toast.show();
			}
		});
	</script>

	<!-- Vendor JS -->
	<script src="<?= base_url() ?>assets/template/main/js/vendors.min.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/chat-popup.js"></script>
	<script src="<?= base_url() ?>assets/template/assets/icons/feather-icons/feather.min.js"></script>

</body>

</html>