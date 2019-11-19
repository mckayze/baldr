<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>404</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="https://via.placeholder.com/50" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="/backend/themes/atlantis/default/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['/backend/themes/atlantis/default/css/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/backend/themes/atlantis/default/css/bootstrap.min.css">
    <link rel="stylesheet" href="/backend/themes/atlantis/default/css/atlantis.css">
    <style>
        .page-not-found {
            background: url('https://images.unsplash.com/photo-1448375240586-882707db888b?ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80') !important;
        }
    </style>
</head>
<body class="page-not-found">
<div class="wrapper not-found">
    <h1 class="animated fadeIn">404</h1>
    <div class="desc animated fadeIn"><span>OOPS!</span><br/>Looks like you got lost</div>
    <a href="/admin/dashboard" class="btn btn-primary btn-back-home mt-4 animated fadeInUp">
			<span class="btn-label mr-2">
				<i class="flaticon-home"></i>
			</span>
        Back To Home
    </a>
</div>
<script src="/backend/themes/atlantis/default/js/core/jquery.3.2.1.min.js"></script>
<script src="/backend/themes/atlantis/default/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="/backend/themes/atlantis/default/js/core/popper.min.js"></script>
<script src="/backend/themes/atlantis/default/js/core/bootstrap.min.js"></script>
</body>
</html>