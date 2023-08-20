<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>
		@yield('title') - magang-inventory
		
	</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="/global_assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="/assets/js/app.js"></script>

	<script type="text/javascript">
		$(document).on('show.bs.modal', '.modal', function () {
		    var zIndex = 1040 + (10 * $('.modal:visible').length);
		    $(this).css('z-index', zIndex);
		    setTimeout(function() {
		        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
		    }, 0);
		});
		$(document).ready(function() {
			var year = (new Date()).getFullYear();
			$('#year').html(year);
		});

	</script>
	@yield('head')
	@yield('head2')
	<!-- /theme JS files -->
</head>

<body>
	
	<!-- Main navbar -->
	<div class="navbarnavbar-light navbar-static">

		

		

	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<div class="">

			<!-- Sidebar mobile toggler -->
			
			<!-- /sidebar content -->

		</div>
		<!-- /main sidebar -->
		


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header border-bottom-0">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><span class="font-weight-semibold">@yield('page_header')</span></h4>
					</div>
				</div>
				@if(null !== Session::get('successMessage'))
				<div class="page-header-content">
					<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						{{Session::get('successMessage')}}
					</div>
				</div>
				@endif
				@if(null !== Session::get('errorMessage'))
				<div class="page-header-content">
					<div class="alert alert-danger alert-styled-left alert-dismissible">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						{{Session::get('errorMessage')}}
					</div>
				</div>
				@endif
			</div>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content pt-0">
				@yield('content')
			</div>
			<!-- /content area -->


			<!-- Footer -->
			{{-- <div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; <span id="year"></span>. <a href="#">oxbridgewhiteboard.com</a> by <a href="#">Oxbridge Technology</a>
					</span>
				</div>
			</div> --}}
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- modal loading -->
	<div id="modal-loading" class="modal" tabindex='-1'>
		<div class="pace-demo bg-dark h-100 w-100">
			<div class="theme_tail theme_tail_circle">
				<div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
				<div class="pace_activity"></div>
			</div>
		</div>
	</div>
	<!-- /modal loading -->
</body>
</html>
