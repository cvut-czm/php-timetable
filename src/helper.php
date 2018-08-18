<?php

namespace timetable;

trait helper {
    protected $o;
    private $lang_data = null;
    private $title = null;

    public function __construct(options $options, string $title = null) {
        $this->o = $options;
        if (property_exists(static::class, 'days')) {
            foreach ($options->days as $day) {
                $this->days[] = new day($options, $day);
            }
        }
        $this->title = $title;
    }

    protected function render_cols(): int {
        return ($this->o->end - $this->o->start) / $this->o->precision;
    }

    protected function ln(string $id): string {
        if ($this->lang_data == null) {
            $this->lang_data = parse_ini_file(__DIR__ . '/../lng/' . $this->o->lang . '.ini');
        }
        return $this->lang_data[$id];
    }

    protected function partial(string $template, array $data = []): string {
        return strtr(file_get_contents(__DIR__ . '/../template/' . $template . '.stub'), $data);
    }

    protected function partials(array $partials): string {
        $out = '';
        foreach ($partials as $partial) {
            $out .= $partial->render();
        }
        return $out;
    }
}