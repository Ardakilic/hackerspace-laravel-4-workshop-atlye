<?php

class Tag extends Eloquent {


    public function blogs(){
        return $this->belongsToMany('Blog', 'blog_tag');
    }

    protected $fillable = array(
        'tag', 'slug'
    );

    //etiketlerin temiz-urlleri için eklenti
    public static $sluggable = array(
        'build_from' => 'tag',
        'save_to'    => 'slug',
        'on_update'  => true
    );

}
