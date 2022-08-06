<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__ . '/auth.php';

Route::get('/', 'HomeController@index')->name('home');
Route::post('/', 'HomeController@glosuj')->name('glosuj');
// Route::get('/uplod/test/images/upload/{od}/{do}', 'HomeController@movephototonewpath');
Route::get('/find/image/from/text/test/{od}/{do}', 'HomeController@findimagefromtext');
Route::get('/getProposition/{catid}/{id}', 'HomeController@getProposition')->name('getProposition');



Route::get('/kokpit', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Kanał rss

// Route::get('/feed/{kategoria}', 'RssController@feed')->name('feed');
Route::get('/feed/najnowsze', 'RssController@najnowszefeed')->name('najnowszefeed');
Route::get('/feed/{kategoria}/{podkategoria}', 'RssController@feed')->name('feed');
Route::get('/feed/{kategoria}', 'RssController@feed')->name('feed');


// Google sitemaps
Route::get('/sitemap.xml', 'SitemapController@index')->name('index');
Route::get('/newssitemap.xml', 'SitemapController@news')->name('news');

Route::group([
    'prefix' => 'administrator',
    'as' => 'administrator.',
    'middleware' => [
        'auth',
        'check.access',
    ],
], function () {

    Route::get('/kokpit', 'Admin\AdminController@index')->name('dashboard');
    Route::group([
        'prefix' => 'artykuly',
        'as' => 'article.',
    ], function () {
        Route::get('/', 'Admin\ArticleController@index')->name('index');
        Route::get('/unlock/{id}', 'Admin\ArticleController@unlock')->name('unlock');
        Route::get('/change/{id}', 'Admin\ArticleController@change')->name('change');
        Route::get('/edytuj/{id}', 'Admin\ArticleController@edit')->name('edit');
        Route::post('/edytuj/{id}', 'Admin\ArticleController@update')->name('edit');
        Route::get('/stworz', 'Admin\ArticleController@create')->name('create');
        Route::post('/stworz', 'Admin\ArticleController@store')->name('create');
        Route::post('/store_photo', 'Admin\ArticleController@storePhoto')->name('store_photo');

    });
    Route::group([
        'prefix' => 'kategorie',
        'as' => 'category.',
    ], function () {
        Route::get('/', 'Admin\CategoryController@index')->name('index');
        Route::get('/change/{id}', 'Admin\CategoryController@change')->name('change');
        Route::get('/edytuj/{id}', 'Admin\CategoryController@edit')->name('edit');
        Route::post('/edytuj/{id}', 'Admin\CategoryController@update')->name('edit');
        Route::get('/stworz', 'Admin\CategoryController@create')->name('create');
        Route::post('/stworz', 'Admin\CategoryController@store')->name('create');
    });
    Route::group([
        'prefix' => 'uzytkownicy',
        'as' => 'users.',
    ], function () {
        Route::get('/', 'Admin\UserController@index')->name('index');
        Route::get('/change/{id}', 'Admin\UserController@change')->name('change');
        Route::get('/edit/{id}', 'Admin\UserController@edit')->name('edit');
        Route::post('/edit/{id}', 'Admin\UserController@update')->name('edit');
        Route::get('/stworz', 'Admin\UserController@create')->name('create');
        Route::post('/stworz', 'Admin\UserController@store')->name('create');
    });
    Route::group([
        'prefix' => 'menu',
        'as' => 'menu.',
    ], function () {
        Route::get('/',              'Admin\MenuController@index')->name('index');
        Route::get('/create',        'Admin\MenuController@create')->name('create');
        Route::post('/create',             'Admin\MenuController@store')->name('create');
        Route::get('/create/position/{name}',        'Admin\MenuController@createposition')->name('create.position');
        Route::post('/create/position/{name}',             'Admin\MenuController@storeposition')->name('create.position');
        Route::get('/{id}/edit',     'Admin\MenuController@edit')->name('edit');
        Route::post('/{id}/update',  'Admin\MenuController@update')->name('update');
        Route::post('/{id}/destroy', 'Admin\MenuController@destroy')->name('destroy');
    });
    Route::group([
        'prefix' => 'menu-link',
        'as' => 'menu_link.',
    ], function () {
        Route::get('/',                    'Admin\MenuController@index')->name('index');
        Route::get('/create',              'Admin\MenuController@create')->name('create');
        Route::post('/',                   'Admin\MenuController@store')->name('store');
        Route::get('/{menuLink}/edit',     'Admin\MenuController@edit')->name('edit');
        Route::post('/{menuLink}/update',  'Admin\MenuController@update')->name('update');
        Route::post('/{menuLink}/destroy', 'Admin\MenuController@destroy')->name('destroy');
    });
    Route::group([
        'prefix' => 'sonda',
        'as' => 'polls.',
    ], function () {
        Route::get('/', 'Admin\PollsController@index')->name('index');
        Route::get('/change/{id}', 'Admin\PollsController@change')->name('change');
        Route::get('/edit/{id}', 'Admin\PollsController@edit')->name('edit');
        Route::post('/edit/{id}', 'Admin\PollsController@update')->name('edit');
        Route::get('/stworz', 'Admin\PollsController@create')->name('create');
        Route::post('/stworz', 'Admin\PollsController@store')->name('create');
    });
    Route::group([
        'prefix' => 'grupy-uzytkownikow',
        'as' => 'user.groups.',
    ], function () {
        Route::get('/', 'Admin\UserGroupsController@index')->name('index');
        Route::get('/edit/{id}', 'Admin\UserGroupsController@edit')->name('edit');
        Route::post('/edit/{id}', 'Admin\UserGroupsController@update')->name('edit');
        Route::get('/stworz', 'Admin\UserGroupsController@create')->name('create');
        Route::post('/stworz', 'Admin\UserGroupsController@store')->name('create');
    });

    Route::group([
        'prefix' => 'konfiguracja',
        'as' => 'config.',
    ], function () {
            Route::group([
                'prefix' => 'menu',
                'as' => 'menu.',
            ], function () {
                Route::get('/menu', 'Admin\ConfigController@menu')->name('index');
                Route::post('/menuchange/{id}', 'Admin\ConfigController@menuChange')->name('change');

            });
            Route::group([
                'prefix' => 'module',
                'as' => 'module.',
            ], function () {
                Route::get('/module', 'Admin\ConfigController@module')->name('index');
                Route::post('/modulechange/{id}', 'Admin\ConfigController@moduleEdit')->name('edit');
                Route::get('/moduledelete/{id}', 'Admin\ConfigController@moduleDelete')->name('delete');
            });

        // Route::get('/menu', 'Admin\ConfigController@menu')->name('menu');
        // Route::get('/module', 'Admin\ConfigController@module')->name('module');

        // Route::get('/stworz', 'Admin\ConfigController@create')->name('create');
        // Route::post('/stworz', 'Admin\ConfigController@store')->name('create');
    });
});

Route::group([
    'prefix' => 'filemanager',
    'as' => 'unisharp.lfm.',
    'middleware' => [
        'auth',
        'check.access',
    ],
], function () {
    Route::get('/', 'FileManager\LfmController@show')->name('show');
    Route::get('/errors', 'FileManager\LfmController@getErrors')->name('getErrors');
    Route::get('/jsonitems', 'FileManager\ItemsController@getItems')->name('getItems');
    Route::get('/move', 'FileManager\ItemsController@move')->name('move');
    Route::get('/domove', 'FileManager\ItemsController@domove')->name('domove');
    Route::get('/folders', 'FileManager\FolderController@getFolders')->name('getFolders');
    Route::get('/newfolder', 'FileManager\FolderController@getAddfolder')->name('getAddfolder');
    Route::get('/crop', 'FileManager\CropController@getCrop')->name('getCrop');
    Route::get('/cropimage', 'FileManager\CropController@getCropimage')->name('getCropimage');
    Route::get('/cropnewimage', 'FileManager\CropController@cropnewimage')->name('cropnewimage');
    Route::get('/rename', 'FileManager\RenameController@getRename')->name('getRename');
    Route::get('/resize', 'FileManager\ResizeController@getResize')->name('getResize');
    Route::get('/doresize', 'FileManager\ResizeController@performResize')->name('performResize');
    Route::get('/download', 'FileManager\DownloadController@getDownload')->name('getDownload');
    Route::get('/delete', 'FileManager\DeleteController@getDelete')->name('getDelete');
    Route::any('/upload', 'FileManager\UploadController@upload')->name('upload');
});

Route::get('/edit/picture/name', 'HomeController@picture_name')->name('picture_name');
Route::get('/{adress}', 'HomeController@show')->where('adress', '(.*)');

// Route::get('/{adress1?}/{adress2?}/{adress3?}/{adress4?}/{adress5?}/{adress6?}/{adress7?}/{adress8?}/{adress9?}/{adress10?}/{adress11?}/{adress12?}/{adress13?}/{adress14?}/{adress15?}/{adress16?}/{adress17?}/{adress18?}/{adress19?}/{adress20?}/{adress21?}/{adress22?}/{adress23?}/{adress24?}/{adress25?}/{adress26?}/{adress27?}/{adress28?}/{adress29?}/{adress30?}/{adress31?}/{adress32?}/{adress33?}/{adress34?}/{adress35?}/{adress36?}/{adress37?}/{adress38?}/{adress39?}/{adress40?}/{adress41?}/{adress42?}/{adress43?}/{adress44?}/{adress45?}/{adress46?}/{adress47?}/{adress48?}/{adress49?}/{adress50?}/{adress51?}/{adress52?}/{adress53?}/{adress54?}/{adress55?}/{adress56?}/{adress57?}/{adress58?}/{adress59?}/{adress60?}/{adress61?}/{adress62?}/{adress63?}/{adress64?}/{adress65?}/{adress66?}/{adress67?}/{adress68?}/{adress69?}/{adress70?}/{adress71?}/{adress72?}/{adress73?}/{adress74?}/{adress75?}/{adress76?}/{adress77?}/{adress78?}/{adress79?}/{adress80?}/{adress81?}/{adress82?}/{adress83?}/{adress84?}/{adress85?}/{adress86?}/{adress87?}/{adress88?}/{adress89?}/{adress90?}/{adress91?}/{adress92?}/{adress93?}/{adress94?}/{adress95?}/{adress96?}/{adress97?}/{adress98?}/{adress99?}/{adress100?}', 'HomeController@show')->name('showkat');

// Route::get('/{category}/amp', 'HomeController@showkatamp')->name('showkatamp');
// Route::get('/{kat1}/{kat2}', 'HomeController@showartcategory')->name('showartcategory');
// Route::get('/{maincategory}/{category}/{alias}/amp', 'HomeController@showartamp')->name('showartamp');
// Route::get('/{maincategory}/{alias}/amp', 'HomeController@showartampone')->name('showartamp');
// Route::get('/{maincategory}/{category}/{alias}', 'HomeController@showart')->name('showart');
// Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

