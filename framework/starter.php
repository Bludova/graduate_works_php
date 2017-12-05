<?php
// подключаем twig

require_once 'vendor/autoload.php';
require_once 'vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();


// Где лежат шаблоны
$loader = new Twig_Loader_Filesystem('templates');

// Где будут хранится файлы кэша (php файлы)
$twig = new Twig_Environment($loader);


// require_once '../templates/users/user.php';


//         {% for value in values %}

// <li><a class="selected" href="#basics">{{value.name}}</a></li>
// <li><a href="#account">СЧЕТ</a></li>
//     {% endfor %}
// {% for post in posts %}
//     {{ loop.index }}
// {%endfor %}
