<?php

class BlogController extends BaseController {

	//blog ana sayfası (aslında son yazılar)
    public function index() {

        $blog = Blog::with('users', 'tags')->orderBy('id', 'desc')->paginate(2);

        return View::make('blog.sayfalar')
            ->with('title', 'Son Yazılar')
            ->with('data', $blog);
    }

    //yeni blog yazısı get metodu
    public function getYeni() {
        return View::make('blog.yeni')
            ->withTitle('Yeni Blog Yazısı');
    }

    public function postYeni() {

        //return dd(Input::all());

        //önce form istediğimiz kriterlerde mi?
        $validation = Validator::make(Input::all(), Blog::$eklemeKurallari);

        //eğer form istediğimiz kriterlerdeyse
        if($validation->passes()) {

            //ilk resmi upload edelim:
            $resim = Input::file('resim');
            $resim_adi  = Str::slug($resim->getClientOriginalName()).'.'.File::extension($resim->getClientOriginalName());
            $resim_yolu = Config::get('blog.resim_klasor').$resim_adi;

            //dosya adı orijinal olana kadar değiştiriyoruz Str::random() kullanarak
            while(file_exists($resim_yolu)) {
                $resim_adi = Str::slug($resim->getClientOriginalName()).Str::random(6).'.'.File::extension($resim->getClientOriginalName());
                $resim_yolu = Config::get('blog.resim_klasor').$resim_adi;
            }

            //şimdi dosya uploadı
            $resim->move(Config::get('blog.resim_klasor'), $resim_adi);
            //resim upload son


            //Bloğu eklerken mevcut kullanıcı IDsi de lazım. (Bloğu yazan)
            $userdata = Sentry::getUser();

            //şimdi bloğu ekleyelim:
            $ekleme = array(
                'userID'    => $userdata->id,
                'baslik'    => Input::get('baslik'),
                'metin'     => Input::get('metin'),
                'resim'     => $resim_adi
            );

            $yeniBlog = Blog::create($ekleme);
            //blog ekleme son

            //Şimdi etiketler
            $etiketler = Input::get('etiketler');

            $etiketler_dizi = explode(',', $etiketler);

            foreach($etiketler_dizi as $etiket) {
                //adı "etiket1 " gibi olabilir virgüller arasında boşluk varsa
                $etiketAdi = trim($etiket);

                //şimdi o etiket adı ile etiker daha önceden var mı ona bakalım.
                $etiketBul = Tag::where('tag', $etiketAdi)->first();

                //eğer o isimde bir tag varsa tagla blog yazısını eşleştiriyoruz
                if($etiketBul) {

                    //eşleştirme
                    Blog::find($yeniBlog->id)->tags()->attach($etiketBul->id);

                //eğer o isimde bir tag yoksa yeni bir tag yaratıp onunla eşleştiriyoruz
                } else {

                    //yeni etiket oluşturalım
                    $yeniEtiket = Tag::create(array(
                        'tag' => $etiketAdi
                    ));

                    //şimdi yeni etiketi blogla eşleştirelim
                    Blog::find($yeniBlog->id)->tags()->attach($yeniEtiket->id);

                }
            }
            //Etiketler son

            //şimdi sayfaya geri döndürelim
            return Redirect::route('yeni_blog')
                ->with('success', 'Blog yazısı başarı ile eklendi!');

        } else {
            return Redirect::route('yeni_blog')
                ->withInput()
                ->withErrors($validation);
        }

    }

    public function detay($slug) {

        //önce bakalım o slugda bir blog yazısı var mı
        $blog = Blog::with('users', 'tags')->whereSlug($slug)->first();

        //varsa view'a gönderelim
        if($blog) {
            return View::make('blog.detay')
                ->with('title', 'Blog: '.$blog->baslik)
                ->with('blog', $blog);
        } else {
            //yoksa 404
            return App::abort(404);
        }

    }

    //ID deki kullanıcının blog yazılarını gösteren resource
    public function kullanicidan($id) {

        $blog = Blog::with('users','tags')
            ->where('userID', $id)
            ->paginate(2);

        //eğer kullanıcı varsa
        if($blog) {

            return View::make('blog.sayfalar')
                ->withTitle($blog[0]->users->first_name.' Kullanıcısının Blog Yazıları')
                ->withData($blog);

        //yoksa
        } else {
            //yoksa 404
            return App::abort(404);
        }
    }

    //Etiketlere bakma
    public function etiket($slug) {

        //Önce etikete, etiketle eşli blog yazılarını alalım bakarken
        $etiket = Tag::where('slug', $slug)->first();

        //var mı sonuç?
        if($etiket) {

            //gösterilecek data:
            $data = $etiket->blogs()->with('tags', 'users')->paginate(2);

            return View::make('blog.sayfalar')
                ->with('title', $etiket->tag.' Etiketine sahip yazılar')
                ->with('data', $data);

        } else {
            return App::abort(404);
        }
    }

    //arama formu
    public function arama() {

        //GERÇEK ORTAMDA BUNU FİLTRELEMEYİ UNUTMAYIN
        $kriter = Input::get('kriter');

        //Arama yapalım: Başlıkta veya metinde o kelime var mı arıyorum:
        $data = Blog::with('tags', 'users')
            ->where('baslik', 'LIKE', '%'.$kriter.'%')
            ->orWhere('metin', 'LIKE', '%'.$kriter.'%')
            ->get();

        //eğer sonuç varsa
        if($data) {

            return View::make('blog.sayfalar')
                ->with('title', $kriter.' için Arama Sonuçları')
                ->withData($data);

        } else {
            return App::abort(404);
        }

    }


    //Yazı Düzenleme Formu
    public function getDuzenle($id) {
        $blog = Blog::with('tags')->find($id);

        if($blog) {

            return View::make('blog.duzenle')
                ->with('title', 'Yazıyı Düzenle: '.$blog->baslik)
                ->with('blog', $blog);

        } else {
            return App::abort(404);
        }
    }

    public function postDuzenle($id) {

        //İlk bakalım bu id de bir blog var mı ?
        $blog = Blog::with('tags')->find($id);

        //Eğer varsa
        if($blog) {

            //önce form istediğimiz kriterlerde mi?
            $validation = Validator::make(Input::all(), Blog::$duzenlemeKurallari);

            //eğer form istediğimiz kriterlerdeyse
            if($validation->passes()) {

                //Önce düzenleme kriterleri:
                $duzenleme = array(
                    'baslik'    => Input::get('baslik'),
                    'metin'     => Input::get('metin'),
                );

                //Eğer Resim Yüklenmişse
                if(Input::hasFile('resim')){

                    //İlk mevcut resmi siliyoruz:
                    Croppa::delete(Config::get('blog.resim_klasor'), $blog->resim);

                    //Şimdi yeni resmi upload edelim:
                    $resim = Input::file('resim');
                    $resim_adi  = Str::slug($resim->getClientOriginalName()).'.'.File::extension($resim->getClientOriginalName());
                    $resim_yolu = Config::get('blog.resim_klasor').$resim_adi;

                    //dosya adı orijinal olana kadar değiştiriyoruz Str::random() kullanarak
                    while(file_exists($resim_yolu)) {
                        $resim_adi = Str::slug($resim->getClientOriginalName()).Str::random(6).'.'.File::extension($resim->getClientOriginalName());
                        $resim_yolu = Config::get('blog.resim_klasor').$resim_adi;
                    }

                    //şimdi dosya uploadı
                    $resim->move(Config::get('blog.resim_klasor'), $resim_adi);
                    //resim upload son

                    //Düzenleme verisine resim adını ekleyelim:
                    $duzenleme['resim'] = $resim_adi;
                }

                //Şimdi veritabanında düzenleyelim.

                //Zaten var mı yok mu diye kontrol ederken bloğu yakaladığımız için gelen nesne/koleksiyonda direkt güncelleme metodunu çağırabiliriz
                $blog->update($duzenleme);
                //blog Düzenleme son

                //Şimdi etiketler

                //İlk Bütün etiketleri siliyoruz
                $blog->tags()->detach();


                $etiketler = Input::get('etiketler');

                $etiketler_dizi = explode(',', $etiketler);

                foreach($etiketler_dizi as $etiket) {
                    //adı "etiket1 " gibi olabilir virgüller arasında boşluk varsa
                    $etiketAdi = trim($etiket);

                    //şimdi o etiket adı ile etiker daha önceden var mı ona bakalım.
                    $etiketBul = Tag::where('tag', $etiketAdi)->first();

                    //eğer o isimde bir tag varsa tagla blog yazısını eşleştiriyoruz
                    if($etiketBul) {

                        //eşleştirme
                        Blog::find($id)->tags()->attach($etiketBul->id);

                        //eğer o isimde bir tag yoksa yeni bir tag yaratıp onunla eşleştiriyoruz
                    } else {

                        //yeni etiket oluşturalım
                        $yeniEtiket = Tag::create(array(
                            'tag' => $etiketAdi
                        ));

                        //şimdi yeni etiketi blogla eşleştirelim
                        Blog::find($id)->tags()->attach($yeniEtiket->id);

                    }
                }
                //Etiketler son

                //şimdi sayfaya geri döndürelim
                return Redirect::route('blog_duzenle', $id)
                    ->with('success', 'Blog yazısı başarı ile güncellendi!');

            } else {
                return Redirect::route('blog_duzenle', $id)
                    ->withInput()
                    ->withErrors($validation);
            }

        } else {
            return App::abort(404);
        }

    }

    //Blog yazısı silme metodu
    public function getSil($id) {
        $blog = Blog::find($id);

        if($blog) {

            //Önce FTPden resmi silelim
            Croppa::delete(Config::get('blog.resim_klasor'), $blog->resim);

            //Şimdi de yazıyı
            $blog->delete();

            //Şimdi de Tüm bloglar sayfasına geri dönelim:
            return Redirect::route('blog_index')
                ->withSuccess('Blog yazısı başarı ile silindi');

        } else {
            return Redirect::to('/')
                ->with('hata', 'Silinecek veri bulunamadı');
        }
    }


}
