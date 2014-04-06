<?php


//Resource'lar başla

////////////////////////////////////////////////////
//Auth Resource'ları
//Route::get('login', 'AuthController@getLogin');

//resource'ları bir grupta topladık.
//Bu bize he seferinde benzer gruplarda aynı filtreyi vs. yazmamızdan kurtardı,


//Sadece ziyaretçilere özel alanlar
Route::group(array('before' => 'ziyaretci'), function(){

    //login form
    Route::get('login', array('as' => 'login_form', 'uses' => 'AuthController@getLogin'));
    Route::post('login', array('before' => 'csrf', 'as' => 'login_form_post', 'uses' => 'AuthController@postLogin'));

    //kayıt form
    Route::get('kaydol', array('as' => 'kayit_form', 'uses' => 'AuthController@getKaydol'));
    Route::post('kaydol', array('before' => 'csrf', 'as' => 'kayit_form_post', 'uses' => 'AuthController@postKaydol'));

});
//sadece ziyaretçilere özel alanlar son


//Üyelik zorunlı alanlar
Route::group(array('before' => 'uye'), function(){
    //çıkış yap linki
    //Route::get('logout', array('before' => 'uye', 'as' => 'logout', 'uses' => 'AuthController@getLogout'));
    Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

    Route::get('blog/yeni', array('as' => 'yeni_blog', 'uses' => 'BlogController@getYeni'));
    Route::post('blog/yeni', array('before' => 'csrf', 'as' => 'yeni_blog_post', 'uses' => 'BlogController@postYeni'));

});
//Üyelik zorunlu alanlar son

//Yönetici zorunlu alanlar:
Route::group(array('before' => 'erisim:admin'), function(){

    Route::get('blog/duzenle/{id}', array('as' => 'blog_duzenle', 'uses' => 'BlogController@getDuzenle'))->where('id', '[0-9]+');
    Route::post('blog/duzenle/{id}', array('as' => 'blog_duzenle_post', 'uses' => 'BlogController@postDuzenle'))->where('id', '[0-9]+');

    Route::get('blog/sil/{id}', array('as' => 'blog_sil', 'uses' => 'BlogController@getSil'))->where('id', '[0-9]+');

});
// yönetici zorunlu alanlar son

////////////////////////////////////////////////////

////////////////////////////////////////////////////
//Blog Resource'ları

//Blog Anasayfa
Route::get('blog', array('as' => 'blog_index', 'uses' => 'BlogController@index')); //başına get, post eklemek zorunlu değil

//Blog kullanıcı yazıları
Route::get('blog/kullanici/{id}', array('as' => 'blog_kullanici_yazilari', 'uses' => 'BlogController@kullanicidan'))->where('id', '[0-9]+');

//Blog etiket
Route::get('blog/etiket/{slug}', array('as' => 'blog_etiket', 'uses' => 'BlogController@etiket'))->where('slug', '[0-9A-z\d-\/_.]+');

//Arama post metodu
Route::post('blog/arama', array('as' => 'blog_arama', 'uses' => 'BlogController@arama'));

//Blog Detay Sayfası
Route::get('blog/{slug}', array('as' => 'blog_detay', 'uses' => 'BlogController@detay'))->where('slug', '[0-9A-z\d-\/_.]+');

//Blog Resource'ları Bit
////////////////////////////////////////////////////


Route::get('/', function()
{
	//return View::make('hello');
    return View::make('index_masterpage');

});