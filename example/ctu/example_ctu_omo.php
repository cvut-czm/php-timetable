<html>
<head>
    <link type="text/css" rel="stylesheet" href="../../css/timetable.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
<body>
<div class="middle">
    <h1 style="text-align: center">Ukázka PHP-Timetable</h1>
<?php
require_once(__DIR__.'/../../vendor/autoload.php');

$response_from_sirius=json_decode(file_get_contents(__DIR__.'/b6b36omo.json'))->events;

function render(string $template, array $data = []): string {
    return strtr(file_get_contents(__DIR__ . '/' . $template . '.stub'), $data);
}
function event_to_record(stdClass $event, \timetable\options $options){
    $record=new \timetable\record($options);
    $record->class='record-ctu '.$event->event_type;
    $links=$event->links;
    $time_start=strtotime($event->starts_at);
    $time_start-=$time_start%($options->precision*60);
    $record->start=date('H',$time_start)*60+date('i',$time_start);
    $day=date('d',$time_start);
    $time_start=date('H:i', $time_start);
    $time_end=strtotime($event->ends_at);
    $time_end-=$time_end%($options->precision*60);
    $record->end=date('H',$time_end)*60+date('i',$time_end);
    $time_end=date('H:i', $time_end);
    $time=$time_start.'-'.$time_end;
    $record->label=render('label',['%code%'=>$links->course,'%room%'=>$links->room,'%time%'=>$time]);
    $record->content=render('content',['%fullname%'=>'Objektový návrh a modelování','%type%'=>$event->event_type==='lecture'?'Přednáška':'Cvičení','%teacher%'=>$links->teachers[0]]);
    return [$record,$day];
}
$options=new \timetable\options();
$timetable=new \timetable\timetable($options);
$first_day=8;
foreach ($response_from_sirius as $event)
{
    list($record,$day)=event_to_record($event,$options);
    $timetable->days[$day-$first_day]->records[]=$record;
}
echo $timetable->render();
?>
<div class="caption">
    <span class="lecture">Přednáška</span>
    <span class="tutorial">Cvičení</span>
</div>
    <div style="font-size:1.2em; width: 20em; margin: 0 auto;">
    <h2 style="text-align: center">Implementace</h2>
    <ul>
        <li><b>0</b> závislostí na knihovnách
            <ul><li>Ani Bootstrap</li></ul>
        </li>
        <li><b>Žádný javascript</b>
            <ul><li>Čisté HTML + CSS řešení</li></ul>
        </li>
        <li><b>24</b> řádků HTML template</li>
        <li><b>133</b> řádků PHP kódu</li>
        <li><b>171</b> řádků SCSS</li>
    </ul></div>
</div>
<style>
    .middle{
        width: 80%;
        margin: 0 auto;
    }
</style>
</body>
</html>
