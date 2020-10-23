<?php


/* ------ [ non locale routes ] ------ */

Route::group(['middleware' => ['locale']], function () {

    Route::get('/', ['uses' => 'Frontend\Controller@index', 'as' => 'home']);

    // Route::any('login', ['uses' => 'DashboardController@login', 'as' => 'dashboard.login']);

    Route::get('query/{q}', ['uses' => 'Frontend\Controller@index', 'as' => 'google-query']);
    Route::get('open-search.xml', ['uses' => 'Frontend\Controller@getOpenSearch', 'as' => 'open-search']);
    Route::get('rss.xml', ['uses' => 'Frontend\Controller@getRss']);
    Route::get('sitemap.xml', ['uses' => 'Frontend\Controller@getSitemap']);

    Route::get('fbauth', 'Frontend\Auth\SocialAuthFacebookController@redirect');
    Route::get('fbauth-callback', 'Frontend\Auth\SocialAuthFacebookController@callback');

    Route::get('googleauth', 'Frontend\Auth\SocialAuthGoogleController@redirect');
    Route::get('googleauth-callback', 'Frontend\Auth\SocialAuthGoogleController@callback');

    Route::post('login', 'Frontend\Auth\LoginController@login')->name('auth.login');
    Route::get('logout', 'Frontend\Auth\LoginController@logout')->name('auth.logout');
    Route::post('signup', 'Frontend\Auth\RegisterController@register')->name('auth.signup');

    Route::get('email/verify/{id}/{hash}', 'Frontend\Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Frontend\Auth\VerificationController@resend')->name('verification.resend');


    Route::post('password/email', 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Frontend\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Frontend\Auth\ResetPasswordController@reset')->name('password.update');

    Route::get('login', 'Frontend\ProfileController@login')->name('login');

});

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
*/
/* ------ [ EN ] ------ */

Route::group(['middleware' => ['locale:en'], 'as' => 'en.frontend.', 'namespace' => 'Frontend'], function () {

    Route::get('tr', ['uses' => 'Controller@index', 'as' => 'home']);

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::any('/', ['uses' => 'ProfileController@profile', 'as' => 'index']);
        Route::any('parola-degistir', ['uses' => 'ProfileController@editPassword', 'as' => 'change-password']);
        Route::get('favorites', ['uses' => 'ProfileController@myFavorites', 'as' => 'favorites']);


        Route::get('issues', ['uses' => 'ProfileController@myIssues', 'as' => 'issues']);
    });

    Route::get('book-detail/{isbn}', ['uses' => 'Controller@bookDetail', 'as' => 'book-detail']);
    Route::get('screen', ['uses' => 'Controller@screen', 'as' => 'screen']);
    Route::get('return-screen', ['uses' => 'Controller@returnScreen', 'as' => 'return-screen']);

});

/* ---- [ Ajax ] ---- */
Route::group(['prefix' => '/ajax/', 'as' => 'ajax.', 'namespace' => 'Frontend'], function () {

    Route::get('search-book', ['uses' => 'AjaxController@searchBook']);
    Route::get('search-user', ['uses' => 'AjaxController@searchUser']);
    Route::post('rent-book', ['uses' => 'AjaxController@rentBook']);
    Route::post('return-book', ['uses' => 'AjaxController@returnBook']);
    Route::post('delete-issue', ['uses' => 'AjaxController@deleteIssue']);

    Route::post('upload-image', ['as' => 'upload.image', 'uses' => 'AjaxController@uploadImage']);

    Route::post('delete-record', ['as' => 'delete', 'uses' => 'AjaxController@deleteRecord']);
    Route::post('update-status', ['as' => 'update-status', 'uses' => 'AjaxController@updateStatus']);

});


/* ---- [ Panel ] ---- */
Route::group(['prefix' => '/panel', 'as' => 'panel.', 'namespace' => 'Panel'], function () {

    Route::get('/', ['uses' => 'Controller@index', 'as' => 'index']);

    Route::get('login', ['uses' => 'AuthController@getLoginPage', 'as' => 'get-login-page']);
    Route::post('login', ['uses' => 'AuthController@doLogin', 'as' => 'do-login']);
    Route::any('logout', ['uses' => 'AuthController@doLogout', 'as' => 'logout']);

    Route::group(['prefix' => '/', 'middleware' => 'admin'], function () {
        Route::get('home', ['uses' => 'Controller@home', 'as' => 'home']);

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('/', ['uses' => 'UserController@index', 'as' => 'list']);
            Route::get('new', ['uses' => 'UserController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'UserController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'UserController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'UserController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'UserController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('/', ['uses' => 'AdminController@index', 'as' => 'list']);
            Route::get('new', ['uses' => 'AdminController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'AdminController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'AdminController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'AdminController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'AdminController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
            Route::get('/', ['uses' => 'CategoryController@index', 'as' => 'list']);
            Route::get('featured', ['uses' => 'CategoryController@featured', 'as' => 'featured']);
            Route::get('new', ['uses' => 'CategoryController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'CategoryController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'CategoryController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'CategoryController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'CategoryController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'publisher', 'as' => 'publisher.'], function () {
            Route::get('/', ['uses' => 'PublisherController@index', 'as' => 'list']);
            Route::get('featured', ['uses' => 'PublisherController@featured', 'as' => 'featured']);
            Route::get('new', ['uses' => 'PublisherController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'PublisherController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'PublisherController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'PublisherController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'PublisherController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'author', 'as' => 'author.'], function () {
            Route::get('/', ['uses' => 'AuthorController@index', 'as' => 'list']);
            Route::get('featured', ['uses' => 'AuthorController@featured', 'as' => 'featured']);
            Route::get('new', ['uses' => 'AuthorController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'AuthorController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'AuthorController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'AuthorController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'AuthorController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'book', 'as' => 'book.'], function () {
            Route::get('/', ['uses' => 'BookController@index', 'as' => 'list']);
            Route::get('featured', ['uses' => 'BookController@featured', 'as' => 'featured']);
            Route::get('new', ['uses' => 'BookController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'BookController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'BookController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'BookController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'BookController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'publisher', 'as' => 'publisher.'], function () {
            Route::get('/', ['uses' => 'PublisherController@index', 'as' => 'list']);
            Route::get('featured', ['uses' => 'PublisherController@featured', 'as' => 'featured']);
            Route::get('new', ['uses' => 'PublisherController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'PublisherController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'PublisherController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'PublisherController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'PublisherController@getAjaxAll', 'as' => 'all']);
        });

        Route::group(['prefix' => 'issue', 'as' => 'issue.'], function () {
            Route::get('/', ['uses' => 'IssueController@index', 'as' => 'list']);
            Route::get('featured', ['uses' => 'IssueController@featured', 'as' => 'featured']);
            Route::get('new', ['uses' => 'IssueController@new', 'as' => 'new']);
            Route::post('create', ['uses' => 'IssueController@create', 'as' => 'create']);
            Route::post('update/{id}', ['uses' => 'IssueController@update', 'as' => 'update']);
            Route::get('edit/{id}', ['uses' => 'IssueController@edit', 'as' => 'edit']);
            Route::any('all', ['uses' => 'IssueController@getAjaxAll', 'as' => 'all']);
        });


        Route::group(['prefix' => '/ajax/', 'as' => 'ajax.'], function () {
            Route::post('delete-record', ['as' => 'delete', 'uses' => 'AjaxController@deleteRecord']);
            Route::post('update-status', ['as' => 'update-status', 'uses' => 'AjaxController@updateStatus']);
            Route::post('upload-image', ['as' => 'upload.image', 'uses' => 'AjaxController@uploadImage']);
        });

        Route::group(['prefix' => '/tool', 'as' => 'tools.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'ToolController@index']);
        });

    });

});