<?php

Route::resource('/', 'IndexController', [
    'only' => ['index'],
    'names' => [''
        . 'index' => 'home'
    ]
]);

Route::resource('portfolios', 'PortfolioController', [
    'parameters' => [
        'portfolios' => 'alias'
    ]
]);

Route::resource('articles', 'ArticleController', [
    'parameters' => [
        'articles' => 'alias'
    ]
]);

Route::get('articles/cat/{cat_alias?}', ['uses' => 'ArticleController@index'])->name('articlesCat')->where('cat_alias','[\w-]+');

Route::match(['get','post'],'/contacts', ['uses' => 'ContactsController@index'])->name('contacts');

Route::resource('comment', 'CommentController', ['only' => ['store']]);

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');