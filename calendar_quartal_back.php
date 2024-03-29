<?php
include_once __DIR__ . '/calendar_root_inc.php';
include_once __DIR__ . '/Settings.php';
include_once __DIR__ . '/sql/CalendarSqlHelper.php';
$set = new Settings();
$mysql = new CalendarSqlHelper();

$year = '2024';
$caption = '2023-2024';
$page = 4;
$holyday = $set->holyday2024;

$cap_quartal = 'III';
$this_quartalColumn = $set->quartalTableColumn[2];
$this_checklistColumn = $set->checklistTableColumn[2];
$view_quartal_top = '/shablons/shared_quartal_top_23_24_iii.php';
$list_month_23_24 = $set->list_month_iii_23_24;
$long_quartal_23_24 = $set->long_quartal_iii_23_24;
$q = 'iii';

if (isset($_GET['year']) && $_GET['year'] == '2024-2025') {
    $year = '2025';
    $caption = '2024-2025';
    $holyday = $set->holyday2025;
    $page = 5;
}

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    if ($q == 'iv') {
        $cap_quartal = 'IV';
        $set = new Settings();
        $this_quartalColumn = $set->quartalTableColumn[3];
        $this_checklistColumn = $set->checklistTableColumn[3];
        $view_quartal_top = '/shablons/shared_quartal_top_23_24_iv.php';
        $list_month_23_24 = $set->list_month_iv_23_24;
        $long_quartal_23_24 = $set->long_quartal_iv_23_24;
    }
} else {
    exit();
}

?>
<!DOCTYPE HTML>
<html lang='ru-RU'>
<head>
    <title>calendar <?= $caption; ?></title>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='<?= CALENDAR_ROOT; ?>static/quartal.css?<?= _version('quartal.css'); ?>' rel='stylesheet'>
    <link href='<?= CALENDAR_ROOT; ?>static/modal-w.css' rel='stylesheet'>
    <script src='<?= CALENDAR_ROOT; ?>static/calendar.js?<?= _version('calendar.js'); ?>'></script>
    <link href="<?= CALENDAR_ROOT; ?>static/cssworld.ru-xcal.css" rel="stylesheet">
    <script src="<?= CALENDAR_ROOT; ?>static/cssworld.ru-xcal.js" async></script>
    <script src='<?= CALENDAR_ROOT; ?>static/modal-w.js' async></script>
    <script src='<?= CALENDAR_ROOT; ?>static/util.js'></script>
    <script src='<?= DOMEN; ?>js/jquery-2.1.3.min.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/html2canvas.min.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/FileSaver.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/screen.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/fprint.js'></script>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/seo/seo_calendar_inc.php";
    include __DIR__ . "/paginator.php";

    ?>
    <script>
        gCal.year = <?= $year; ?>;
        gCal.arr_holyday = <?= json_encode($holyday); ?>;
        gCal.arr_list_month = <?= json_encode($list_month_23_24); ?>;
        gCal.arr_area_quartal = <?= json_encode($long_quartal_23_24); ?>;
        gCal.totalCount = 0;
        let _uid = gFingerprint.uid;
        gCal.list_quartal = <?= json_encode($this_checklistColumn); ?>;
        if(gShrd.cookieExists('uid')) document.cookie = "uid=" + _uid;
        else{
            let expires = new Date(new Date().getTime() + 60 * 60 * 24 * 365 * 1000).toGMTString();
            document.cookie = "uid=" + _uid + ";expires=" + expires + ";samesite=lax";
        }
    </script>
</head>
<body>
<?php
$save = $_COOKIE['save'] ?? '';
$uid = $_COOKIE['uid'] ?? '';
$checklist = $_COOKIE[$this_checklistColumn] ?? '';        //$_COOKIE['checklist_iii'] for write into db
$checkbox_list ='';                                        //for set state on load page

if ($save === 'true') {
    $check = $mysql->checkHashRow($uid);                   //"1130896627");
    if (is_array($check) and $check['user_hash'] === $uid) {
        if($check[$this_quartalColumn] !== NULL){
            $long = explode(";", $check[$this_quartalColumn]);
            $long_quartal_23_24 = [[intval($long[0]), intval($long[1])], [intval($long[2]), intval($long[3])]];   // [[9, 1], [22, 3]]

            //==== change js variable from database data =================//
            ?>
            <script>
                gCal.arr_area_quartal = <?= json_encode($long_quartal_23_24); ?>;
                //console.log('load save block = true');
            </script>
            <?php
        }
        if($check[$this_checklistColumn] !== NULL){
            $checkbox_list = $check[$this_checklistColumn];
        }
    }
}

?>
<header id="h-q">
    <section id="h-q-caption">
        <?= $caption; ?> | <?= $cap_quartal; ?> четверть
    </section>
    <!---->
    <section id="h-q-guest">
        <div id='h-uid-pre'>hi, </div>
        <div id='h-uid'></div>
    </section>
</header>
<noscript><p>Your browser does not support JavaScript!</p></noscript>
<section id="container" class="container">
    <article id="article-main">
        <div id="article-top-q">
            <div id="quartal-top">
                <div id="quartal-top-l" class="row-block shadow">
                    <div class="item-block" id="jan"></div>
                    <div class="item-block" id="feb"></div>
                    <div class="item-block" id="march"></div>
                </div>
                <div id="quartal-top-r" class="shadow">
                    <div id="datepicker">
                        <header>
                            <p>Задать свой диапазон</p>
                        </header>
                        <section>
                            <form class="dpckr-form" method="post">
                                <input type="text" id="date_start" name="date_start" value='' maxlength="10" placeholder="начало четверти"
                                       size="10"
                                       onClick="xCal(this)" onKeyUp="xCal()" required/><!-- onmouseenter="xCal(this)" -->
                                <label for="date_start"></label>
                                <input type="text" id="date_end" name="date_end" value="" maxlength="10" placeholder="окончание четверти"
                                       size="10"
                                       onClick="xCal(this)" onKeyUp="xCal()" required/>
                                <label for="date_end"></label>
                                <div id="dpckr-bt-save" data-hide-after="1000">
                                    <input type="submit" id="dtpkr_btn_save" title="сохранить" name="dtpkr_btn_save" value="&#x2714;"/>
                                    <input type="submit" id="dtpkr_btn_reset" title="сбросить настройки" name="dtpkr_btn_reset" value="&#x2716;"/>
                                </div><!--x274C, 2716, 2714, 1F4BE-->
                            </form>
                            <div class="dpckr-bt">
                                <input type="submit" id="dtpkr_btn" value="ok" onClick="gCal.setAreaQuartal('date_start', 'date_end')"/>
                            </div>
                        </section>
                        <script>
                            gCal.loadPickerDate("date_start", "date_end");
                        </script>
                    </div>
                </div>
                <script>
                    if(gCal.arr_list_month && gCal.arr_list_month.length) {
                        for (let i = 0; i < gCal.arr_list_month.length; i++) {
                            gCal.createCalendarAreaDate(gCal.arr_list_month[i], gCal.year, gCal.arr_area_quartal, gCal.arr_holyday);
                        }
                    }
                </script>
            </div>
        </div>
        <div id="article-bottom-q">
            <div id="content-chb" class="shadow">
                <div id="chb-select-all">
                    <input type='checkbox' id='check_all' name='check_all' onClick='gCal.countDayAll("check_all");'/>
                    <label for='check_all'>все</label>
                </div>
                <div id="chb-column">
                    <div>
                        <input id='check0' type='checkbox' checked onClick='gCal.countDayOfWeek(0);'/>
                        <label for='check0'>понедельники в четверти</label>
                    </div>
                    <div>
                        <input id='check1' type='checkbox' onClick='gCal.countDayOfWeek(1);'/>
                        <label for='check1'>вторники в четверти</label>
                    </div>
                    <div>
                        <input id='check2' type='checkbox' onClick='gCal.countDayOfWeek(2);'/>
                        <label for='check2'>среды в четверти</label>
                    </div>
                    <div>
                        <input id='check3' type='checkbox' onClick='gCal.countDayOfWeek(3);'/>
                        <label for='check3'>черверги в четверти</label>
                    </div>
                    <div>
                        <input id='check4' type='checkbox' onClick='gCal.countDayOfWeek(4);'/>
                        <label for='check4'>пятницы в четверти</label>
                    </div>
                </div>
                <div id="total"></div>
            </div>
            <div id="content-mon" class="shadow">
                <output id="mon"></output>
                <div id="mon_list" class="list"></div>
            </div>
            <div class="day-week shadow">
                <output id="tue"></output>
                <div id="tue_list" class="list"></div>
            </div>
            <div class="day-week shadow">
                <output id="wed"></output>
                <div id="wed_list" class="list"></div>
            </div>
            <div class="day-week shadow">
                <output id="thu"></output>
                <div id="thu_list" class="list"></div>
            </div>
            <div class="day-week shadow">
                <output id="fry"></output>
                <div id="fry_list" class="list"></div>
            </div>
            <script>
                gCal.countDayOfWeek(0);
            </script>
        </div>
        <div id="content-copy" class="shadow">
            <div id="copy-run">
                <input type="submit" id="copy" value="cкопировать даты" onClick="getAreaDateList();"/>
            </div>
            <div id="copy-perm">
                <input type="submit" value="&#x2754;" onClick="xMsg.checkPermission()" title="permission"/>
            </div>
            <script>
                function getAreaDateList() {
                    gCal.listDate = [];
                    for (let i = 0; i < gCal.arr_list_month.length; i++) {
                        let arr_add = gCal.createListingAreaDate(gCal.arr_list_month[i], gCal.year, gCal.arr_area_quartal, gCal.arr_holyday);
                        gCal.listDate.push.apply(gCal.listDate, arr_add);
                    }

                    let list_view = '';
                    for (let i = 0; i < gCal.listDate.length; i++) {
                        list_view += gCal.listDate[i] + '\n';
                    }
                    const view_id = document.getElementById("mon_list");
                    //view_id.innerHTML = list_view;
                    gCl.copyToClipboard(list_view);
                    const copy_id = document.getElementById("copy");
                    copy_id.style.background = '#d9e1ec';
                }
            </script>
        </div>
    </article>
    <aside id="sidebar-right">
        <?php include __DIR__ . '/shablons/sidebar.php'; ?>
    </aside>
</section>
<footer>
    <?php include __DIR__ . '/shablons/footer.php'; ?>
</footer>
<script>
    gShrd.setVisibleUidFromCookie('h-uid', 'save', _uid);
    gCal.setCheckboxStateFromCoockie ('<?= $checkbox_list; ?>');
    gShrd.hideLoadingButtonDivBlock('dpckr-bt-save', 10000);
    gCal.acceptCoockie(3000);
    <?php /* debugging: show caption width of browser */ ?>
    gShrd.showWidthScreenAdd('h-q-caption', true);
</script>
</body>
</html>
<?php

if (isset($_POST['dtpkr_btn_save'])) {
    ?><script>
        if(gShrd.cookieExists('save')) {
            document.cookie = "save=true";
        }else{
            let expires = new Date(new Date().getTime() + 60 * 60 * 24 * 365 * 1000).toGMTString();
            document.cookie = "save=true;expires=" + expires + ";samesite=lax";
        }
    </script><?php

    $d_start = explode(".", $_POST['date_start']);
    $d_end = explode(".", $_POST['date_end']);
    $period = intval($d_start[0]).';'.intval($d_start[1]).';'.intval($d_end[0]).';'.intval($d_end[1]);

    $check = $mysql->checkHashRow($uid);
    $long_quartal_23_24 = [[intval($d_start[0]), intval($d_start[1])], [intval($d_end[0]), intval($d_end[1])]];
    if (is_array($check) and $check['user_hash'] === $uid) {
        $mysql->updateCalendarValue($check['id'], time(), $this_quartalColumn, $period, $this_checklistColumn, $checklist);
    } else {
        $mysql->insertCalendar(time(), $uid, $this_quartalColumn, $period, $this_checklistColumn, $checklist);
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

if (isset($_POST['dtpkr_btn_reset'])) {
    ?><script>
        if(gShrd.cookieExists('save')) document.cookie = "save=false";
    </script><?php
    echo "<meta http-equiv='refresh' content='0'>";

}

