<?php
return [
    # auth
    'auth/signup' => 'auth/signup',
    'auth/logout' => 'auth/logout',

    # contacts
    'contact/set-image/([0-9]+)' => 'contact/setImage/$1',
    'contact/update/([0-9]+)' => 'contact/update/$1',
    'contact/view/([0-9]+)' => 'contact/view/$1',

    # site
    'site/index' => 'site/index',
    '/' => 'site/index'
];
