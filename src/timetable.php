<?php

namespace timetable;

class timetable {
    use helper;
    public $days = [];

    protected function render_grid(): string {
        $out = '<div class="grid">';
        for ($i = $this->o->start / 60 - $this->o->start % 60; $i < $this->o->end / 60 - $this->o->end % 60; $i++) {
            $out .= '<div data-content="' . ($this->o->show_grid_hours ? $i : '') . '"></div>';
        }
        return $out . '</div>';
    }

    public function render(): string {
        return $this->partial('timetable', ['%class%' => $this->o->show_day_header ? '' : 'headless',
                '%grid%' => $this->o->show_grid ? $this->render_grid() : '', '%days%' => $this->partials($this->days)]);
    }
}