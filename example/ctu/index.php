<?php
    $code = isset($_GET['code'])?trim($_GET['code']):'B0B01LAG';
    ?>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="../../css/timetable.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
<body>
<div class="middle">
    <h1 style="text-align: center">Ukázka PHP-Timetable</h1>
    <form method="get" href="#">
        <span>Zobrazované období: 8.10.2018-12.10.2018</span><br/>
        <label for="code">Kód kurzu: </label><input id="code" type="text" name="code" placeholder="B0B01LAG" value="<?= $code ?>"/>
        <input type="submit" value="OK"><br/>
        <span>Například: B6B36OMO B6B36PJC B2B16EPD B0B01LAG</span>
    </form>
    <?php
    require_once(__DIR__ . '/../../vendor/autoload.php');

    $start = '2018-10-07T09:15:00.000+02:00';
    $end = '2018-10-13T09:15:00.000+02:00';

    $ch = curl_init("https://auth.fit.cvut.cz/oauth/token");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "3eb3de4d-0134-447c-97af-9e5082c22d12:4Z6NWHRUgruFJbJ5WL5vxI7qgTzVOBLh");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));

    $out = curl_exec($ch);
    curl_close($ch);
    $token = json_decode($out, true);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://sirius.fit.cvut.cz/api/v1/courses/' . $code . '/events?from=' . $start . '&to=' . $end);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 400);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-type: application/json', 'Authorization: Bearer ' . $token['access_token']));
    $out = curl_exec($ch);

    $response_from_sirius = json_decode($out)->events;

    function render(string $template, array $data = []): string {
        return strtr(file_get_contents(__DIR__ . '/' . $template . '.stub'), $data);
    }

    function event_to_record(stdClass $event, \timetable\options $options) {
        $record = new \timetable\record($options);
        $record->class = 'record-ctu ' . $event->event_type;
        $links = $event->links;
        $time_start = strtotime($event->starts_at);
        $time_start -= $time_start % ($options->precision * 60);
        $record->start = date('H', $time_start) * 60 + date('i', $time_start);
        $day = date('d', $time_start);
        $time_start = date('H:i', $time_start);
        $time_end = strtotime($event->ends_at);
        $time_end -= $time_end % ($options->precision * 60);
        $record->end = date('H', $time_end) * 60 + date('i', $time_end);
        $time_end = date('H:i', $time_end);
        $time = $time_start . '-' . $time_end;
        $record->label = render('label', ['%code%' => $links->course, '%room%' => $links->room, '%time%' => $time]);
        $record->content = render('content', ['%fullname%' => $links->course,
                '%type%' => $event->event_type === 'lecture' ? 'Přednáška' : 'Cvičení', '%teacher%' => isset($links->teachers[0])?$links->teachers[0]:'']);
        return [$record, $day];
    }

    $options = new \timetable\options();
    $timetable = new \timetable\timetable($options);
    $first_day = 8;
    foreach ($response_from_sirius as $event) {
        list($record, $day) = event_to_record($event, $options);
        $timetable->days[$day - $first_day]->records[] = $record;
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
                <ul>
                    <li>Ani Bootstrap</li>
                </ul>
            </li>
            <li><b>Žádný javascript</b>
                <ul>
                    <li>Čisté HTML + CSS řešení</li>
                </ul>
            </li>
            <li><b>110</b> řádků PHP kódu</li>
            <li><b>171</b> řádků SCSS</li>
        </ul>
    </div>
</div>
<style>
    .middle {
        width: 80%;
        margin: 0 auto;
    }
</style>
</body>
</html>
