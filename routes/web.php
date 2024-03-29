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

Route::get('articles/cat/{cat_alias?}', ['uses' => 'ArticleController@index'])->name('articlesCat')->where('cat_alias', '[\w-]+');

Route::match(['get', 'post'], '/contacts', ['uses' => 'ContactsController@index'])->name('contacts');

Route::resource('comment', 'CommentController', ['only' => ['store']]);

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'admin','middleware'=>'auth'], function() {
    //admin
    Route::get('/', ['uses' => 'Admin\IndexController@index'])->name('adminIndex');

    Route::resource('/articles', 'Admin\ArticlesController', [
        'parameters' => [
            'articles' => 'alias'
        ]
    ]);
    Route::resource('/permissions', 'Admin\PermissionsController');
    
    Route::resource('/users', 'Admin\UsersController');
    
    Route::resource('/menus', 'Admin\MenusController');
});

