<?php

class AuthController extends BaseController {

    //login get metodu. getLogin gibi
    //Önemli: get veya post ile ön eklemek şart değil, daha okunamlı oldudğunu düşünüyorum böyle
	public function getLogin() {
        return View::make('login')
            ->with('title', 'Giriş Yap');
    }

    //login post metodu, login kontrol edecek
    public function postLogin() {

        //Önce veriler istenen gibi mi kontrol edelim
        $validation = Validator::make(Input::all(), User::$girisKurallari);


        //Doğrulamadan geçmiş mi?
        if($validation->passes()) {

            //Şimdi Sentry Stili login edelim

            //Not: Kodlar gözünüzü korkutmasın. Olay 1 satırda bitiyor aslında. Diğer kalanları hata yakalama :)

            //login deneyelim
            try
            {
                //
                $giris = Sentry::authenticate(
                    array( //eposta ve parola
                        'email'     =>  Input::get('email'),
                        'password'  =>  Input::get('password')
                    ),
                    true //beni hatırla? true ise evet false ise hayır
                );

                //Başarılı giriş, ana sayfaya yolluyoruz
                return Redirect::to('/')
                    ->withSuccess('Başarı ile giriş yaptınız');
            }

            //kullanıcı adı/enmail alanı gerekli
            catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.login_required'));
            }
            //parola alanı gerekli
            catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.password_required'));
            }
            //hatalı parola
            catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.wrong_password'));
            }
            //kullanıcı bulunamadı
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.user_notfound'));
            }
            //kullanıcı onaylanmamış
            catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.user_notactivated'));
            }

            // geçici engelleme aktifse (5x hatalı parola vs.) bu mesaj geliyor, geçici engellenmiş
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.user_suspended'));
            }
            //kullanıcı banlanmış
            catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
            {
                return Redirect::route('login_form')
                    ->withInput(Input::except('password'))
                    ->withErrors(Lang::get('blog.user_banned'));
            }

        //Doğrulama geçmemişse geri döndürüyoruz, hata mesajlarını da ekliyoruz.
        } else {
            return Redirect::route('login_form')
                ->withInput(Input::except('password'))
                ->withErrors($validation);
        }

    }

    //logout metodu
    public function getLogout() {
        Sentry::logout();

        return Redirect::to('/')
            ->with('success', 'Başarı ile çıkış yaptınız');
    }


    //kayıt get metodu
    public function getKaydol(){
        return View::make('kaydol')
            ->withTitle('Kaydol');
    }

    public function postKaydol() {

        $validation = Validator::make(Input::all(), User::$kayitKurallari);

        if($validation->passes()) {

            //Önce sentry stili üyeyi yaratıyoruz. Database seederımızda var örneği
            $user = Sentry::getUserProvider()->create(array(
                'email'       => Input::get('email'),
                'password'    => Input::get('password'),
                'first_name'  => Input::get('first_name'),
                'last_name'   => Input::get('last_name'),
                'activated'   => 1,
                'permissions' => array (
                    'admin' => 0 //oluşturulan üye admin değil dikkat! Bu satırı koymaya da bilirdik, göstermek amaçlı
                )
            ));

            //Şimdi de ana sayfaya geri yönlendirelim
            return Redirect::to('/')
                ->withSuccess('Merhaba '.Input::get('first_name').', sitemize başarı ile kayıt oldunuz.<br />
                    '.HTML::linkRoute('login_form', 'buradan').' giriş yapabilirsiniz.');


        } else {
            return Redirect::route('kayit_form')
                ->withInput(Input::except('password', 're_password'))
                ->withErrors($validation);
        }

    }


}