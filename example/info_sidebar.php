<html>
<head>
    <link type="text/css" rel="stylesheet" href="../css/timetable.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
<body>
<div id="sidebar">
<?php
require_once('../vendor/autoload.php');
$o=new \timetable\options();
$o->show_grid_hours=false;
$o->day_height='20px';
$o->disabled=true;
$timetable=new \timetable\timetable($o);

$omo=new \timetable\record($o);
$omo->start=11*60;
$omo->end=12*60+30;
$omo->class='record-ctu lecture';
$timetable->days[0]->records[]=$omo;


$omo=new \timetable\record($o);
$omo->start=7*60;
$omo->end=8*60+30;
$omo->class='record-ctu lecture';
$timetable->days[1]->records[]=$omo;

$t= $timetable->render();
echo $t;
?>
</div>
<style>
    #sidebar
    {
        font-size: 0.5em;
        margin-left: auto;
        width: 208px;
    }
</style>
</body>
</html>