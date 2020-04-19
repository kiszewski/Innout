<?php
function getDayTemplateByOdds($regularRate, $extraRate, $lazyRate) {
    $regularHourDayTime = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00'
    ];

    $extraHourDayTime = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '18:00:00'
    ];

    $lazyHourDayTime = [
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00'
    ];

    $value = rand(0, 100);

    if($value <= $regularRate) {
        return $regularHourDayTime;
    } elseif ($value <= $regularRate + $extraRate) {
        return $extraHourDayTime;
    } else {
        return $lazyHourDayTime;
    }
}