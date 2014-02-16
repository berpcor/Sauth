<?php

return array(

    // redirect_uri - ссылка (абсолютный путь, начинающийся с http), на которую будет происходить перенаправление
    // со страницы социальной сети с code. Для это страницы должен 
    // быть создан маршрут и в нем должен быть вызван метод Sauth::attemptVia('имя_провайдера_из_списка_ниже')
    // Иначе говоря, по этой ссылке должен вызываться метод Sauth::attemptVia('имя_провайдера_из_списка_ниже')

    "providers" => array(

        'vk' => array(
            'client_id'     => null,
            'client_secret' => null,
            'redirect_uri'  => null
        ),
        'odnoklassniki' => array(
            'client_id'     => null,
            'client_secret' => null,
            'redirect_uri'  => null,
            'public_key'    => null
        ),
        'mailru' => array(
            'client_id'     => null,
            'client_secret' => null,
            'redirect_uri'  => null
        ),
        'yandex' => array(
            'client_id'     => null,
            'client_secret' => null,
            'redirect_uri'  => null
        ),
        'google' => array(
            'client_id'     => null,
            'client_secret' => null,
            'redirect_uri'  => null
        ),
        'facebook' => array(
            'client_id'     => null,
            'client_secret' => null,
            'redirect_uri'  => null
        )

    )

);