<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="/backend/themes/atlantis/default/img/icon.ico" type="image/x-icon"/>

<!-- CSS Files -->
<link rel="stylesheet" href="/backend/themes/atlantis/default/css/bootstrap.min.css">
<link rel="stylesheet" href="/backend/themes/atlantis/default/css/atlantis.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Title -->
<title>{{ env('APP_NAME') }} | Login</title>

<style>
    .login-background {
        {{--background: url({{ \App\Settings::loginPageImage()->value }}) no-repeat fixed !important; background-size: contain !important;--}}
    }
</style>

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
