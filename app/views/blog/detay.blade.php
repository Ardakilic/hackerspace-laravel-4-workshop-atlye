@extends('blog_masterpage')

@section('content')
<!-- Blog yazısı container başla -->


<div class="row">
    <div>
        <div class="row">
            <div class="col-lg-12">
                <h2>
                    {{ $blog->baslik }}
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="#">

                    <img src="{{ Croppa::url(Config::get('blog.resim_klasor_frontend').$blog->resim, Config::get('blog.ansayfa_genislik'), Config::get('blog.anasayfa_yukseklik')) }}" alt="{{ $blog->baslik }}" alt="{{ $blog->baslik }}" class="img-responsive img-circle">

                </a>
            </div>
            <div class="col-md-12" style="float:none/*bootstrap 3.03 fiksi*/">
                <p>
                    {{ nl2br(e($blog->metin)) }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p>
                </p>
                <p>
                    <i class="glyphicon glyphicon-user"></i>
                    <a href="#">{{ $blog->users->first_name }}</a>
                    |
                    <i class="glyphicon glyphicon-calendar glyphicon-noescape"></i>
                    &nbsp;{{ $blog->created_at->toFormattedDateString() }} |
                    <i class="glyphicon glyphicon-tags"></i>
                    &nbsp;Etiketler :

                    @foreach($blog->tags as $etiket)
                    <a href="#"><span class="label label-info">{{ $etiket->tag }}</span></a>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Blog yazısı container bit -->

@stop