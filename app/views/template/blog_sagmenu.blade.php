<div class="well">
    <h4>
        Arama
    </h4>

    {{ Form::open(array('route' => 'blog_arama', 'id' => 'aramaform')) }}
    <div class="input-group">
        {{ Form::text('kriter', Input::old('kriter'), array('class' => 'form-control')) }}
          <span class="input-group-btn">
            <button onclick="document.getElementById('aramaform').submit();" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
    </div>
    {{ Form::close() }}

    <!-- /input-group -->
</div>

<div class="well">
    <h4>
        Laravel Kaynakları
    </h4>
    <p>
        <a href="http://forums.laravel.io/">Laravel Uluslarası forumları</a>
    </p>
    <p>
        <a href="http://forum.laravel.gen.tr/">Laravel Türkiye forumları</a>
    </p>
    <p>
        <a href="https://www.facebook.com/groups/laravelturkiye/">Laravel Türkiye Facebook grubu</a>
    </p>
    <p>
        <a href="https://leanpub.com/u/sineld">Laravel için Türkçe kitaplar</a>
    </p>
    <p>
        <a href="http://amzn.to/laravel-kitap">
            <img src="http://i.imgur.com/5BoBYeE.jpg" width="300" class="img-responsive">
        </a>
    </p>
</div>
<!-- /well -->