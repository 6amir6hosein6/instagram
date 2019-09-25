<?php

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

Route::get('/', function () {

    if(!array_key_exists ('signed' , $_COOKIE)){
        return view('register_user/login_page');
    }else{
        return redirect()->route('user.home');
    }


})->name('user.login');
Route::post('/', 'user@login');
Route::view('/SignUp', 'register_user/sign_up')->name('user.sign_up');
Route::post('/SignUp' , 'user@sign_up');



Route::get('/follow/{username}','ajax_request@follow');
Route::get('/unfollow/{username}','ajax_request@unfollow');
Route::get('post/like/{post}','ajax_request@like');
Route::get('post/unlike/{post}','ajax_request@unlike');
Route::get('/likeid/{post}','ajax_request@like_id');
Route::get('/unlikeid/{post}','ajax_request@unlike_id');
Route::get('/askedRequest/no/{not_id}' ,'ajax_request@ask_follow_request_no');
Route::get('/askedRequest/yes/{not_id}' ,'ajax_request@ask_follow_request_yes');
Route::get('/getFollowRequestBack/{not_id}' ,'ajax_request@getFollowRequestBack');
Route::get('/search/{suggests}' ,'ajax_request@getSuggest');

Route::get('/user/active/{token}' , 'user@active');


Route::get('/home', 'home_page@signed')->name('user.home');
Route::get('/logout', 'home_page@logout')->name('user.logout');
Route::post('/home', 'home_page@search')->name('user.search');

Route::get('/sendingPost', 'home_page@postSending')->name('user.sendingPost');
Route::post('/sendingPost', 'home_page@uploadingPost');

Route::get('/{username}', 'home_page@username')->name('username');
Route::post('/{username}', 'home_page@following')->name('follow');
Route::post('/{username}', 'home_page@search')->name('user.search');

Route::get('/account/edit/{username}' ,'home_page@edit')->name('user.edit');
Route::post('/account/edit/{username}' ,'home_page@change_profile')->name('change.profile');



Route::get('delete_profile/{username}','home_page@delete_profile')->name('delete.profile');

Route::get('post/{media}' , 'home_page@showPost')->name('showPost');


Route::get('/notification/seen','ajax_request@seen');





