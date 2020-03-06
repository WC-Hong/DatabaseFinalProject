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

use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $messaage = $request->session()->get('error_signup');
    return view('welcome', ['message_login' => $request->session()->get('error_login'),
        'message_signup' => $messaage,
        'authcode' => captcha_src('flat')]);
})->middleware('logged_in');

Route::post('/login/', 'Controller@login');
Route::post('/register/', 'Controller@register');

Route::get('/message/', 'Controller@message');
Route::get('/{account}/home/', 'Controller@home')->middleware('go_home');

Route::post('/stu/upload/', 'Controller@insert_works')->middleware('cros');
Route::get('/stu/search/', 'Controller@select_works');
Route::get('/stu/gantt/search/', 'Controller@student_search_gantt');
Route::post('/stu/gantt/modify/', 'Controller@student_modify_gantt');

Route::post('/modify', 'Controller@modify');

Route::get('/tea/search/group/', 'Controller@search_files');
Route::get('/tea/search/student/', 'Controller@teacher_get_student');
Route::get('/tea/selection/', 'Controller@teacher_get_selection');
Route::post('/tea/create_team/', 'Controller@teacher_create_team');

Route::get('/test/', function (\Illuminate\Http\Request $request) {
    $request->session()->flush();
});