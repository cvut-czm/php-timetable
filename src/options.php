<?php

namespace timetable;

class options {
    public $lang = 'cs';
    public $disabled = false, $skip_grid=0, $grid_title='';
    public $render_head;
    public $precision = 15, $start = 7 * 60, $end = 21 * 60;
    public $show_day_header = true, $show_day_abbrev = true, $show_grid = true, $show_grid_hours = true;
    public $day_height = '80px', $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'], $selected_day = -1;

    public function __construct() {
        $this->render_head=function($title,$helper){return $helper->ln($title);};
    }
}