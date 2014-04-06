@extends('blog_masterpage')

@section('content')

{{ Form::open(array('route' => array('blog_duzenle_post', $blog->id), 'role' => 'form', 'files' => true)) }}
<h2>
    {{$title}}
</h2>

@if($errors->count() > 0)
<div class="alert alert-danger">
    <ul style="list-style: disc">
        @foreach($errors->all() as $mesaj)
        <li>{{$mesaj}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group col-md-11">
    {{ Form::label('baslik', 'Başlık:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::text('baslik', Input::old('baslik', $blog->baslik), array('placeholder' => 'Blog metni başlığnı girin', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group col-md-11">

    {{ Form::label('metin', 'Metin:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::textarea('metin', Input::old('metin', $blog->metin), array('class' => 'form-control', 'cols' => '4', 'placeholder' => 'Yazı metnini buraya girin')) }}
    </div>
</div>

<div class="form-group col-md-11">
    <label for="resim" class="col-md-4">
        Resim:
    </label>
    <div class="col-md-7">
        {{ Form::file('resim') }}
        <p class="help-block">Dosyanızı buradan seçebilirsiniz.</p>
    </div>
</div>


<div class="form-group col-md-11">
    <label for="resim" class="col-md-4">
        Mevcut Resim:
    </label>
    <div class="col-md-7">
        <img src="{{ Croppa::url(Config::get('blog.resim_klasor_frontend').$blog->resim, Config::get('blog.ansayfa_genislik'), Config::get('blog.anasayfa_yukseklik')) }}" alt="{{ $blog->baslik }}" class="img-responsive img">
    </div>
</div>



<div class="form-group col-md-11">
    {{ Form::label('etiketler', 'Etiketler:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">

        <?php
            $i = 0;
            $etiket = '';
            foreach($blog->tags as $HerBirEtiket) {
                if($i > 0) { $etiket .= ', '; }
                $etiket .= $HerBirEtiket->tag;
                $i++;
            }
        ?>

        {{ Form::text('etiketler', Input::old('etiketler', $etiket), array('placeholder' => 'Her bir etiketi arasında virgül ile ayırmayı unutmayın!', 'class' => 'form-control')) }}
    </div>
</div>

{{ Form::submit('Gönder', array('class' => 'btn btn-default')) }}

{{ Form::close() }}

@stop