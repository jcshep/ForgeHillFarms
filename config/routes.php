<?php

return  [

    '<controller:\w+(-\w+)*>/<id:\d+>' => '<controller>/view',
    '<controller:\w+(-\w+)*>/<action:\w+(-\w+)*>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+(-\w+)*>/<action:\w+(-\w+)*>' => '<controller>/<action>',

    'home' => 'site/home',
    'admin' => 'admin/index',
    'store' => 'store/index',

    'page/remove-image/<slug:\w+(-\w+)*>' => 'page/remove-image',

    '<controller:\w+>/<action:\w+>/<id:\d+>/<s:\d+>/<e:\d+>' => '<controller>/<action>',

    // Page Redirection
    '<slug:\w+(-\w+)*>' => 'page/index',
    
];
