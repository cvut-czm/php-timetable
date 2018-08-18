<html>
<head>
    <link type="text/css" rel="stylesheet" href="../css/timetable.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
<body>
<div class="timetable">
    <div class="grid">
        <div data-content="7"></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
    </div>
<?php

require_once('../vendor/autoload.php');

$options=new \timetable\timetable_options();
$day=new \timetable\models\day('',$options);

$omo=new \timetable\models\record();
$timepoint=new \timetable\old\timepoint($options,14*60+30);
$timepoint2=new \timetable\old\timepoint($options,16*60);
$timespan=new \timetable\old\timespan($options,$timepoint,$timepoint2);
$omo->set_timespan($timespan);
$day->add_record($omo);


$omo=new \timetable\models\record();
$timepoint=new \timetable\old\timepoint($options,11*60);
$timepoint2=new \timetable\old\timepoint($options,12*60+30);
$timespan=new \timetable\old\timespan($options,$timepoint,$timepoint2);
$omo->set_timespan($timespan);
$day->add_record($omo);

$omo=new \timetable\models\record();
$timepoint=new \timetable\old\timepoint($options,11*60+30);
$timepoint2=new \timetable\old\timepoint($options,13*60+30);
$timespan=new \timetable\old\timespan($options,$timepoint,$timepoint2);
$omo->set_timespan($timespan);
$day->add_record($omo);

$omo=new \timetable\models\record();
$timepoint=new \timetable\old\timepoint($options,15*60);
$timepoint2=new \timetable\old\timepoint($options,16*60+30);
$timespan=new \timetable\old\timespan($options,$timepoint,$timepoint2);
$omo->set_timespan($timespan);
$day->add_record($omo);

$omo=new \timetable\models\record();
$timepoint=new \timetable\old\timepoint($options,15*60+30);
$timepoint2=new \timetable\old\timepoint($options,16*60+30);
$timespan=new \timetable\old\timespan($options,$timepoint,$timepoint2);
$omo->set_timespan($timespan);
$day->add_record($omo);


$omo=new \timetable\models\record();
$timepoint=new \timetable\old\timepoint($options,8*60+30);
$timepoint2=new \timetable\old\timepoint($options,10*60);
$timespan=new \timetable\old\timespan($options,$timepoint,$timepoint2);
$omo->set_timespan($timespan);
$day->add_record($omo);

$day->reorder_records();

echo $day->render();
echo $day->render();
?>

</div>
</body></html>
