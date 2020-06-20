<?php
use SwoStar\Routes\Route;

Route::get('index',function (){
    return "this is index route";
});

Route::get('/','IndexController@index');
Route::get('index/demo','IndexController@demo');
Route::get('/config','IndexController@config');