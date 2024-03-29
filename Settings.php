<?php

class Settings
{
    public array $holyday2023 = [[1, 2, 3, 4, 5, 6, 7, 8], [23], [8], [], [1, 9], [12], [], [], [], [], [4], [], [1, 9]];

    public array $holyday2024 = [[1, 2, 3, 4, 5, 6, 7, 8], [23], [8], [29, 30], [9, 10], [12], [], [], [], [], [4], [], [2, 9]];
    public array $list_month_iii_23_24 = [0, 1, 2];
    public array $long_quartal_iii_23_24 = [[9, 1], [22, 3]];              //day and month start with 1 !!!
    public array $list_month_iv_23_24 = [3, 4];
    public array $long_quartal_iv_23_24 = [[1, 4], [24, 5]];               //day and month start with 1 !!!

    public array $holyday2025 = [[1, 2, 3, 6, 7, 8], [], [], [], [1, 9], [12], [], [], [], [], [4], [], [1, 9]];
    public array $list_month_i_24_25 = [8, 9];
    public array $long_quartal_i_24_25 = [[2, 9], [22, 10]];
    public array $list_month_ii_24_25 = [10, 11];
    public array $long_quartal_ii_24_25 = [[1, 4], [24, 5]];
    public array $list_month_iii_24_25 = [0, 1, 2];
    public array $long_quartal_iii_24_25 = [[9, 1], [22, 3]];
    public array $list_month_iv_24_25 = [3, 4];
    public array $long_quartal_iv_24_25 = [[1, 4], [24, 5]];

    public array $header = ['Календарь', 'Учительский календарь', 'четверть'];
    public array $quartalTableColumn = ['quartal_i', 'quartal_ii', 'quartal_iii', 'quartal_iv'];
    public array $checklistTableColumn = ['checklist_i', 'checklist_ii', 'checklist_iii', 'checklist_iv'];
}