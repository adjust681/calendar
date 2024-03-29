<?php
include_once __DIR__ . '/calendar_root_inc.php';
include_once __DIR__ . '/Settings.php';
$set = new Settings();

$year_pre = '2023';
$year = '2024';
$page = 0;
$holyday = $set->holyday2024;
$holyday_pre = $set->holyday2023;
$view_page = '/shablons/shared_main.php';
$caption = 'Календарь 2024';

if (isset($_GET['year'])) {
    if ($_GET['year'] == '2025') {
        $year = '2025';
        $caption = 'Календарь ' . $year;
        $holyday = $set->holyday2025;
        $page = 1;
    } elseif ($_GET['year'] == '2023-2024') {
        $view_page = '/shablons/shared_teacher.php';
        $caption = 'Учительский календарь ' . $_GET['year'];
        $page = 2;
    } elseif ($_GET['year'] == '2024-2025') {
        $view_page = '/shablons/shared_teacher.php';
        $year_pre = '2024';
        $year = '2025';
        $holyday_pre = $set->holyday2024;
        $holyday = $set->holyday2025;
        $caption = 'Учительский календарь ' . $_GET['year'];
        $page = 3;
    }
}

?>
<!DOCTYPE HTML>
<html lang='ru-RU'>
<head>
    <title>calendar <?= $year; ?></title>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='<?= CALENDAR_ROOT; ?>static/main.css?<?= _version('main.css'); ?>'/>
    <script src="<?= CALENDAR_ROOT; ?>static/calendar.js"></script>
    <script src='<?= DOMEN; ?>js/jquery-2.1.3.min.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/html2canvas.min.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/FileSaver.js'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/screen.js?<?= _version('screen_test_original.js'); ?>'></script>
    <script src='<?= CALENDAR_ROOT; ?>static/util.js'></script>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/seo/seo_calendar_inc.php";
    include_once __DIR__ . "/paginator.php";

    ?>
    <script>
        gCal.year_pre = <?= $year_pre; ?>;
        gCal.year = <?= $year; ?>;
        gCal.arr_holyday_pre = <?= json_encode($holyday_pre); ?>;
        gCal.arr_holyday = <?= json_encode($holyday); ?>;
    </script>
</head>
<body>
<header id="h-main">
    <section id="h-main-caption">
        <?= $caption; ?>
    </section>
</header>
<noscript><p>Your browser does not support JavaScript!</p></noscript>
<section id="container" class="container">
    <article id="article-top">
        <?php
            include __DIR__ . $view_page;
        ?>
    </article>
    <aside id="sidebar-right">
        <?php include __DIR__ . '/shablons/sidebar.php'; ?>
    </aside>
</section>
<footer>
    <?php include __DIR__ . '/shablons/footer.php'; ?>
</footer>
<script>
    gCal.acceptCoockie(3000);
    <?php /* debugging: show caption width browser */ ?>
    gShrd.showWidthScreenAdd('h-main-caption', false);
</script>
</body>
</html>