<?php

use \Sentry;

class UserTableSeeder extends Seeder {

	public function run()
	{
        $user = Sentry::getUserProvider()->create(array(
            'email'       => 'arda@arda.com',
            'password'    => 'arda',
            'first_name'  => 'Arda',
            'last_name'   => 'Kılıçdaı',
            'activated'   => 1,
            'permissions' => array (
                'admin' => 1
            )
        ));

        //mesajı yazalım şimdi
        $this->command->info('Yönetici ID: '.$user->id.' ile başarı ile oluşturuldu!');
	}

}
