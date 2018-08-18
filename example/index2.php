<html>
<head>
    <link type="text/css" rel="stylesheet" href="../css/timetable.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
<body>
<?php
require_once('../vendor/autoload.php');
$o=new \timetable\options();
$timetable=new \timetable\timetable($o);

$omo=new \timetable\record($o);
$omo->start=11*60;
$omo->end=12*60+30;
$omo->class='record-ctu lecture';
$omo->label='<span class="ctu ctu-code">B0B36PJV</span><span class="ctu ctu-time">11:00-12:30</span><span class="ctu ctu-room">T2:C3-51</span>';
$omo->content='<a href="#" class="ctu ctu-code">&#128279;Programování v JAVA</a><span class="ctu ctu-type">Cvičení</span><hr/><a href="#" class="ctu-teacher">&#128100; prof. Ing. Jan Kočí, CSc.</a>';
$timetable->days[0]->records[]=$omo;


$omo=new \timetable\record($o);
$omo->start=7*60;
$omo->end=8*60+30;
$omo->class='record-ctu lecture';
$omo->label='<span class="ctu ctu-code">B0B36PJV</span><span class="ctu ctu-time">7:00-8:30</span><span class="ctu ctu-room">T2:C3-51</span>';
$omo->content='<a href="#" class="ctu ctu-code">Programování v JAVA</a><span class="ctu ctu-type">Cvičení</span><hr/><a href="#" class="ctu-teacher">prof. Ing. Jan Kočí, CSc.</a>';
$timetable->days[1]->records[]=$omo;

$t= $timetable->render();
echo $t;
?>
</body>
</html>