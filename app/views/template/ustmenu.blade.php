<!-- navbar başla -->
<div class="navbar-inverse navbar-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">LaraBlog</a>
        </div>
        <div class="navbar-collapse collapse navbar-left">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ URL::to('/') }}">Anasayfa</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Yazılar <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            {{ HTML::linkRoute('blog_index', 'Son yazılar') }}
                        </li>
                        @if(Sentry::check())
                            <li class="divider"></li>
                            <li class="dropdown-header">
                                Üyelere özel
                            </li>
                            <li>
                                {{ HTML::linkRoute('yeni_blog', 'Yeni Yazı') }}
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.navbar-collapse -->
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">

                @if(Sentry::check())
                    <?php
                        //Mevcut kullanıcıyı alalım, adını göstereceğiz
                        $userdata = Sentry::getUser();
                    ?>
                    <li>
                        <a href="#">Merhaba {{ $userdata->first_name }}</a>
                    </li>
                    <li>
                        {{ HTML::linkRoute('logout', 'Çıkış Yap') }}
                    </li>
                @else
                    <li>
                        {{ HTML::linkRoute('kayit_form', 'Kayıt Ol') }}
                    </li>
                    <li>
                        {{ HTML::linkRoute('login_form', 'Giriş Yap') }}
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- navbar bit -->