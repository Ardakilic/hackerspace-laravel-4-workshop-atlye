@extends('blog_masterpage')

@section('content')

{{ Form::open(array('url' => 'login', 'role' => 'form')) }}
    <h2>
        Giriş Yapın
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
        {{ Form::label('email', 'E-posta:', array('class' => 'col-md-4')) }}
        <div class="col-md-7">
            {{ Form::text('email', Input::old('email'), array('placeholder' => 'E-posta adresinizi girin', 'class' => 'form-control' )) }}
        </div>
    </div>

    <div class="form-group col-md-11">

        {{ Form::label('password', 'Parola:', array('class' => 'col-md-4')) }}

        <div class="col-md-7">
            {{ Form::password('password', array('placeholder' => 'Parolanzı girin', 'class' => 'form-control' )) }}
        </div>
    </div>


    {{ Form::submit('Gönder', array('class' => 'btn btn-default')) }}

{{ Form::close() }}

@stop