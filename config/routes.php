<?php

return  [

    '<controller:\w+(-\w+)*>/<id:\d+>' => '<controller>/view',
    '<controller:\w+(-\w+)*>/<action:\w+(-\w+)*>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+(-\w+)*>/<action:\w+(-\w+)*>' => '<controller>/<action>',

    'home' => 'site/home',
    'admin' => 'admin/index',

    'page/remove-image/<slug:\w+(-\w+)*>' => 'page/remove-image',

    // Page Redirection
    '<slug:\w+(-\w+)*>' => 'page/index',
    
];
