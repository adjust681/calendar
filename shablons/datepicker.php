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
