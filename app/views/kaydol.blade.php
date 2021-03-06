@extends('blog_masterpage')

@section('content')

{{ Form::open(array('route' => 'kayit_form_post', 'role' => 'form')) }}
<h2>
    Kayıt ol Yapın
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
    {{ Form::label('first_name', 'Adı:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::text('first_name', Input::old('first_name'), array('placeholder' => 'Adınızı girin', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group col-md-11">

    {{ Form::label('last_name', 'Soyadı:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::text('last_name', Input::old('last_name'), array('placeholder' => 'Soyadınızı girin', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group col-md-11">
    {{ Form::label('email', 'E-posta:', array('class' => 'col-md-4')) }}
    <div class="col-md-7">
        {{ Form::text('email', Input::old('email'), array('placeholder' => 'E-posta adresinizi girin', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group col-md-11">

    {{ Form::label('password', 'Parola:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::password('password', array('placeholder' => 'Parolanzı girin', 'class' => 'form-control')) }}
    </div>
</div>

<div class="form-group col-md-11">

    {{ Form::label('re_password', 'Yeniden Parola:', array('class' => 'col-md-4')) }}

    <div class="col-md-7">
        {{ Form::password('re_password', array('placeholder' => 'Yeniden Parolanzı girin', 'class' => 'form-control')) }}
    </div>
</div>

{{ Form::submit('Gönder', array('class' => 'btn btn-default')) }}

{{ Form::close() }}

@stop