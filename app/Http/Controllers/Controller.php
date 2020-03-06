<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    public function login(Request $request)
    {
        $auth = Validator::make($request->all(), ['auth' => 'captcha']);
        if ($auth->fails())
            return "圖形驗證碼錯誤!!";

        $request->session()->flush();
        $account = $request->post('user');
        //$password = $request->post('pass');
        $password = hash('sha256', $request->post('pass'));

        $data = DB::table('users')->where('ID', '=', $account)->where('password', '=', $password)->first();
        if ($data != null) {
            $request->session()->put('account_id', $account);
            $request->session()->put('user_pass', $data->password);
            $request->session()->put('user_name', $data->name);
            $request->session()->put('phone_num', $data->phone);
            $request->session()->put('mail_addr', $data->email);
            $request->session()->put('permission', 'users');
            return url("/" . $account . "/home/");
        }

        $data = DB::table('manager')->where('ID', '=', $account)->where('password', '=', $password)->first();
        if ($data != null) {
            $request->session()->put('account_id', $account);
            $request->session()->put('user_pass', $data->password);
            $request->session()->put('user_name', $data->name);
            $request->session()->put('phone_num', $data->phone);
            $request->session()->put('mail_addr', $data->email);
            $request->session()->put('permission', 'manager');
            return url("/" . $account . "/home/");
        }

        return "帳號或密碼有誤!!";
    }

    public function register(Request $request)
    {

        /*------------------------------------------------驗證輸入錯誤------------------------------------------------*/
        if ($request->input('identity') != 'users' && $request->input('identity') != 'manager')
            return "身分有誤，請重新認!!";
        elseif ($request->input('identity') == 'users' && preg_match("/[0-9]{8}/", $request->input('user')) < 1)
            return "請輸入正確的學號!!";
        elseif ($request->input('identity') == 'manager' && preg_match("/[A-Za-z][0-9]{5}/", $request->input('user')) < 1)
            return "請輸入正確的教師編號!!";
        elseif (preg_match("/^[\S]+@[\S]+\.[\S]{2,3}/", $request->input('email')) < 1)
            return "email格式不正確!!";
        elseif (preg_match("/^0[1-9][\d]{7}[\d]/", $request->input('tel')) < 1)
            return "電話格式不正確!!";

        $auth = Validator::make($request->all(), ['auth' => 'captcha']);
        if ($auth->fails())
            return "圖形驗證碼錯誤!!";

        /*--------------------------------------------------註冊區塊--------------------------------------------------*/
        $account = $request->post('user');
        $data = null;
        if ($request->post('identity') == 'users') $data = DB::table('users');
        else $data = DB::table('manager');

        if ($data->where('ID', '=', $account)->first() != null) return "帳號已註冊!!";

        $data->insert(['ID' => $request->post('user'), 'name' => $request->post('name'),
            'email' => $request->post('email'), 'password' => hash('sha256', $request->post('pass')),
            'phone' => $request->post('tel'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        /*------------------------------------------------------------------------------------------------------------*/
        $request->session()->flush();
        return url('/message/?act=register');
    }

    public function home(Request $request)
    {
        if ($request->session()->get('permission') == 'users') {
            $groups = DB::table('sign_in')->join('team', 'sign_in.gID', '=', 'team.teamID')->select('sign_in.sID', 'team.teamID', 'team.projectname')
                ->where('sign_in.sID', '=', $request->session()->get('account_id'))->get()->all();

            return view('student', ['user' => $request->session()->get('account_id'),
                'name' => $request->session()->get('user_name'), 'phone' => $request->session()->get('phone_num'),
                'email' => $request->session()->get('mail_addr'), 'groups' => $groups]);
        } else {
            $students = DB::table('sign_in')->join('users', 'sign_in.sID', '=', 'users.ID')
                ->select('users.ID', 'users.name')
                ->where('sign_in.tID', '=', $request->session()->get('account_id'))
                ->where('sign_in.created_at', '>', 'DATE_SUB(CONCAT(YEAR(NOW()), \'/06/30\'), INTERVAL 4 YEAR)')
                ->groupBy('users.ID')
                ->get();

            $groups = DB::table('sign_in')->join('team', 'sign_in.gID', '=', 'team.teamID')
                ->select('team.teamID', 'team.projectname')
                ->where('sign_in.tID', '=', $request->session()->get('account_id'))
                ->where('sign_in.created_at', '>', 'DATE_SUB(CONCAT(YEAR(NOW()), \'/06/30\'), INTERVAL 4 YEAR)')
                ->groupBy('team.teamID')
                ->get();

            return view('teacher', ['user' => $request->session()->get('account_id'),
                'name' => $request->session()->get('user_name'), 'phone' => $request->session()->get('phone_num'),
                'email' => $request->session()->get('mail_addr'), 'students' => $students->all(), 'groups' => $groups->all()]);
        }
    }

    public function insert_works(Request $request)
    {
        $file = $request->file('upfile');

        $upload_date = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i');
        $upload_check = DB::table('item')->where('sID', '=', $request->session()->get('account_id'))
            ->where('itemdate', '=', $upload_date)
            ->get()->all();
        if (count($upload_check) > 0) return "這周已經上傳過了!!";

        $file_rename = hash('sha256', time()) . "." . $file->getClientOriginalExtension();
        $file->move('./upload/', $file_rename);
        DB::table('item')->insertGetId(['sID' => $request->session()->get('account_id'),
            'schedule' => $request->post('thisweek'), 'nschedule' => $request->post('nextweek'),
            'itemdate' => $upload_date, 'file_path' => '/upload/' . $file_rename, 'file_name' => $request->post('file_name')]);
        return "#upload_complete";
    }

    public function select_works(Request $request)
    {
        $start_date = Carbon::parse($request->get('date'))->subDays(7)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i');
        $end_date = Carbon::parse($request->get('date'))->endOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i');
        $results = DB::table('item')->select('item.schedule', 'item.nschedule', 'file_path', 'file_name')
            ->join('sign_in', 'sign_in.sID', '=', 'item.sID')
            ->join('team', 'sign_in.gID', '=', 'team.teamID')
            ->whereBetween('item.itemdate', [$start_date, $end_date])
            ->orderBy('item.itemdate', 'DESC')
            ->get();
        return $results->all();
    }

    public function message(Request $request)
    {
        $act = $request->get('act');
        if ($act == "register")
            return view('message', ['message' => '註冊完成!!', 'back_url' => url('/#login'), 'back' => '返回登入頁面']);
        elseif ($act == "logout") {
            $request->session()->flush();
            return view('message', ['message' => '登出成功!!', 'back_url' => url('/'), 'back' => '結束']);
        } elseif ($act == 'modify')
            return view('message', ['message' => '修改成功!!',
                'back_url' => url('/' . $request->session()->get('account_id') . '/home/#option'), 'back' => '返回']);
        return view('/');
    }

    public function modify(Request $request)
    {
        $pass = $request->session()->get('user_pass');
        if ($request->post('pass') != "") $pass = hash('sha256', $request->post('pass'));
        DB::table($request->session()->get('permission'))
            ->where('ID', '=', $request->session()->get('account_id'))
            ->update(['name' => $request->post('name'), 'email' => $request->post('email'), 'password' => $pass,
                'phone' => $request->post('phone'), 'updated_at' => Carbon::now()]);
        return url('/message/?act=modify');
    }

    public function search_files(Request $request)
    {
        $result = DB::table('sign_in')->join('team', 'sign_in.gID', '=', 'team.teamID')->select('projectname', 'topic')
            ->where('sign_in.tID', '=', $request->session()->get('account_id'))
            ->whereBetween('sign_in.created_at', [($request->get('year')) . '/01/01', ($request->get('year') + 1) . '/01/01'])
            ->get();
        return $result->all();
    }

    public function teacher_get_selection(Request $request)
    {
        $date = Carbon::parse((Carbon::now()->year - 4) . '/06/30')->format('Y-m-d H:i');
        if ($request->get('target') == 'users') {
            $result = DB::table('sign_in')->join('item', 'sign_in.sID', '=', 'item.sID')
                ->select('item.file_path', 'item.file_name', 'item.itemdate')
                ->where('sign_in.tID', '=', $request->session()->get('account_id'))
                ->where('item.sID', '=', $request->get('id'))
                ->where('sign_in.created_at', '>', $date)->get();
            return $result->all();
        } elseif ($request->get('target') == 'team') {
            $result = DB::table('sign_in')->join('item', 'sign_in.sID', '=', 'item.sID')
                ->select('item.file_path', 'item.file_name', 'item.itemdate')
                ->where('sign_in.tID', '=', $request->session()->get('account_id'))
                ->where('sign_in.gID', '=', $request->get('id'))
                ->where('sign_in.created_at', '>', $date)->get();
            return $result->all();
        }
        return "搜尋目標錯誤!!";
    }

    public function teacher_get_student(Request $request)
    {
        $result = DB::table('users')->select('ID', 'name', 'email', 'phone')
            ->where('ID', '=', $request->get('key'))
            ->orWhere('name', '=', $request->get('key'))->get();
        return $result->all();
    }

    public function teacher_create_team(Request $request)
    {
        $auth = Validator::make($request->all(), ['id' => 'required']);
        if ($auth->fails()) return "沒有選擇組員!!";

        $students = explode(";", $request->post('id'));
        array_pop($students);
        DB::table('team')->insertGetId(['topic' => $request->post('description'),
            'projectname' => $request->post('name'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        $teamID = DB::table('team')->select('teamID')
            ->where('topic', '=', $request->post('description'))
            ->where('projectname', '=', $request->post('name'))->orderBy('created_at', 'desc')
            ->get()->first();

        DB::table('ganttchart')->insertGetId(['gID' => $teamID->teamID]);
        foreach ($students as $student)
            DB::table('sign_in')->insertGetId(['tID' => $request->session()->get('account_id'),
                'sID' => $student, 'gID' => $teamID->teamID, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        return url('/' . $request->session()->get('account_id') . '/home/#create_project_complete');
    }

    public function student_search_gantt(Request $request)
    {
        $result = DB::table('ganttchart')->select('work.wid', 'work.content', 'day.start_day', 'day.end_day')
            ->join('work', 'ganttchart.PID', '=', 'work.ganttchart_id')
            ->join('day', 'work.wid', '=', 'day.work_id')
            ->where('ganttchart.gID', '=', $request->post('teamID'))
            ->orderBy('day.start_day', 'ASC')
            ->get();
        return $result->all();
    }

    public function student_modify_gantt(Request $request)
    {
        if ($request->post('modify') == "del") {
            $PID = DB::table('ganttchart')->where('gID', '=', $request->post('gID'))->first()->PID;

            $wid = DB::table('work')->where('ganttchart_id', '=', $PID)
                ->where('content', '=', $request->post('content'))->first()->wid;

            DB::table('day')->where('work_id', '=', $wid)
                ->where('start_day', '=', $request->post('start_day'))
                ->where('end_day', '=', $request->post('end_day'))
                ->delete();

            DB::table('work')->where('ganttchart_id', '=', $PID)
                ->where('content', '=', $request->post('content'))->delete();

            $result = DB::table('ganttchart')->select('work.wid', 'work.content', 'day.start_day', 'day.end_day')
                ->join('work', 'ganttchart.PID', '=', 'work.ganttchart_id')
                ->join('day', 'work.wid', '=', 'day.work_id')
                ->where('ganttchart.gID', '=', $request->post('gID'))
                ->orderBy('day.start_day', 'ASC')
                ->get();
            return $result->all();
        } else {
            $PID = DB::table('ganttchart')->where('gID', '=', $request->post('gID'))->get()->first()->PID;

            DB::table('work')->insertGetId(['ganttchart_id' => $PID, 'content' => $request->post('content')]);

            $wid = DB::table('work')->where('ganttchart_id', '=', $PID)
                ->where('content', '=', $request->post('content'))->first()->wid;

            DB::table('day')
                ->insertGetId(['work_id' => $wid, 'start_day' => $request->post('start_day'), 'end_day' => $request->post('end_day')]);

            $result = DB::table('ganttchart')->select('work.wid', 'work.content', 'day.start_day', 'day.end_day')
                ->join('work', 'ganttchart.PID', '=', 'work.ganttchart_id')
                ->join('day', 'work.wid', '=', 'day.work_id')
                ->where('ganttchart.gID', '=', $request->post('gID'))
                ->orderBy('day.start_day', 'ASC')
                ->get();
            return $result->all();
        }
    }
}

