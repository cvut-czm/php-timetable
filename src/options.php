<?php

namespace timetable;

class options {
    public $precision = 15;
    public $start = 7 * 60;
    public $end = 21 * 60;
    public $day_height='80px';
    public $disabled= false;
    public $show_day_header = true;
    public $show_day_abbrev = true;
    public $show_grid = true;
    public $show_grid_hours = true;
    public $lang = 'cs';
    public $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
}