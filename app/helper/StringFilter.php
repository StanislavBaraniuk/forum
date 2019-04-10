<?php

    class StringFilter
    {
        public static function filterDate($date) {

            $date = explode(' ', $date)[0];

            if (!preg_match("([0-9]{2}-[0-9]{2}-[0-9]{2})", $date)) {
                return false;
            }

            $YMD = explode('-', $date);
            $monthName = date('F', mktime(0, 0, 0, $YMD[1], 10));

            $date = $YMD[2].' '.$monthName.' '.$YMD[0];

            return $date;
        }

        public static function filterTime($time) {

            $time = explode(' ', $time)[1];

            $HMS = explode(':', $time);

            $time = $HMS[0].':'.$HMS[1];

            return $time;
        }
    }