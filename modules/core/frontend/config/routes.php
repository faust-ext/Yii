<?php

return [
    '/' => 'core/site/index',
    '/site/search' => 'core/site/search',
    'articles/<alias:\w+>' => '/article/article/index',
    'article/<id:\w+>' => '/article/article/view',
    'category-list/<alias:\w+>' => '/article/article/category-list',
];