<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{$title or 'Blog'}}</title>

    {{-- assetleri laravel tarzı yazıyoruz --}}
    {{-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link href="assets/css/extra.css" rel="stylesheet"> --}}

    {{HTML::style('assets/css/bootstrap.min.css')}}
    {{HTML::style('assets/css/extra.css')}}

    {{ $header_assets or '' }}
</head>

<body>
@include('template.ustmenu')

{{-- başarılı başarısız mesajları --}}
@include('template.mesajlar')
{{-- başarılı baarısız mesajları --}}

<div class="jumbotron">
    <div class="container">
        <h1>
            Merhaba Laravel!
        </h1>
        <p>
            Bu sayfa yarı statik olup bloga gelen kullanıcıları karşılayacak basit
            bir giriş sayfasıdır.
        </p>
        <p>
        </p>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>
                Neden Laravel?
            </h2>
            <p>
                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus
                ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo
                sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed
                odio dui.
            </p>
            <p>
            </p>
        </div>
        <div class="col-md-4">
            <h2>
                Laravel Atölyesi
            </h2>
            <p>
                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus
                ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo
                sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed
                odio dui.
            </p>
            <p>
            </p>
        </div>
        <div class="col-md-4">
            <h2>
                HackerSpace Istanbul
            </h2>
            <p>
                Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas
                eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus,
                tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum
                massa justo sit amet risus.
            </p>
            <p>
            </p>
        </div>
    </div>
    <hr>

    @include('template.footer')
</div>
<!-- /container -->
{{-- Assetleri laravel tarzı yazıyoruz --}}
{{-- <script src="assets/js/jquery.min.js"></script> --}}
{{-- <script src="assets/js/bootstrap.min.js"></script> --}}

{{ HTML::script('assets/js/jquery.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
</body>

</html>