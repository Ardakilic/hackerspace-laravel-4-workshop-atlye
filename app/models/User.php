<?php

//Mevcut User modelini Sentry 2 ile kullanmak için nereye extend ettiğini değiştirmek lazım.
class User extends Cartalyst\Sentry\Users\Eloquent\User {


    public function blogs() {
        return $this->hasMany('Blog', 'userID');
    }


    //Giriş form doğrulama kuralları
    public static $girisKurallari = array(
        'email'         => 'required|email|exists:users,email',
        'password'      => 'required',
    );


    //Kayıt ol form doğrulama kuralları
    public static $kayitKurallari = array(
        'first_name'    => 'required|min:2',
        'last_name'     => 'required|min:2',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|min:6',
        're_password'   => 'required|same:password',
    );

}