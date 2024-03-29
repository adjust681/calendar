<?php
$paginator = [
    ['', CALENDAR_ROOT . '2025'],
    [CALENDAR_ROOT . '2024', CALENDAR_ROOT . '2023-2024'],
    [CALENDAR_ROOT . '2025', CALENDAR_ROOT . '2024-2025'],
    [CALENDAR_ROOT . '2023-2024', CALENDAR_ROOT_Q . '2023-2024/iii'],
    [CALENDAR_ROOT . '2024-2025', CALENDAR_ROOT_Q . '2023-2024/iv'],
    [CALENDAR_ROOT . CALENDAR_ROOT_Q . '2023-2024/iii', '']
];
if (isset($page)) {
    if (!empty($paginator[$page][0])) {
        ?>
        <link rel="prev" href="<?= $paginator[$page][0]; ?>" />
        <?php
    }
    if (!empty($paginator[$page][1])) {
        ?>
        <link rel="next" href="<?= $paginator[$page][1]; ?>" />
        <?php
    }
}
