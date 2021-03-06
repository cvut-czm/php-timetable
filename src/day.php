<?php

namespace timetable;

class day {
    use helper;
    public $records = [];

    public function render() : string {
        uasort($this->records, function(record $a, record $b) {
            return $a->compare($b);
        });
        $lines = [null, null, null, null];
        foreach ($this->records as $record)
            for ($line = 0; $line < 4; $line++)
                if ($lines[$line] == null || $record->compare($lines[$line], 'start', 'end') !== -1) {
                    $lines[$line] = $record;
                    $count = 0;
                    for ($f = $line + 1; $f < 4; $f++)
                        $count += $lines[$f] != null && $record->compare($lines[$f], 'start', 'end') == -1 ? 1 : 0;
                    $span = 12 / ($line + $count + 1);
                    for ($e = 0; $e < $line + $count + 1; $e++)
                        $lines[$e]->row = [$e * $span + 1, $span];
                    break;
                }
        $title = $this->o->show_day_header ? ($this->o->show_day_abbrev ? $this->title . '_abbrev' : $this->title) : 'empty';
        uasort($this->records, function(record $a, record $b) {
            return $a->row[0] == $b->row[0] ? -$a->compare($b) : ($a->row[0] < $b->row[0] ? -1 : 1);});
        return $this->partial('day',
                ['%vh%' => $this->o->day_height, '%header%' => ($this->o->render_head)($title,$this),
                        '%records%' => $this->partials($this->records),'cols'=>$this->render_cols()]);
    }
}