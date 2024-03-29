let gCal = (function () {
    const myCalndr = {};

    let totalCount = 0;
    let list_quartal = '';
    let listDate = [];
    let year = '';
    let year_pre = '';
    let arr_holyday = [];
    let arr_holyday_pre = [];
    let arr_list_month = [];
    let arr_area_quartal = [];

    const arrListDayWeek = ['понедельник', 'вторник', 'среда', 'четверг', 'пятница'];
    const arrListMonth = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', "Ноябрь", "Декабрь"];
    const arrChbNameId = ['check0', 'check1', 'check2', 'check3', 'check4'];
    const arrAllChbNameId = ['check_all', 'check0', 'check1', 'check2', 'check3', 'check4'];

    const arrDivWeekId = [['mon', 'mon_list'], ['tue', 'tue_list'], ['wed', 'wed_list'], ['thu', 'thu_list'], ['fry', 'fry_list']];
    const arrDivMonthId = ['jan', 'feb', 'march', 'apr', 'may', 'jun', 'jul', 'aug', 'sen', 'oct', "nov", "dec"];

    const arrDivTotal = ['total'];

    const td_style_2 = "<td class='bgr-w-red'>";
    const td_style_3 = '<td class="bgr-w-red-v">';
    const td_style_4 = '<td class="bgr-w-green">';
    const td_style_5 = '<td class="bgr-w-yellow">';
    const td_style_6 = '<td class="bgr-w-gray">-';

    let _getDay = function (date) {
        let day = date.getDay();
        if (day === 0) day = 7;                       //set 0 for Monday, 1 for Tuesday... 6 for Sunday
        return day - 1;
    }

    let _getMonthName = function (month) {
        return arrListMonth[month];
    }

    let _getDivIdFromMonth = function (month) {
        return arrDivMonthId[month];
    }

    let _checkHoliDay = function (arr, day) {
        for (let i = 0; i < arr.length; i++) if (arr[i] === day) return true;
        return false;
    }

    let _checkActDate = function (year, month, day) {
        const date_now = new Date();
        const month_act = date_now.getMonth();
        const date_act = date_now.getDate();
        const year_act = date_now.getFullYear();
        return year_act === year && month_act === month && date_act === day;
    }

    let _checkFirstDate = function (month, day, arr_holiday) {
        const day_first = arr_holiday[12][0];
        const month_first = arr_holiday[12][1] - 1;
        if (month_first === month)
            if (day_first === day) return true;
        return false;
    }


    let _countDay = function (dayOfWeek, arr_month, year, arr_holiday, arr_area_date, subtract=true) {

        //region declaration variable

        const checkbox_id = arrChbNameId[dayOfWeek];
        const checkbox = document.getElementById(checkbox_id);
        const total = document.getElementById(arrDivTotal[0]);

        let count = 0;
        let arr = [];
        const _elem_cap = document.getElementById(arrDivWeekId[dayOfWeek][0]);
        const _elem_list = document.getElementById(arrDivWeekId[dayOfWeek][1]);

        let date, str_yyyy, str_month;

        //endregion variable

        for (let x = 0; x < arr_month.length; x++) {
            date = new Date(year, arr_month[x]);

            str_yyyy = date.getFullYear();
            str_month = arr_month[x] + 1;
            if (str_month < 10) str_month = '0' + str_month;

            let day_week, day_month, flag_canicula;
            while (date.getMonth() === arr_month[x]) {
                day_week = _getDay(date);
                day_month = date.getDate();

                //check canicula
                flag_canicula = false;
                if (arr_month[x] === arr_area_date[0][1] - 1 && day_month < arr_area_date[0][0]) flag_canicula = false;
                else flag_canicula = !(arr_month[x] === arr_area_date[1][1] - 1 && day_month > arr_area_date[1][0]);

                if (day_week === dayOfWeek && !_checkHoliDay(arr_holiday[arr_month[x]], day_month) && flag_canicula) {
                    count++;
                    let str_day = day_month;
                    if (str_day < 10) str_day = '0' + day_month;
                    arr[count - 1] = str_day + '.' + str_month + '.' + str_yyyy;
                }

                date.setDate(day_month + 1);
            }
        }

        //region view

        let list = '';
        for (let i = 0; i < arr.length; i++) list += arr[i] + '<br/>';

        if (checkbox.checked) {
            _elem_cap.innerHTML = '<b>' + arrListDayWeek[dayOfWeek] + ': </b>' + count;
            _elem_list.innerHTML = list;
            gCal.totalCount += count;
            total.innerHTML = 'Всего: <b>' + gCal.totalCount + '</b> учебных дней.';
        }else {
            if(subtract) {
                if (gCal.totalCount > 0) {
                    gCal.totalCount -= count;
                    total.innerHTML = 'Всего: <b>' + gCal.totalCount + '</b> учебных дней.';
                }
                if (gCal.totalCount === 0) {
                    total.innerHTML = '';
                }
                _elem_cap.innerHTML = '';
                _elem_list.innerHTML = '';
            }
        }

        //endregion view
    }

    let _reCountDayAll = function () {
        gCal.totalCount = 0;
        for (let x = 0; x < arrChbNameId.length; x++) {
            _countDay(x, gCal.arr_list_month, gCal.year, gCal.arr_holyday, gCal.arr_area_quartal, false);
        }
    }

    myCalndr.createCalendar = function (month, year, arr_holiday, is_cap=false) {
        let date = new Date(year, month);
        let caption = '';
        if(is_cap) caption = ' ' + year;
        let table = '<table id="table-cap"><th>' + _getMonthName(month) + caption + '</th></table>' +
            '<table class="table-content"><tr><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th>' +
            '<th class="fnt-w">сб</th><th class="fnt-w">вс</th></tr><tr>';
        let td;

        for (let i = 0; i < _getDay(date); i++) table += '<td></td>';                     //empty cell first row

        let day_month, day_week, flag_rest;
        while (date.getMonth() === month) {
            td = '<td>';
            day_week = _getDay(date);
            day_month = date.getDate();
            flag_rest = 0;
            if (day_week === 5 || day_week === 6) {
                td = td_style_2;
                flag_rest = 1;
            }

            if (_checkHoliDay(arr_holiday[month], day_month)) td = td_style_2;
            if (_checkHoliDay(arr_holiday[month], day_month) && flag_rest !== 1) td = td_style_3;
            if (_checkActDate(year, month, day_month)) td = td_style_4;
            if (_checkFirstDate(month, day_month, arr_holiday)) td = td_style_5;

            table += td + date.getDate() + '</td>';

            if (day_week % 7 === 6) table += '</tr><tr>';                 // /r/n for last day
            date.setDate(day_month + 1);
        }

        if (_getDay(date) !== 0)
            for (let i = _getDay(date); i < 7; i++) table += '<td></td>';                 //empty cell

        table += '</tr></table>';

        const _div_id_name = _getDivIdFromMonth(month);
        const _elem = document.getElementById(_div_id_name);
        _elem.innerHTML = table;
    }

    myCalndr.createCalendarAreaDate = function (month, year, _arr_area_quartal, arr_holiday) {
        let date = new Date(year, month);
        let table = '<table id="table-cap"><th>' + _getMonthName(month) + '</th></table>' +
            '<table class="table-content"><tr><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th>' +
            '<th class="fnt-w">сб</th><th class="fnt-w">вс</th></tr><tr>';
        let td;

        for (let i = 0; i < _getDay(date); i++) table += '<td></td>';                     //empty cell first row

        let day_month, day_week, flag_empty, flag_rest;
        while (date.getMonth() === month) {
            td = '<td>';
            day_week = _getDay(date);
            day_month = date.getDate();
            flag_rest = 0;
            flag_empty = 0;

            if (day_week === 5 || day_week === 6) {
                td = td_style_2;
                flag_rest = 1;
            }
            if (_checkHoliDay(arr_holiday[month], day_month) && flag_rest !== 0) td = td_style_2;
            if (_checkHoliDay(arr_holiday[month], day_month) && flag_rest !== 1) td = td_style_3;
            if (_checkActDate(year, month, day_month)) td = td_style_4;
            if (_checkFirstDate(month, day_month, arr_holiday)) td = td_style_5;

            if (month === _arr_area_quartal[0][1] - 1) {                                                            //start month
                if (day_month < _arr_area_quartal[0][0])
                    table += td_style_6 + '</td>';
                else if (month === _arr_area_quartal[1][1] - 1 && day_month > _arr_area_quartal[1][0])               //start date
                    table += td_style_6 + '</td>';
                else
                    table += td + day_month + '</td>';
            } else if (month < _arr_area_quartal[0][1] - 1)                                                           //start month
                table += td_style_6 + '</td>';
            else if (month === _arr_area_quartal[1][1] - 1) {                                                       //end month
                if (day_month > _arr_area_quartal[1][0]) table += td_style_6 + '</td>';
                else table += td + day_month + '</td>';
            } else if (month > _arr_area_quartal[1][1] - 1)                                                          //end month
                table += td_style_6 + '</td>';
            else table += td + day_month + '</td>';

            if (day_week % 7 === 6) table += '</tr><tr>';                                                      // /r/n for last day
            date.setDate(day_month + 1);
        }

        if (_getDay(date) !== 0) for (let i = _getDay(date); i < 7; i++) table += '<td></td>';                        //empty cell for end month
        table += '</tr></table>';

        const _div_id_name = arrDivMonthId[month];
        const _elem = document.getElementById(_div_id_name);
        _elem.innerHTML = table;
    }

    myCalndr.createListingAreaDate = function (month, year, _arr_area_quartal, holiday) {
        let list_date = [];
        let date = new Date(year, month);
        let day_month, day_week, str_month, str_day, str_date;//, flag_add;

        while (date.getMonth() === month) {
            day_week = _getDay(date);
            day_month = date.getDate();

            str_month = (date.getMonth() + 1).toString().padStart(2, "0");
            str_day = date.getDate().toString().padStart(2, "0");
            str_date = str_day + '.' + str_month + '.' + year;

            //flag_add = 0;
            if (day_week < 5 && !_checkHoliDay(holiday[month], day_month)) {
                if (month === _arr_area_quartal[0][1] - 1) {                                              //start date
                    if (day_month > _arr_area_quartal[0][0] - 1) {
                        list_date.push(str_date);
                        //flag_add = 1;
                    } else if (month === _arr_area_quartal[1][1] - 1 && day_month < _arr_area_quartal[1][0] + 1)  //end date                                            //start date
                        list_date.push(str_date);
                } else if (month === _arr_area_quartal[1][1] - 1) {                                         //end date
                    if (day_month < _arr_area_quartal[1][0] + 1)
                        list_date.push(str_date);
                } else if (month > _arr_area_quartal[0][1] - 1 && month < _arr_area_quartal[1][1] - 1) {
                    list_date.push(str_date);
                }
            }
            date.setDate(day_month + 1);
        }
        return list_date;
    }

    myCalndr.countDayAll = function (elem_check) {
        gCal.totalCount = 0;
        const checkbox = document.getElementById(elem_check);
        if (checkbox.checked) {
            for (let x = 0; x < arrChbNameId.length; x++) {
                document.getElementById(arrChbNameId[x]).checked = true;
                _countDay(x, gCal.arr_list_month, gCal.year, gCal.arr_holyday, gCal.arr_area_quartal);
            }
        } else {
            for (let x = 0; x < arrChbNameId.length; x++) {
                document.getElementById(arrChbNameId[x]).checked = false;
                _countDay(x, gCal.arr_list_month, gCal.year, gCal.arr_holyday, gCal.arr_area_quartal);
            }
        }
    }

    myCalndr.countDayOfWeek = function (dayOfWeek) {
        _countDay(dayOfWeek, gCal.arr_list_month, gCal.year, gCal.arr_holyday, gCal.arr_area_quartal);

        if(!document.getElementById(arrChbNameId[dayOfWeek]).checked) {
                document.getElementById(arrAllChbNameId[0]).checked = false;
        }else {
            let count = 0;
            for (let z = 0; z < arrChbNameId.length; z++) {
                if (document.getElementById(arrChbNameId[z]).checked) count++;
            }
            if (count === 5) {
                document.getElementById(arrAllChbNameId[0]).checked = true;
            }
        }
    }

    myCalndr.loadPickerDate = function (elem_date_start, elem_date_end) {
        let _id = document.getElementById(elem_date_start);
        let _day = gCal.arr_area_quartal[0][0].toString().padStart(2, "0");
        let _month = gCal.arr_area_quartal[0][1].toString().padStart(2, "0");
        _id.value = _day + '.' + _month + '.' + gCal.year;

        _id = document.getElementById(elem_date_end);
        _day = gCal.arr_area_quartal[1][0].toString().padStart(2, "0");
        _month = gCal.arr_area_quartal[1][1].toString().padStart(2, "0");
        _id.value = _day + '.' + _month + '.' + gCal.year;
    }

    myCalndr.setAreaQuartal = function (elem_date_start, elem_date_end) {
        let date_val = document.getElementById(elem_date_start).value;
        let date_arr = date_val.split('.');
        if (date_arr.length !== 3) alert('Введите начальную дату!');
        const day_start = parseInt(date_arr[0], 10);
        const month_start = parseInt(date_arr[1], 10);

        date_val = document.getElementById(elem_date_end).value;
        date_arr = date_val.split('.');
        if (date_arr.length !== 3) alert('Введите конечную дату!');
        const day_end = parseInt(date_arr[0], 10);
        const month_end = parseInt(date_arr[1], 10);

        gCal.arr_area_quartal = [[day_start, month_start], [day_end, month_end]];
        //console.log(gCal.arr_area_quartal);

        for (let i = 0; i < gCal.arr_list_month.length; i++) {
            gCal.createCalendarAreaDate(gCal.arr_list_month[i], gCal.year, gCal.arr_area_quartal, gCal.arr_holyday);
        }
        _reCountDayAll();

        /** call function from 'util.js' */
        gShrd.showLoadingButtonDivBlock('dpckr-bt-save');
        gShrd.hideLoadingButtonDivBlock('dpckr-bt-save', 10000);
        let str = _createCoockieFromCheckboxState();
        if(gShrd.cookieExists(gCal.list_quartal)) {
            document.cookie = gCal.list_quartal + "=" + str;
        }else{
            let expires = new Date(new Date().getTime() + 60 * 60 * 24 * 365 * 1000).toGMTString();
            document.cookie = gCal.list_quartal + "=" + str + ";expires=" + expires + ";samesite=lax";
        }
    }

    let _createCoockieFromCheckboxState = function () {
        let out = '';
        for (let z = 0; z < arrAllChbNameId.length; z++) {
            if (document.getElementById(arrAllChbNameId[z]).checked === true)
                out += '1';
            else out += '0';
            if(z < 5) out += '-';
        }
        return out;
    }

    myCalndr.acceptCoockie = function (timeout=3000) {
        const div = document.createElement('div');
        div.id = 'acceptcoockie';
        div.innerHTML = 'This website use cookies ';
        const bt = document.createElement('button');
        bt.innerHTML = 'Accept';
        div.append(bt)
        document.body.append(div);
        if (timeout !== 0) {
            setTimeout(() => div.remove(), timeout);
        }
        $(document).ready(function () {
            if (!!localStorage.getItem("cookieconsent")) {
                document.body.classList.add("cookieconsent")
            } else {
                $("button").click(function () {
                    localStorage.setItem("cookieconsent", "ok")
                    $("#acceptcoockie").fadeOut();
                });
            }
        });
    }

    myCalndr.acceptCoockieFull = function (timeout=3000) {
        const div = document.createElement('div');
        div.id = 'acceptcoockie';
        div.innerHTML = 'This website use cookies ';

        const bt = document.createElement('button');
        bt.innerHTML = 'accept';
        div.append(bt);

        document.head.insertAdjacentHTML("beforeend", `
             <style>
                 #acceptcoockie {
                     display: none;
                     height: 9%;
                     padding: 1.6% 1.5% 1.5% 1.5%;
                     margin: auto 1.5%;
                     background: rgb(21, 10, 10);
                     border-radius: 10px;
                     box-shadow: 0 0 6px 0 rgb(21, 10, 10);
                     color: white;
                     bottom: 0;
                     left: 0;
                     right: 0;
                     position: fixed;
                 }
                 
                 #acceptcoockie button {
                     width: 4%;
                     margin: 0 0 0 10px;
                 }
                 
                 body:not(.cookieconsent) #acceptcoockie {
                     display: block;
                 }
             </style>`);

        document.body.append(div);
        if (timeout !== 0) {
            setTimeout(() => div.remove(), timeout);
        }
        $(document).ready(function () {
            if (!!localStorage.getItem("cookieconsent")) {
                document.body.classList.add("cookieconsent")
            } else {
                $("button").click(function () {
                    localStorage.setItem("cookieconsent", "ok")
                    $("#acceptcoockie").fadeOut();
                });
            }
        });
    }

    let _restateListCheckbox = function (arrName, isBool){
        //for (let z = 0; z < arrName.length; z++) {
        for (let _arr of arrName) {
            const chb = document.getElementById(_arr);
            chb.checked = isBool;
        }
    }

    let _clickListCheckbox = function (arrName){
        for (let z = 0; z < arrName.length; z++) {
            const chb = document.getElementById(arrName[z]);
            chb.click();
        }
    }

    let _clickListCheckboxForKeyword = function (arrName, arrValue, strKeyword){
        for (let z = 0; z < arrName.length; z++) {
            if (arrValue[z] === strKeyword) {
                const chb = document.getElementById(arrName[z]);
                chb.click();
            }
        }
    }

    let _setListCheckbox = function (arrName, arrValue, strKeyword){
        for (let z = 0; z < arrName.length; z++) {
            if (arrValue[z] === strKeyword) {
                const chb = document.getElementById(arrName[z]);
                chb.checked = true;
            }
        }
    }

    let _setCheckboxStateFromCoockie_old = function (coockiename) {
        let coockex = gShrd.cookieExists(coockiename);
        //console.log('coockex: ' + coockex);
        if(coockex) {
            let str_arr = gShrd.readCookie(coockiename);
            //console.log('coockex2: ' + str_arr);
            let arr_value = str_arr.split("-");
            //console.log('coockex3: ' + arr_value[2]);
            for (let z = 0; z < arrAllChbNameId.length; z++) {
                if (arr_value[z] === '1') {
                    const chb = document.getElementById(arrAllChbNameId[z]);
                    chb.checked = true;
                }
            }
        }
    }

    myCalndr.setCheckboxStateFromCoockie = function (str_value) {
        if(str_value !== "") {
            _restateListCheckbox(arrAllChbNameId, false);
            gCal.totalCount = 0;
            let arr_value = str_value.split("-");
            if(arr_value[0] === '1') {
                document.getElementById(arrAllChbNameId[0]).checked = true;
                _clickListCheckbox(arrChbNameId);
            }else{
                _clickListCheckboxForKeyword(arrAllChbNameId, arr_value, '1')
            }
        }
    }

    myCalndr.getAreaDateList = function (elem) {
        gCal.listDate = [];
        for (let i = 0; i < gCal.arr_list_month.length; i++) {
            let arr_add = gCal.createListingAreaDate(gCal.arr_list_month[i], gCal.year, gCal.arr_area_quartal, gCal.arr_holyday);
            gCal.listDate.push.apply(gCal.listDate, arr_add);
        }

        let list_view = '';
        for (let i = 0; i < gCal.listDate.length; i++) {
            list_view += gCal.listDate[i] + '\n';
        }
        //const view_id = document.getElementById("mon_list");
        gCl.copyToClipboard(list_view);
        const copy_id = document.getElementById(elem);
        copy_id.style.background = '#d9e1ec';
    }

    return myCalndr;
})();