<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
use timetable\models\day;

/**
 * This class provide full control over sandboxes.
 *
 * @package local_personal_sandbox
 * @category core
 * @copyright 2018 CVUT CZM, Jiri Fryc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class DataProvider {

    private static function apply(day $day,$data)
    {
        foreach ($data as $datum)
        {
            $record=new \timetable\models\record();
            $timespan=new \timetable\old\timespan(new \timetable\timetable_options());
            $timespan->get_start()->set_time($datum[0]*60+$datum[1]);
            $timespan->get_end()->set_time($datum[2]*60+$datum[3]);
            $record->set_timespan($timespan);
            $day->add_record($record);
        }
    }
    public static function no_collision() : day
    {
        $data=[
                [9,30,10,30],
                [10,30,11,45]
        ];
        $day=new day(new \timetable\timetable_options());
        self::apply($day,$data);
        return $day;

    }
    public static function collision() : day
    {
        $data=[
                [9,30,10,30],
                [10,0,11,45]
        ];
        $day=new day(new \timetable\timetable_options());
        self::apply($day,$data);
        return $day;

    }
}