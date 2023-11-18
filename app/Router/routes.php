<?php

return [
    ['GET', '/', ['App\Controllers\MainController', 'index']],
    ['GET', '/search', ['App\Controllers\MainController', 'search']],
    ['GET', '/article/create', ['App\Controllers\MainController', 'create']],
    ['GET', '/article/{id}', ['App\Controllers\MainController', 'show']],
    ['POST', '/', ['App\Controllers\MainController', 'store']],
    ['GET', '/edit/{id}', ['App\Controllers\MainController', 'edit']],
    ['POST', '/edit', ['App\Controllers\MainController', 'update']],
    ['POST', '/delete/{id}', ['App\Controllers\MainController', 'delete']],
];