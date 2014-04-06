@extends('blog_masterpage')

@section('content')

{{ Form::open(array('route' => 'yeni_blog_post', 'role' => 'form', 'files' => true)) }}
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
        {{ Form::text('baslik', Input::old('baslik'), array('placeholder' => 'Blog metni başlığnı girin', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group col-md-11">

    {{ Form::label('metin', 'Metin:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::textarea('metin', Input::old('metin'), array('class' => 'form-control', 'cols' => '4', 'placeholder' => 'Yazı metnini buraya girin')) }}
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
    {{ Form::label('etiketler', 'Etiketler:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::text('etiketler', Input::old('etiketler'), array('placeholder' => 'Her bir etiketi arasında virgül ile ayırmayı unutmayın!', 'class' => 'form-control')) }}
    </div>
</div>

{{ Form::submit('Gönder', array('class' => 'btn btn-default')) }}

{{ Form::close() }}

@stop