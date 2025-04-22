<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PT. Qtasnim Digital Teknologi</title>

	<!-- Icons -->
	<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
	<link rel="shortcut icon" href="<?= base_url() ?>assets/images/qtasnim.jpg">
	<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/images/qtasnim.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/images/qtasnim.jpg">
	<!-- END Icons -->



	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/vendors_css.css">

	<!-- Style-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/skin_color.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

	<?= $this->renderSection('style') ?>
	<style>
		@keyframes blink {

			0%,
			100% {
				background-color: #ffffff;
				color: #000;
			}

			50% {
				background-color: #ff0000;
				color: #fff;
			}
		}

		.blinking-bg {
			animation: blink 0.5s infinite;
			z-index: 1;
		}

		.toast {
			position: fixed;
			top: 20px;
			/* Adjust this value to move the toast down or up */
			left: 50%;
			transform: translateX(-50%);
			z-index: 1050;
			/* Ensure it's above other elements */
			width: fit-content;
		}
		
	</style>
	
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

	<div class="wrapper">
		<div class="toast-container position-fixed bottom-0 end-0 p-3">
			<div id="updateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="me-auto">Notification</strong>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body">
					<!-- Pesan akan diisi melalui JavaScript -->
				</div>
			</div>
		</div>

		<div class="toast" id="submitToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
			<div class="toast-header">
				<strong class="me-auto">Notifications</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
				Data submitted successfully!
			</div>
		</div>
		<?= $this->include('template/header') ?>
		<?= $this->include('template/navbar') ?>
		<?= $this->renderSection('content') ?>

		<!-- Control Sidebar -->
		<aside class="control-sidebar">

			<div class="rpanel-title"><span class="pull-right btn btn-circle btn-danger"><i class="ion ion-close text-white" data-toggle="control-sidebar"></i></span> </div> <!-- Create the tabs -->
			<ul class="nav nav-tabs control-sidebar-tabs">
				<li class="nav-item"><a href="#control-sidebar-home-tab" data-bs-toggle="tab" class="active"><i class="mdi mdi-message-text"></i></a></li>
				<li class="nav-item"><a href="#control-sidebar-settings-tab" data-bs-toggle="tab"><i class="mdi mdi-playlist-check"></i></a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- /.tab-pane -->
			</div>
		</aside>
		<!-- /.control-sidebar -->

		<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>

	</div>
	<!-- ./wrapper -->

	<!-- ./side demo panel -->
	<!-- <div class="sticky-toolbar">
		<a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="Buy Now" class="waves-effect waves-light btn btn-success btn-flat mb-5 btn-sm" target="_blank">
			<span class="icon-Money"><span class="path1"></span><span class="path2"></span></span>
		</a>
		<a href="https://themeforest.net/user/multipurposethemes/portfolio" data-bs-toggle="tooltip" data-bs-placement="left" title="Portfolio" class="waves-effect waves-light btn btn-danger btn-flat mb-5 btn-sm" target="_blank">
			<span class="icon-Image"></span>
		</a>
		<a id="chat-popup" href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="Live Chat" class="waves-effect waves-light btn btn-warning btn-flat btn-sm">
			<span class="icon-Group-chat"><span class="path1"></span><span class="path2"></span></span>
		</a>
	</div> -->
	<!-- Sidebar -->



	<!-- Vendor JS -->
	<script src="<?= base_url() ?>assets/template/main/js/vendors.min.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/scan-qr.min.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/chat-popup.js"></script>
	<script src="<?= base_url() ?>assets/template/assets/icons/feather-icons/feather.min.js"></script>

	<script src="<?= base_url() ?>assets/template/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
	<script src="<?= base_url() ?>assets/template/assets/vendor_components/moment/min/moment.min.js"></script>
	<script src="<?= base_url() ?>assets/template/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
	<script src="<?= base_url() ?>assets/template/assets/vendor_components/select2/dist/js/select2.full.js"></script>

	<!-- EduAdmin App -->
	<script src="<?= base_url() ?>assets/template/main/js/template.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/dashboard.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/calendar.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/data-table.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/advanced-form-element.js"></script>
	<script src="<?= base_url() ?>assets/template/main/js/pages/advanced-form-element.js"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

	<!-- <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script> -->
	<?= $this->renderSection('script') ?>


</body>

</html>