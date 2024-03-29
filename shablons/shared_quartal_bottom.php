<section id="content-chb" class="shadow">
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
</section>
<section id="content-mon" class="shadow">
    <output id="mon"></output>
    <div id="mon_list" class="list"></div>
</section>
<section class="day-week shadow">
    <output id="tue"></output>
    <div id="tue_list" class="list"></div>
</section>
<section class="day-week shadow">
    <output id="wed"></output>
    <div id="wed_list" class="list"></div>
</section>
<section class="day-week shadow">
    <output id="thu"></output>
    <div id="thu_list" class="list"></div>
</section>
<section class="day-week shadow">
    <output id="fry"></output>
    <div id="fry_list" class="list"></div>
</section>
<script>
    gCal.countDayOfWeek(0);
</script>
