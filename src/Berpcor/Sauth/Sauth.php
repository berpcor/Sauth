<?php namespace Berpcor\Sauth;
    

    
    use Berpcor\Sauth\Logic\SocialAuther as Auther;
    use Config;
    use Input;
    use User;
    use Auth;
    use Redirect;
    use View;

    /**
    * Класс для работы с авторизацией через социальные сети.
    */
    class Sauth
    {
        // Генерация ссылки для авторизации
        public static function linkFor($provider){
            $adapter = self::makeConfig($provider);
            return $adapter->getAuthUrl();
        }

        // Авторизация - запрос токена, получение информации о пользователе,
        // проверка на существование пользователя в базе данных. Если его не существует,
        // то добавление его в базу, если существует, то проверка обновились ли данные о нем,
        // которые требуют обновления в базе данных.
        public static function attemptVia($provider_name){

            $provider = self::makeConfig($provider_name);
            $auther = new Auther($provider);
            $auth = $auther->authenticate();
            $data = array();
            if($auth){

                if (!is_null($auther->getSocialId()))
                   $data['social_id'] = !is_null($auther->getSocialId()) ? $auther->getSocialId() : null;

                if (!is_null($auther->getName()))
                    $data['name'] = !is_null($auther->getName()) ? $auther->getName() : null;

                if (!is_null($auther->getEmail()))
                    $data['email'] = !is_null($auther->getEmail()) ? $auther->getEmail() : null;

                if (!is_null($auther->getSocialPage()))
                    $data['social_page'] = !is_null($auther->getSocialPage()) ? $auther->getSocialPage() : null;

                if (!is_null($auther->getSex()))
                    $data['sex'] = !is_null($auther->getSex()) ? $auther->getSex() : null;

                if (!is_null($auther->getBirthday()))
                    $data['birthday'] = !is_null($auther->getBirthday()) ? $auther->getBirthday() : null;

                // аватар пользователя
                if (!is_null($auther->getAvatar()))
                    $data['avatar'] = !is_null($auther->getAvatar()) ? $auther->getAvatar() : null;
                      
               //return $data;
               // Здесь нужно вставить регистрацию пользователя в базе данных, если его там нет,
               // если есть, то обновить данные о пользователе и после этого, создать сессию с данными пользователя и перенаправить пользователя 
               // на ту же страницу, которую предварительно сохранить в сессии, когда вызывается генерация ссылки ???
               // 
               $user = User::where('social_id','=',$data['social_id'])->first();
               if(!is_null($user)){
                    // Если такой пользователь уже существует
                    $cnt = 0;
                    // return $user->name;
                    if($user->name!=$data['name']){
                        $user->name = $data['name'];
                        $cnt++;
                    }
                    if($user->social_avatar!=$data['avatar']){
                        $user->social_avatar = $data['avatar'];
                        $cnt++;
                    }
                    if($user->email!=$data['email']){
                        $user->email = $data['email'];
                        $cnt++;
                    }
                    if($cnt>0){
                        $user->save();
                    }
                    Auth::login($user);
                    return Redirect::to('/');
                    

               }
               else {
                    // Если пользователя не существует
                    $user = new User();
                    $user->name = $data['name'];
                    $user->registered_via = $provider_name;
                    $user->social_id = $data['social_id'];
                    $user->social_avatar = $data['avatar'];
                    $user->email = $data['email'];
                    $user->save();

                    Auth::login($user);
                    return Redirect::to('/');
               }
            
            }
            else {
                //return Input::all();
                // throw new Logic\Exception\InvalidArgumentException('Can not authorise.');    
                // if(isset($_GET['']))
                if(Input::has('error')){
                    //return Input::get('error')." / ".Input::get('error_reason'). ' / ' . Input::get('error_description');
                    return View::make('sauth::error')->with( "message", Input::get('error')." / ".Input::get('error_reason'). ' / ' . Input::get('error_description') );
                }
            }

        }

        protected static function makeConfig($adapter){

            $existing_providers = array();
            $providers = Config::get('sauth::providers');
            $counter = 0;
            foreach($providers as $k => $v){
                if($adapter==$k){
                    $counter++;
                }
            }

            $config_string = 'sauth::providers.'.$adapter;

            // Проверка указаны ли данные конфигурации для данного адаптера
            
            $check = Config::get($config_string);
            $check_counter = 0;
            foreach($check as $k => $v){
                if(is_null($v)){
                    $check_counter++;
                }
            }
            if($check_counter!=0){
                throw new \Berpcor\Sauth\Logic\Exception\InvalidArgumentException('You need to specify setting (social settings) for selected provider ('.$adapter.')');    
            }

            if($counter==0){
                // throw new Exception('');
                throw new \Berpcor\Sauth\Logic\Exception\InvalidArgumentException('Wrong social auth provider.');
            };
            $adapter_string = 'Berpcor\Sauth\Logic\Adapter\\'.ucfirst($adapter);
            
            $adapter = new $adapter_string(Config::get($config_string));
            // self::$adapter = $adapter;
            return $adapter;

        }

    }