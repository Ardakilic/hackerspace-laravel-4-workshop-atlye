<?php

class Blog extends Eloquent {

    //tablo adı model adının çoğulu oluyor normalde (Blogs),
    //biz tablo adını blog diye açtığımız için tablo adını tanıtıyoruz burada
    //Bu özellik sayesinde istediğimiz tabloya istediğimiz modeli bağlayabiliriz.
    protected $table = 'blog';


    public function users() {
        return $this->belongsTo('User', 'userID');
    }

    public function tags() {
        return $this->belongsToMany('Tag', 'blog_tag');
    }


    //$guarded değişkeni hangi sütunların düzenlenemeyeceğini belirtir (Kara Liste)
    //Ben onun yerine hangilerinin düzenlenebilecğeini belirtmeyi tercih ediyorum (Beyaz Liste)
    protected $fillable = array(
        'userID',
        'baslik',
        'resim',
        'metin',
        'slug', //sluggable için
    );

    //form doğrulama ekleme kuralları
    public static $eklemeKurallari = array(
        'baslik'    => 'required|min:4',
        'metin'     => 'required|min:20',
        'resim'     => 'required|image|max:1024',
    );

    //form doğrulama düzenleme kuralları
    public static $duzenlemeKurallari = array(
        'baslik'    => 'required|min:4',
        'metin'     => 'required|min:20',
        'resim'     => 'image|max:1024',
    );


    //blog yazılarının temiz-urlleri için eklenti
    public static $sluggable = array(
        'build_from' => 'baslik',
        'save_to'    => 'slug',
        'on_update'  => true
    );

}