<?php

namespace timetable;

class record {
    use helper;
    private static $id = 0;
    public $start = 0, $end = 0, $class = '', $content = '', $label = '', $row = [1, 12];

    public function compare(record $b, string $pA = 'start', string $pB = 'start'): int {
        return ($this->{$pA} < $b->{$pB}) ? -1 : ($this->{$pA} > $b->{$pB}) ? 1 : 0;
    }

    public function render(): string {
        $id = self::$id++;
        $col = [($this->start - $this->o->start) / $this->o->precision+1, ($this->end - $this->start) / $this->o->precision];
        $pos = "style='grid-area:{$this->row[0]} / {$col[0]} / span {$this->row[1]} / span {$col[1]}'";
        return $this->partial('record',['%id%' => $id, '%grid%' => $pos, '%disabled%'=>$this->o->disabled?'disabled':'',
                '%class%' => $this->class, '%label%' => $this->label, '%content%' => $this->content]);
    }

}