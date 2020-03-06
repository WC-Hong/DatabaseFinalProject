function login_to(url) {
    var test = document.getElementById("login_message");
    var user = document.getElementById("login_user").value;
    var pass = document.getElementById("login_pass").value;
    var auth = document.getElementById("login_auth").value;

    var formdata = new FormData();
    formdata.append("user", user);
    formdata.append("pass", pass);
    formdata.append("auth", auth);

    for (var entry of formdata.entries()) {
        if (entry[1] == ""){
            test.innerText = "每個欄位都是必填!!";
            return;
        }
    }

    var req = new XMLHttpRequest();
    var metas = document.getElementsByTagName('meta');
    req.open("post", url, true);
    for (i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }

    req.onload = function () {
        if (this.responseText.indexOf("!!") == -1){
            window.location = this.responseText;
        } else {
            test.innerText = this.responseText;
        }
    };
    req.send(formdata);
} //Done.

function register_to(url) {
    var test = document.getElementById("register_message");
    var metas = document.getElementsByTagName('meta');
    var user = document.getElementById("register_user").value;
    var identity = null;
    if (document.getElementById("demo-priority-low").checked) identity = document.getElementById("demo-priority-low").value;
    else identity = document.getElementById("demo-priority-high").value;
    var pass = document.getElementById("register_pass").value;
    var pass2 = document.getElementById("register_pass2").value;
    var name = document.getElementById("register_name").value;
    var tel = document.getElementById("register_tel").value;
    var email = document.getElementById("register_email").value;
    var auth = document.getElementById("register_auth").value;

    var formdata = new FormData();
    formdata.append("user", user);
    formdata.append("identity", identity);
    formdata.append("pass", pass);
    formdata.append("name", name);
    formdata.append("tel", tel);
    formdata.append("email", email);
    formdata.append("auth", auth);

    for (var entry of formdata.entries()) {

        if (entry[1] == ""){
            test.innerText = "每個欄位都是必填!!";
            return;
        }
    }

    if (pass != pass2){
        test.innerText = "密碼不相同";
        document.getElementById("register_pass").value = "";
        document.getElementById("register_pass2").value = "";
        return;
    }

    var req = new XMLHttpRequest();
    req.open("post", url, true);
    for (i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }
    req.onload = function () {
        if (this.responseText.indexOf("!!") == -1){
            window.location = this.responseText;
        } else {
            test.innerText = this.responseText;
        }
    };
    req.send(formdata);
} //Done.

function change_account(url) {
    var test = document.getElementById("change_message");
    var metas = document.getElementsByTagName('meta');
    var user = document.getElementById("user");
    if (document.getElementById("pass").value != document.getElementById("pass2").value){
        test.innerText = "密碼不相同!!";
        return;
    }
    var pass = document.getElementById("pass");
    var name = document.getElementById("name");
    var phone = document.getElementById("phone");
    var email = document.getElementById("email");

    var formdata = new FormData();
    formdata.append("user", user.value);
    formdata.append("name", name.value);
    formdata.append("phone", phone.value);
    formdata.append("email", email.value);

    for (var entry of formdata.entries()) {
        if (entry[1] == ""){
            test.innerText = "每個欄位都是必填!!";
            return;
        }
    }

    formdata.append("pass", pass.value);

    postRequest(url, formdata);
}

function change_pass() {
    var modify_pass = document.getElementById("demo-priority-high");
    if (modify_pass.checked) {
        document.getElementById("pass").disabled = true;
        document.getElementById("pass2").disabled = true;
    }  else {
        document.getElementById("pass").disabled = false;
        document.getElementById("pass2").disabled = false;
    }
}

function postRequest(target_url, formData) {
    var metas = document.getElementsByTagName('meta');
    var req = new XMLHttpRequest();
    req.open("post", target_url, true);
    for (i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }
    req.onload = function () {
        return this.responseText;
    };
    req.send(formData);
}

function student_calendar_research(url) {
    var download_area = document.getElementById("download_item");
    var up_date = new Date(document.getElementById("upload_date").value);
    var group_name = document.getElementById("demo-category").value;
    if (up_date != ""){
        document.getElementById("date_fill_message").innerText = "";
        var year = up_date.getFullYear();
        var month = up_date.getMonth() + 1;
        var date = up_date.getDate();

        var target_date = year + "/" + month + "/" + date;

        var req = new XMLHttpRequest();
        req.open("get", url + "?date=" + target_date + "&group=" + group_name);

        req.onload = function () {
            download_area.innerHTML = "";
            var result_array = JSON.parse(this.responseText);
            if (result_array[1] == undefined)  document.getElementById("search_last_week").value = "沒有找到資料!!";
            else {
                document.getElementById("search_last_week").value = result_array[1].nschedule;
                download_area.innerHTML += "<li><a download href=\".." + result_array[1]['file_path'] + "\">" + result_array[1]['file_name'] + "</a></li>";
            }
            if (result_array[0] == undefined){
                document.getElementById("search_this_week").value = "沒有找到資料!!";
                document.getElementById("search_next_week").value = "沒有找到資料!!";
            } else {
                document.getElementById("search_this_week").value = result_array[0].schedule;
                document.getElementById("search_next_week").value = result_array[0].nschedule;
                download_area.innerHTML += "<li><a download href=\".." + result_array[1]['file_path'] + "\">" + result_array[0]['file_name'] + "</a></li>";
            }

            window.location = "#display_progress";
        };
        req.send();
        //location.href="#fillin";
    }
    else
        document.getElementById("date_fill_message").innerText += "日期欄位不能是空白";
}// get 參數要改成 date與groupID

function search_by(clicker) {
    var student_btn = document.getElementById("search_upload_student");
    var student_div = document.getElementById('student_name_selection');
    var group_btn = document.getElementById("search_upload_group");
    var group_div = document.getElementById('group_name_selection');

    if (clicker == "student") {
        student_btn.setAttribute("class", "primary");
        group_btn.setAttribute("class", "");
        student_div.hidden = false;
        group_div.hidden = true;
    } else {
        student_btn.setAttribute("class", "");
        group_btn.setAttribute("class", "primary");
        student_div.hidden = true;
        group_div.hidden = false;
    }
}

function teacher_calendar_research(url) {
    var test = document.getElementById("teacher_search_message");
    var target = document.getElementById("search_upload_student");
    var target_id;
    if (target.getAttribute("class") == "primary") {
        target_id = document.getElementById("student_list").value;
        url += "?target=users";
    } else {
        target_id = document.getElementById("group_list").value;
        url += "?target=group";
    }

    var calendar = document.getElementById("search_date").value;
    var result_item = document.getElementById("download_item");

    if (calendar == "") {
        test.innerText = "尚未選則時間!!";
        return ;
    } else if (target_id.value == "----------------------------") {
        test.innerText = "尚未選擇搜尋名稱!!"
        return ;
    }

    url += "&id=" + target_id + "&date=" + calendar;


    var req = new XMLHttpRequest();

    req.open("get", url);
    req.onload = function () {
        var list_table = document.getElementById("file_table");
        var list = JSON.parse(this.responseText);
        result_item.hidden = false;
        list_table.innerHTML = "";
        list.forEach(function (element) {
            list_table.innerHTML += "<tr>" +
                "<td>" + element["file_name"] + "</td>" +
                "<td>" + element["itemdate"] + "</td>" +
                "<td><a download='' href='" + element["file_name"] + "'>點我下載</a></td>" +
                "</tr>";
        });
    };
    req.send();
    //test.innerText = getRequest_noDirect(url);
    /*var list = JSON.parse(getRequest_noDirect(url));
    result_item.hidden = false;
    result_item.innerHTML = "";
    list.forEach(function (element) {
        result_item.innerHTML += "<li><a download=\"\" href=\"" + element["file_path"] + "\">" + element["file_name"] + "</a></li>";
    });*/
}

function upload_work_item(url) {
    var test = document.getElementById("upload_message");
    var upload_file = document.getElementById("upload").files[0];
    var upload_this_week_report = document.getElementById("insert_this_week").value;
    var upload_next_week_report = document.getElementById("insert_next_week").value;
    var file_name = document.getElementById("upload").value.split("\\").pop();

    var formdata = new FormData();
    formdata.append("thisweek", upload_this_week_report);
    formdata.append("nextweek", upload_next_week_report);

    for (var entry of formdata.entries()) {
        if (entry[1] == ""){
            test.innerText = "每個欄位都是必填!!";
            return;
        }
    }

    if (upload_file == undefined) {
        test.innerText = "未選擇上傳檔案!!";
        return;
    }

    formdata.append("upfile", upload_file);
    formdata.append("file_name", file_name);

    var metas = document.getElementsByTagName('meta');
    var req = new XMLHttpRequest();
    req.open("post", url, true);
    for (i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }
    req.onload = function () {
        window.location = this.responseText;
    };
    req.send(formdata);
}

function search_by_year(url) {
    url += "?year=" + document.getElementById("select_item_by_year").value;

    var req = new XMLHttpRequest();
    req.open("get", url);
    req.onload = function () {
        var list_table = document.getElementById("table_item_groups_table");
        var list = JSON.parse(this.responseText);
        list_table.innerHTML = "";
        list.forEach(function (element) {
            list_table.innerHTML += "<tr>" +
                "<td>" + element["projectname"] + "</td>" +
                "<td>" + element["topic"] + "</td>" +
                "</tr>";
        });
    };
    req.send();
}

function teacher_search_student(url) {
    var test = document.getElementById("teacher_search_student_message");
    var key_word_input_text = document.getElementsByName("teacher_create_project_search_student_input");
    var key_word;
    if (key_word_input_text[0].value != "") {
        key_word = key_word_input_text[0].value;
        key_word_input_text[0].value = "";
        key_word_input_text[1].value = "";
        test.innerText = "";
    } else if(key_word_input_text[1].value != "") {
        key_word = key_word_input_text[1].value;
        test.innerText = "";
    } else {
        test.setAttribute("style", "background-color: #c51f1a;color: white;text-align: center");
        test.innerText = "搜尋訊框沒有文字!!";
        return ;
    }

    url += "?key=" + key_word;

    var req = new XMLHttpRequest();
    req.open("get", url);
    req.onload = function () {
        var list_table = document.getElementById("teacher_search_student_list");
        var list = JSON.parse(this.responseText);
        list_table.innerHTML = "";
        list.forEach(function (element) {
            list_table.innerHTML += "<tr>" +
                "<td>" + element["ID"] + "</td>" +
                "<td>" + element["name"] + "</td>" +
                "<td>" + element["email"] + "</td>" +
                "<td>" + element["phone"] + "</td>" +
                "<td><a href=\"javascript:void(0);\" onclick=\"teacher_add_student('" + element["ID"] + "', '" + element["name"] + "');\">點擊加入</a></td>" +
                "</tr>";
        });
    };
    req.send();
}

function teacher_add_student(id, value) {
    document.getElementById("teacher_search_student_message").setAttribute("style", "background-color: limegreen;color: white;text-align: center");
    document.getElementById("teacher_search_student_message").innerText = "新增成功!!";
    document.getElementById("team_list").innerHTML += "<li><a value=\"" + id + "\" href=\"javascript:void(0);\" onclick=\"teacher_delete_student('" + value + "')\">" + value + "(點擊刪除)</a></li>";
} //注意可不可以重複

function teacher_delete_student(value) {
    document.getElementById("teacher_search_student_message").innerText = document.getElementById("team_list").children[0].getAttribute("value");
    for (var i = 0; i < document.getElementById("team_list").children.length ; i++){
        if (document.getElementById("team_list").children[i].innerHTML.indexOf(value) > -1)
            document.getElementById("team_list").removeChild(document.getElementById("team_list").childNodes[i]);
    }
}

function teacher_create_team(url) {
    var test = document.getElementById("teacher_create_project_message");
    var student_list = "";
    var team_name = document.getElementById("teacher_create_project_name").value;
    var team_description = document.getElementById("teacher_create_project_description").value;

    for (var i = 0; i < document.getElementById("team_list").children.length; i++)
        student_list += document.getElementById("team_list").children[i].children[0].getAttribute('value') + ";";

    var formdata = new FormData();
    formdata.append("id", student_list);
    formdata.append('name', team_name);
    formdata.append('description', team_description);

    var metas = document.getElementsByTagName('meta');
    var req = new XMLHttpRequest();
    req.open("post", url, true);
    for (i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }
    req.onload = function () {
        if (this.responseText.indexOf("!!") > -1)
            test.innerText = this.responseText;
        else
            window.location = this.responseText;
    };
    req.send(formdata);
} //新增成功會有undefined message

function student_search_gantt(url) {
    var id = document.getElementById("student_gant_search_gantt").value;

    url += "?teamID=" + id;
    var req = new XMLHttpRequest();
    req.open("get", url);
    req.onload = function () {
        //document.getElementById("student_gant_show_gantt").innerText = "";
        var gantt_data = JSON.parse(this.responseText);
        var data = [];

        document.getElementById("gantt").innerHTML = "";
        gantt_data.forEach(function (element) {
            data.push(
                {start: element["start_day"],
                   end: element["end_day"],
                  name: element["content"],
                    id: "Task " + element["wid"],
              progress: 100});
        });

        new Gantt("#gantt", data).change_view_mode('Week');
    };
    req.send();
} //沒有資料的時候還是會顯示前一組甘特圖

function student_list_gantt(url) {
    var id = document.getElementById("student_gant_search_gantt").value;
    document.getElementById("student_modify_gantt_modify_work_list").innerHTML = "";
    var req = new XMLHttpRequest();
    req.open("get", url + "/stu/gantt/search/?teamID=" + id);
    req.onload = function () {
        var gantt_data = JSON.parse(this.responseText);
        var i = 0;
        gantt_data.forEach(function (element) {
            document.getElementById("student_modify_gantt_modify_work_list").innerHTML += "<tr>" +
                "<td>" + element["content"] + "</td>" +
                "<td>" + element["start_day"] + "</td>" +
                "<td>" + element["end_day"] + "</td>" +
                "<td><a href=\"javascript:void(0)\" onclick=\"student_modify_gantt('" + url + "/stu/gantt/modify', 'delete_" + i + "')\" modify_id=\"" + i + "\">刪除</a></td>" +
                "</tr>";
            i++;
        });
    };
    req.send();
}

function student_modify_gantt(url, command) {
    if (command.indexOf("delete") > -1) {

        var id = command.split("_")[1];

        var list = document.getElementById("student_modify_gantt_modify_work_list").children;
        for (var i = 0; i < list.length; i++) {
            if (list[i].children[3].children[0].getAttribute("modify_id") == id) {
                var formdata = new FormData();
                formdata.append("modify", "del");
                formdata.append("gID", document.getElementById("student_gant_search_gantt").value);
                formdata.append("start_day", list[i].children[1].innerText);
                formdata.append("end_day", list[i].children[2].innerText);
                formdata.append("content", list[i].children[0].innerText);

                var metas = document.getElementsByTagName('meta');
                var req = new XMLHttpRequest();
                req.open("post", url, true);
                for (i = 0; i < metas.length; i++) {
                    if (metas[i].getAttribute("name") == "csrf-token") {
                        req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
                    }
                }
                req.onload = function () {
                    var gantt_data = JSON.parse(this.responseText);
                    var i = 0;
                    document.getElementById("student_modify_gantt_modify_work_list").innerHTML = "";
                    gantt_data.forEach(function (element) {
                        document.getElementById("student_modify_gantt_modify_work_list").innerHTML += "<tr>" +
                            "<td>" + element["content"] + "</td>" +
                            "<td>" + element["start_day"] + "</td>" +
                            "<td>" + element["end_day"] + "</td>" +
                            "<td><a href=\"javascript:void(0)\" onclick=\"student_modify_gantt('" + url + "/stu/gantt/modify','delete_" + i + "')\" modify_id=\"" + i + "\">刪除</a></td>" +
                            "</tr>";
                        i++;
                    });
                };
                req.send(formdata);
            }
        }
    } else {
        var content = document.getElementById("student_modify_gantt_content").value;
        var start = document.getElementById("student_modify_gantt_start").value;
        var end = document.getElementById("student_modify_gantt_end").value;
        var gID = document.getElementById("student_gant_search_gantt").value;

        //document.getElementById("student_modify_gantt_message").innerText = start;
        var formdata = new FormData();
        formdata.append("modify", "add");
        formdata.append("gID", gID);
        formdata.append("start_day", start);
        formdata.append("end_day", end);
        formdata.append("content", content);

        var metas = document.getElementsByTagName('meta');
        var req = new XMLHttpRequest();
        req.open("post", url, true);
        for (i = 0; i < metas.length; i++) {
            if (metas[i].getAttribute("name") == "csrf-token") {
                req.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
            }
        }
        req.onload = function () {
            var gantt_data = JSON.parse(this.responseText);
            var i = 0;
            document.getElementById("student_modify_gantt_modify_work_list").innerHTML = "";
            gantt_data.forEach(function (element) {
                document.getElementById("student_modify_gantt_modify_work_list").innerHTML += "<tr>" +
                    "<td>" + element["content"] + "</td>" +
                    "<td>" + element["start_day"] + "</td>" +
                    "<td>" + element["end_day"] + "</td>" +
                    "<td><a href=\"javascript:void(0)\" onclick=\"student_modify_gantt('" + url + "/stu/gantt/modify','delete_" + i + "')\" modify_id=\"" + i + "\">刪除</a></td>" +
                    "</tr>";
                i++;
            });
        };
        req.send(formdata);
    }
} //Done.