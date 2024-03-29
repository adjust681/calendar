<section class="shadow">
    <section class="row-block">
        <div class="item-block" id="jan"></div>
        <div class="item-block" id="feb"></div>
        <div class="item-block" id="march"></div>
        <div class="item-block" id="apr"></div>
    </section>
    <section class="row-block">
        <div class="item-block" id="may"></div>
        <div class="item-block" id="jun"></div>
        <div class="item-block" id="jul"></div>
        <div class="item-block" id="aug"></div>
    </section>
    <section class="row-block">
        <div class="item-block" id="sen"></div>
        <div class="item-block" id="oct"></div>
        <div class="item-block" id="nov"></div>
        <div class="item-block" id="dec"></div>
    </section>
    <script>
        for (let i = 0; i < 12; i++) gCal.createCalendar(i, gCal.year, gCal.arr_holyday);
    </script>
</section>