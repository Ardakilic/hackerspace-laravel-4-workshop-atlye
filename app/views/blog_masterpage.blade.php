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
</head>

<body>

@include('template.ustmenu')

<div class="container" id="main-container">
<div class="row">
<div class="col-lg-8">

    {{-- başarılı başarısız mesajları --}}
    @include('template.mesajlar')
    {{-- başarılı baarısız mesajları --}}


    @yield('content')
</div>
<div class="col-lg-4">
    @include('template.blog_sagmenu')
</div>
</div>
<hr>
@include('template.footer')
</div>
{{-- Assetleri laravel tarzı yazıyoruz --}}
{{-- <script src="assets/js/jquery.min.js"></script> --}}
{{-- <script src="assets/js/bootstrap.min.js"></script> --}}

{{ HTML::script('assets/js/jquery.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
</body>

</html>