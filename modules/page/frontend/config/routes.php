<?php

return [
    //'page/<action:\w+>' => '/page/page/<action>',
    'pages/<menu:[\w_\/-]+>/<alias:\w+>' => '/page/page/index',
    'pages/<alias:\w+>' => '/page/page/index',
    'page/mail' => '/core/site/mail'
];