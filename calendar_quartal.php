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
    <link href='<?= CALENDAR_ROOT; ?>static/main.css?<?= _version('main.css'); ?>' rel='stylesheet'>-->
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
$checklist = $_COOKIE[$this_checklistColumn] ?? '';
$checkbox_list ='';

if ($save === 'true') {
    $check = $mysql->checkHashRow($uid);
    if (is_array($check) and $check['user_hash'] === $uid) {
        if($check[$this_quartalColumn] !== NULL){
            $long = explode(";", $check[$this_quartalColumn]);
            $long_quartal_23_24 = [[intval($long[0]), intval($long[1])], [intval($long[2]), intval($long[3])]];   // [[9, 1], [22, 3]]

            ?>
            <script>
                gCal.arr_area_quartal = <?= json_encode($long_quartal_23_24); ?>;
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
    <section id="h-q-guest">
        <div id='h-uid-pre'>hi, </div>
        <div id='h-uid'></div>
    </section>
</header>
<noscript><p>Your browser does not support JavaScript!</p></noscript>
<section id="container" class="container">
    <article id="article-main">
        <div id="article-top-q">
            <?php include __DIR__ . $view_quartal_top; ?>
        </div>
        <div id="article-bottom-q">
            <?php include __DIR__ . '/shablons/shared_quartal_bottom.php'; ?>
        </div>
        <div id="article-bottom2-q">
            <?php include __DIR__ . '/shablons/shared_quartal_bottom_copy.php'; ?>
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
    gCal.acceptCoockie(5000);
    //gShrd.showWidthScreenAdd('h-q-caption', true);
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

    //=== get value from input, check uid into database, insert/update, refrash =========//
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
    //header("Refresh: 0");
    echo "<meta http-equiv='refresh' content='0'>";
}

if (isset($_POST['dtpkr_btn_reset'])) {
    ?><script>
        if(gShrd.cookieExists('save')) document.cookie = "save=false";
    </script><?php
    echo "<meta http-equiv='refresh' content='0'>";

}
