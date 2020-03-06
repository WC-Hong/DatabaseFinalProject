<?php


namespace App\Http\Controllers;
use App\Mail\Test;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class MyCtrl extends BaseController
{
    public function test(Request $request) {
        return "<h3>HelloWorld</h3><h6>".$request->input('num')."</h6>";
    }

    public function input() {
        return view('enter');
    }

    public function result(Request $request) {
        $validate = Validator::make($request->all(), ['auth' => 'required|captcha']);
        Mail::to('40543225@gm.nfu.edu.tw')->send(new Test());
        return view('result', ['result' => $request->session()->get('captcha')]);
    }

    public function model_test(Request $request) {
        $result = Role::all()->where('stuID', '=', $request->input('account'))->where('pass', '=', $request->input('pass'))->first();
        if ($result != null) {
            return "<h3>welcome</h3>";
        } else {
            return "<h3>get_out</h3>";
        }
        /*$model->name = 'Aries';
        $model->stuID = '40543225';
        $model->sex = 'M';
        $model->pass = '1234';*/
        //$result = $model->getAttribute('stuID');
    }

    public function injectionTestPost(Request $request){
        //$table = Role::all()->where();
        $validate = Validator::make($request->all(), ['context' => 'required|integer']);
        if ($validate->fails()) return view('injectionTestPost', ['content' => $validate->errors()->first()]);
        $result = $request->input('context');
        return view('injectionTestPost', ['content' => strlen(hash('sha256', $request->post('context')))]);
    }

    public function injectionTestGet(Request $request){
        return view('injectionTestGet');
    }
}