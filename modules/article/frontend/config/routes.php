<?php

return [
//    'articles/<alias:\w+>' => '/article/article/index',
//    [
//        'pattern' => 'articles/<menu:\w+>/<alias:\w+>',
//        'route' => '/article/article/index',
//        'defaults' => ['alias' => ''],
//    ],
    'articles/<menu:[\w_\/-]+>/<alias:\w+>' => '/article/article/index',
    'articles/<alias:\w+>' => '/article/article/index',
    'article/<menu:[\w_\/-]+>/<id:\w+>' => '/article/article/view',
    'article_news/<menu:[\w_\/-]+>/<nid:\w+>' => '/article/article/detail',
    'category-list/<menu:\w+>/<alias:\w+>' => '/article/article/category-list',
    'category-list/<alias:\w+>' => '/article/article/category-list',
    'articll/<menu:\w+>/<id:\w+>' => '/article/article/citogen',
  //  'page/<action:[\w\-]+>' => '/page/page/<action>',

];