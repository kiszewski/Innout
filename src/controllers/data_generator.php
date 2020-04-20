<?php
loadModel('WorkingHours');

Database::executeSql('DELETE FROM working_hours');
// Database::executeSql('DELETE FROM users where id > 5');

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

function populateWorkingHours($UserId, $initialDate, $regularRate, $extraRate, $lazyRate) {
    $currentDate = $initialDate;
    $yesterday = new DateTime();
    $yesterday->modify('-1 day');
    $columns = ['user_id' => $UserId, 'work_date' => $initialDate];

    while(isBefore($currentDate, $yesterday)) {
        if(!isWeekend($currentDate)) {
            $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);
            $columns = array_merge($columns, $template);
            $workingHours = new WorkingHours($columns);
            $workingHours->insert();
        }
        $currentDate = getNextDay($currentDate)->format('Y-m-d');
        $columns['work_date'] = $currentDate;
    }
}

$lastMonth = strtotime('first day of last month');
populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);
populateWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
populateWorkingHours(4, date('Y-m-d', $lastMonth), 20, 10, 70);

echo "td certo";