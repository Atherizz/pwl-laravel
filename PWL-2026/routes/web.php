<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::get('/about', AboutController::class);

Route::get('/hello', [WelcomeController::class, 'hello']);

Route::get('/greeting', [WelcomeController::class, 'greeting']);

Route::get('/world', function () {  
return 'World';  
});

Route::get('/user/{name}', function ($name) 
{ 
    return 'Nama saya '.$name;  
}); 

Route::get('/posts/{post}/comments/{comment}', 
function  ($postId, $commentId) {  
return 'Pos ke-'.$postId." Komentar ke-: ".$commentId; 
});

Route::get('/articles/{id}', ArticleController::class);

Route::get('/user/{name?}', function ($name=null) {
    return 'Nama saya '.$name;  
}); 

Route::view('/welcome', 'welcome', ['name' => 'Taylor']); 

Route::resource('photos', PhotoController::class); 