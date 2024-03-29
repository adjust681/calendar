<section id="quartal-top">
    <section id="quartal-top-l" class="row-block shadow">
        <div class="item-block" id="apr"></div>
        <div class="item-block" id="may"></div>
    </section>
    <section id="quartal-top-r" class="shadow">
        <?php include __DIR__ . '/datepicker.php'; ?>
    </section>
    <script>
        for (let i = 0; i < gCal.arr_list_month.length; i++) {
            gCal.createCalendarAreaDate(gCal.arr_list_month[i], gCal.year, gCal.arr_area_quartal, gCal.arr_holyday);
        }
    </script>
</section>