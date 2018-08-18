<?php

namespace timetable;

class day {
    use helper;
    public $records = [];

    public function render(): string {
        uasort($this->records, function(record $a, record $b) {
            return $a->compare($b);
        });
        $records =& $this->records;

        $lastrecords = [null, null, null, null];
        foreach ($records as $record) {
            for ($line = 0; $line < 4; $line++) {
                $lastrecord = $lastrecords[$line];
                if ($lastrecord == null || $record->compare($lastrecord, 'start', 'end')) {
                    $span = 12 / ($line + 1);
                    $record->row = [$line * $span + 1, $span];
                    $lastrecords[$line] = $record;
                    for ($e = $line - 1; $e >= 0; $e--) {
                        $lastrecords[$e]->row = [$e * $span + 1, $span];
                    }
                    break;
                }
            }
        }
        $title=$this->o->show_day_header?($this->o->show_day_abbrev?$this->title.'_abbrev':$this->title):'empty';
        return $this->partial('day', ['%vh%'=>$this->o->day_height,'%header%' => $this->ln($title), '%records%' => $this->partials($this->records)]);
    }
}