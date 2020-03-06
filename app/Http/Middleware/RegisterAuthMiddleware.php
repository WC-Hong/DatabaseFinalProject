<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class RegisterAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('identity') != 'user' && $request->input('identity') != 'manager')
            return "身分有誤，請重新認!!";
        elseif ($request->input('identity') == 'user' && preg_match("/[^0-9]{8}/", $request->input('user')) < 1)
            return "請輸入正確的學號!!";
        elseif ($request->input('identity') == 'manager' && preg_match("/[A-Za-z][0-9]{5}/", $request->input('user')) < 1)
            return "請輸入正確的教室編號!!";
        elseif (preg_match("/^[^\s]+@[^\s]+\.[^\s]{2,3}$/", $request->input('email')))
            return "email格式不正確!!";
        elseif (preg_match("/^0[1-9][0-9]{7}[0-9]?/", $request->input('phone')))
            return "電話格是不正確!!";

        $auth = Validator::make($request->all(), ['auth' => 'captcha']);
        if ($auth->fails())
            return "圖形驗證碼錯誤!!";

        return $next($request);
    }
}
