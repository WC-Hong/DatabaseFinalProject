@extends('web_template')

@section('title', '教師首頁')

@section('home_title')
    <div class="inner">
        <h1>歡迎，{{$name}} 老師</h1>
        <p>人生在世，最重要的不是自己處境如何，而是你如何看待自己的處境。</p>
    </div>
@endsection

@section('options')
    <ul>
        <li>
            <a href="#search_upload_data">上傳資料</a>
        </li>
        <li>
            <a href="#project_search">查詢專題項目</a>
        </li>
        <li>
            <a href="#create_project">建立專題組別</a>
        </li>
        <li>
            <a href="#options">選項</a>
        </li>
    </ul>
@endsection

@section('body')
    <!-- upload_data -->
    <article id="search_upload_data">
        <h2 class="major">上傳資料</h2>
        <div id="teacher_search_message" style="background-color: #c51f1a;color: white;text-align: center"></div>
        <form>
            <div class="fields">
                <div class="field">
                    <ul class="actions">
                        <li><input type="button" id="search_upload_student" class="primary" value="學生" onclick="search_by('student')"></li>
                        <li><input type="button" id="search_upload_group" value="組別" onclick="search_by('group')" /></li>
                    </ul>
                </div>
                <div class="field" id="student_name_selection">
                    <label for="search">名稱搜尋</label>
                    <select name="demo-category" id="student_list">
                        <option value="">----------------------------</option>
                        @foreach($students as $student)
                            <option value="{{$student->ID}}">{{$student->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field" id="group_name_selection" hidden>
                    <label for="search">名稱搜尋</label>
                    <select name="demo-category" id="group_list">
                        <option value="">----------------------------</option>
                        @foreach($groups as $group)
                            <option value="{{$group->teamID}}">{{$group->projectname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field ">
                    <label for="calendar">選則日期</label>
                    <input type="date" id="search_date" name="calendar" class="calendarSelectDate" />
                    <div class="table-wrapper" id="download_item" hidden>
                        <br>
                        <label for="nextweek">搜尋出的檔案</label>
                        <table>
                            <thead>
                            <tr>
                                <th>檔案名稱</th>
                                <th>上傳日期</th>
                                <th>連結</th>
                            </tr>
                            </thead>
                            <tbody id="file_table">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="field">
                    <input type="button" value="查詢" class="primary" onclick="teacher_calendar_research('{{url('/tea/selection/')}}')" />
                </div>
            </div>
        </form>
    </article>

    <!-- ynstuupload -->
    <article id="ynstuupload">
        <form method="post" action="#">
            <h2 class="major">是否繼續查詢？</h2>
            <br>
            <ul class="actions">
                <li>
                    <a href="#stu_uploadt" class="button primary">是</a>
                </li>
                <li>
                    <a href="student.html" class="button">否</a>
                </li>
            </ul>
        </form>
    </article>

    <!-- team_upload -->
    <article id="team_upload">
        <h2 class="major">組別上傳資料查詢</h2>
        <form method="post" action="#">
            <div class="fields">
                <div class="field half">
                    <label for="team">組別</label>
                    <input type="text" name="team">
                </div>
            </div>
            <br>
            <input type="text" class="calendarSelectDate" />
            <br>
            <br>
            <ul class="actions">
                <li>
                    <input type="submit" value="查詢" class="primary" />
                </li>
            </ul>
        </form>
    </article>

    <!-- ynteamupload -->
    <article id="ynteamupload">
        <form method="post" action="#">
            <h2 class="major">是否繼續查詢？</h2>
            <br>
            <ul class="actions">
                <li>
                    <a href="#team_upload" class="button primary">是</a>
                </li>
                <li>
                    <a href="student.html" class="button">否</a>
                </li>
            </ul>
        </form>
    </article>

    <!-- project_search -->
    <article id="project_search">
        <h2 class="major">查詢專題項目</h2>
        <form method="post" action="#">
            <div class="fields">
                <div class="field">
                    <label for="demo-category">年份</label>
                    <select name="demo-category" id="select_item_by_year" onchange="search_by_year('{{url('/tea/search/group/')}}')">
                        <option value="">----------------------------</option>
                        <script>
                            var x = document.getElementById("select_item_by_year");
                            for (var i = 2018; i < 2025; i++) {
                                x.innerHTML += "<option value=\"" + i + "\">" + i + "</option>"
                            }
                        </script>
                    </select>
                </div>

                <div class="field">
                    <div class="table-wrapper" id="table_item_by_year">
                        <label for="nextweek">搜尋出的檔案</label>
                        <table>
                            <thead>
                            <tr>
                                <th>組別名稱</th>
                                <th>描述</th>
                            </tr>
                            </thead>
                            <tbody id="table_item_groups_table">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </article>

    <!-- create_project -->
    <article id="create_project">
        <h2 class="major">建立專題組別</h2>
        <div class="field" style="background-color: #c51f1a;color: white;text-align: center" id="teacher_create_project_message"></div>
        <form method="post" action="#">
            <div class="fields">
                <div class="field half">
                    <label for="set_project_name">搜尋學生(請輸入姓名或學號)</label>
                    <input type="text" name="teacher_create_project_search_student_input" />
                </div>
                <div class="field half">
                    <label for="set_project_name">&nbsp;</label>
                    <input type="button" value="搜尋" class="primary" onclick="location.href='#search_student';teacher_search_student('{{url('/tea/search/student/')}}')" />
                </div>
                <div class="field">
                    <label for="set_project_name">組員名單:</label>
                    <ul id="team_list">
                    </ul>
                </div>
                <div class="field">
                    <label for="set_project_name">組別名稱</label>
                    <input type="text" id="teacher_create_project_name" />
                </div>
                <div class="field">
                    <label for="set_project_name">組別描述(100字以內)</label>
                    <textarea style="resize: none;" id="teacher_create_project_description"></textarea>
                </div>
                <br>
            </div>
            <ul class="actions">
                <li>
                    <input type="button" value="建立" class="primary" onclick="teacher_create_team('{{url('/tea/create_team/')}}')" />
                </li>
            </ul>
        </form>
    </article>

    <!-- search_student -->
    <article id="search_student">
        <h2 class="major">建立專題組別</h2>
        <div class="field" id="teacher_search_student_message"></div>
        <form method="post" action="#">
            <div class="fields">
                <div class="field half">
                    <label for="set_project_name">搜尋學生(請輸入姓名或學號)</label>
                    <input type="text"  name="teacher_create_project_search_student_input" />
                </div>
                <div class="field half">
                    <label for="set_project_name">&nbsp;</label>
                    <input type="button" value="搜尋" class="primary" onclick="teacher_search_student('{{url('/tea/search/student/')}}')" />
                    <input type="button" value="返回" style="margin-left: 30px" onclick="location.href='#create_project'" />
                </div>

                <div class="field">
                    <div class="table-wrapper">
                        <label for="nextweek">搜尋出的學生資料</label>
                        <table>
                            <thead>
                            <tr>
                                <th>學號</th>
                                <th>姓名</th>
                                <th>電子郵件</th>
                                <th>電話</th>
                                <th>備註</th>
                            </tr>
                            </thead>
                            <tbody id="teacher_search_student_list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </article>

    <!-- create_project_complete -->
    <article id="create_project_complete">
        <form method="post" action="#">
            <h2 class="major">組別建立完畢!</h2>
            <br>
            <ul class="actions">
                <li>
                    <a href="#create_project" class="button primary">繼續建立組別</a>
                </li>
                <li>
                    <a href="#" class="button">回到首頁</a>
                </li>
            </ul>
        </form>
    </article>

    <!-- options -->
    <article id="options">
        <h2 class="major">選項</h2>
        <br>
        <form method="post" action="#">
            <ul class="actions">
                <li><input type="button" value="修改個人資料" onclick="location.href='#change_account'" class="primary" /></li>
                <li><input type="button" value="登出" onclick="location.href='#is_logout'" /></li>
            </ul>
        </form>
    </article>

    <!-- change_account -->
    @include('modify_check')

    <!-- logout -->
    @include('logout_check')
@endsection