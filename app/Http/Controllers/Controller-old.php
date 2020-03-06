<?php

namespace App\Http\Controllers;

use App\Manager;
use App\sign_in;
use App\Users;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $request) {
        $auth = Validator::make($request->all(), ['auth' => 'captcha']);
        if ($auth->fails()) {
            $request->session()->flush();
            $request->session()->put('error_login', '圖形驗證碼錯誤!!');
            return redirect("/#login");
        }

        $account = $request->post('user');
        $password = hash('sha256', $request->post('pass'));

        $data = DB::table('users')->where('studentID', '=', $account)->where('password', '=', $password)->get();
        if ($data != null) {
            $request->session()->put('account_id', $account);
            $request->session()->put('user_name', $data->first()->name);
            $request->session()->put('permission', 'users');
            return redirect('/'.$account."/home/");
        }
        $data = DB::table('manager')->where('teacherID', '=', $account)->where('password', '=', $password)->get();
        if ($data != null) {
            $request->session()->put('account_id', $account);
            $request->session()->put('user_name', $data->first()->name);
            $request->session()->put('permission', 'manager');
            return redirect();
        }

        $request->session()->flush();
        $request->session()->put('error_login', '帳號或密碼錯誤!!');
        return redirect('/#login');
    }

    public function signup(Request $request) {
        $auth = Validator::make($request->all(), ['auth' => 'captcha']);
        if ($auth->fails()) {
            $request->session()->flush();
            $request->session()->put('error_signup', '圖形驗證碼錯誤!!');
            return redirect("/#signup");
        }

        $account = $request->post('user');
        $data = null;
        if ($request->post('priority') == 'users') $data = Users::all()->where('studentID', '=', $account)->first();
        else $data = Manager::all()->where('teacherID', '=', $account)->first();
        if ($data != null) {
            $request->session()->flush();
            $request->session()->put('error_signup', '帳號已註冊!!');
            return redirect("/#signup");
        }

        if ($request->post('pass') != $request->post('pass2')) {
            $request->session()->flush();
            $request->session()->put('error_signup', '確認密碼與密碼不符!!');
            return redirect("/#signup");
        }

        if ($request->post('priority') == 'users') {
            $data = new Users();
            $data->studentID = $request->post('user');
            $data->name = $request->post('name');
            $data->email = $request->post('email');
            $data->password = hash('sha256', $request->post('pass'));
            $data->phone = $request->post('tel');
            $data->save();
        } else {
            $data = new Manager();
            $data->teacherID = $request->post('user');
            $data->name = $request->post('name');
            $data->email = $request->post('email');
            $data->password = hash('sha256', $request->post('pass'));
            $data->phone = $request->post('tel');
            $data->save();
        }

        $request->session()->flush();
        return view('signedup');
    }

    public function home(Request $request){
        $groups = DB::table('sign_in')->join('group', 'sign_in.gID', '=', 'group.groupID')->select('sign_in.sID', 'group.projectname')
            ->where('sign_in.sID', '=', $request->session()->get('account_id'))->get()->all();
        if ($groups == null) $result = "null";//sign_in::all()->where('uID', '=', $request->session()->get('account_id'))->all();
        return view('student', ['name' => $request->session()->get('user_name'), 'groups' => $groups]);
    }
}
