<?php

//Sadece ziyaretçi olanların görebileceği (misal giriş formu) alanlar için filtre
Route::filter('ziyaretci', function(){
    if(Sentry::check()) {
        return Redirect::to('/')
            ->with('success', 'Zaten giriş yapmışsınız');
    }
});

//sadece üye ise girebilir.
Route::filter('uye', function(){
    if(!Sentry::check()) {
        return Redirect::to('/')
            ->with('hata', 'Buraya erişebilmek için üye olmanız gerekmekte');
    }
});


//Sentry 2 ile erişim yetkisi var mı kontrol filtresi
//Aynı zamanda filtreye parametre geçiriyoruz
Route::filter('erisim',function($route, $request, $yetki){
    if(Sentry::check()) {
        if(Sentry::getUser()->hasAccess($yetki)) {
            //giriş
        } else {
            return Redirect::to('/')
                ->with('hata', 'Bu alana erişmeye yetkiniz yok!');
        }
    } else {
        return Redirect::to('/')
            ->with('hata', 'Henüz üye değilsiniz!');
    }
});

/////////////////////////////////////////
////Laravel Filtreleri buradan aşağısı

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});