<section id="sidebar-top" class="shadow">
    <figure><img id="img1" alt="" title="Выходные дни" >Выходные дни</figure>
    <figure><img id="img2" alt="" title="Праздничные дни" >Праздничные дни</figure>
    <figure><img id="img4" alt="" title="Каникулы" >Каникулы</figure>
    <figure><img id="img5" alt="" title="День Знаний" >День Знаний</figure>
    <figure><img id="img3" alt="" title="Актуальная дата" >Актуальная дата</figure>
</section>
<section id="sidebar-bottom" class="w-link shadow">
    <ul>
        <li class='em-y'><a href='<?= CALENDAR_ROOT; ?>2024'>Календарь 2024</a></li>
        <li class='em-y'><a href='<?= CALENDAR_ROOT; ?>2025'>Календарь 2025</a></li>
        <li class='em-t'><a href='<?= CALENDAR_ROOT; ?>2023-2024'>Учительский календарь 23-24</a>
            <ul class='em-v'>
                <li><a href='<?= CALENDAR_ROOT_Q; ?>2023-2024/iii'>III учебная четверть</a></li>
                <li><a href='<?= CALENDAR_ROOT_Q; ?>2023-2024/iv'>IV учебная четверть</a></li>
            </ul>
        </li>
        <li class='em-t'><a href='<?= CALENDAR_ROOT; ?>2024-2025'>Учительский календарь 24-25</a>
            <ul class='em-r'>
                <li><b>I учебная четверть</b></li>
                <li><b>II учебная четверть</b></li>
                <li><b>III учебная четверть</b></li>
                <li><b>IV учебная четверть</b></li>
            </ul>
        </li>
        <li class='em-p'><a href="<?= CALENDAR_REQUEST_URI; ?>" title='Вывод на печать' onclick='window.print()'>Печать</a></li>
        <li class='em-s'><a href='javascript:void(0);' title='Сохранить скриншот на устройстве' onclick="gSCR.exportImage('container')">Сохранить</a></li>
    </ul>
</section>