@extends('blog_masterpage')

@section('content')
<!-- Blog yazısı container başla -->
<div class="row">
    <h2>
        {{$title}}
    </h2>
</div>


    @foreach($data as $blog)
    <div class="row">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h3>
                        <strong> {{ HTML::linkRoute('blog_detay', $blog->baslik, $blog->slug) }} </strong>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <a href="#">
                        <img src="{{ Croppa::url(Config::get('blog.resim_klasor_frontend').$blog->resim, Config::get('blog.ansayfa_genislik'), Config::get('blog.anasayfa_yukseklik')) }}" alt="{{ $blog->baslik }}" class="img-responsive img-circle">

                    </a>
                </div>
                <div class="col-md-12" style="float:none;/*bootstrap 3.03 fiksi*/">
                    <p>
                        {{ Str::words(nl2br(e($blog->metin)), 40) }}
                    </p>
                    <p>
                        {{ HTML::linkRoute('blog_detay', 'Devamı', $blog->slug, array('class' => 'btn btn-default')) }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>
                    </p>
                    <p>
                        <i class="glyphicon glyphicon-user"></i>
                        <a href="{{ URL::route('blog_kullanici_yazilari', $blog->users->id) }}">{{ $blog->users->first_name }}</a>
                        |
                        <i class="glyphicon glyphicon-calendar glyphicon-noescape"></i>
                        &nbsp;{{ $blog->created_at->toFormattedDateString() }} |
                        <i class="glyphicon glyphicon-tags"></i>
                        &nbsp;Etiketler :

                        @foreach($blog->tags as $etiket)
                            <a href="{{ URL::route('blog_etiket', $etiket->slug) }}"><span class="label label-info">{{ $etiket->tag }}</span></a>
                        @endforeach

                    </p>
                </div>
            </div>

            {{-- Eğer adminse edit ve delete butonları --}}
            @if(Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                <div class="row">
                    <h4>Yöneticiye Özel</h4>
                    <a href="{{ URL::route('blog_duzenle', array($blog->id)) }}">
                        <button class="btn btn-default">Düzenle</button>
                    </a>
                    <a href="{{ URL::route('blog_sil', array($blog->id)) }}" onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
                        <button class="btn btn-default">Sil</button>
                    </a>
                </div>
            @endif
            {{-- Eğer adminse edit ve delete butonları son --}}



        </div>
    </div>

    <hr>
    @endforeach


    @if(Route::currentRouteName() != 'blog_arama')
        {{ $data->links() }}
    @endif

@stop