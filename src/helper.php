<?php

namespace timetable;

trait helper {
    protected $o;
    private $lang_data = null;
    private $title = null;
    private static $template = ['timetable' => '<div class="timetable %class%">%grid%%days%</div>',
            'day' => '<div class="day" style="height: %vh%;"><div class="day-header">%header%</div><div class="day-content" style="grid-template-columns: repeat(%cols%, 1fr);">%records%</div></div>',
            'record' => '<div class="record %class%" %grid%><input %disabled% id="record_in_%id%" class="record-tg" type="checkbox"/><label for="record_in_%id%" class="record-header">%label%<div></div></label><div class="record-content"><div>%content%</div></div></div>'];

    public function __construct(options $options, string $title = null) {
        $this->o = $options;
        if (property_exists(static::class, 'days'))
            foreach ($options->days as $day)
                $this->days[] = new day($options, $day);
        $this->title = $title;
    }

    protected function render_cols() : int {
        return ($this->o->end - $this->o->start) / $this->o->precision;
    }

    public function ln(string $id) : string {
        if ($this->lang_data == null) {
            $this->lang_data = parse_ini_file(__DIR__ . '/timetable_' . $this->o->lang . '.ini');
        }
        return $this->lang_data[$id];
    }

    protected function partial(string $template, array $data = []) : string {
        return strtr(self::$template[$template], $data);
    }

    protected function partials(array $partials) : string {
        $out = '';
        foreach ($partials as $partial)
            $out .= $partial->render();
        return $out;
    }
}