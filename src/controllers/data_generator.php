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
    $today = new DateTime();
    $columns = ['user_id' => $UserId, 'work_date' => $initialDate];

    while(isBefore($currentDate, $today)) {
        if(!isWeekend($currentDate)) {
            $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);
            $columns = array_merge($columns, $template);
            $workingHours = new WorkingHours($columns);
            $workingHours->save();
        }
        $currentDate = getNextDay($currentDate)->format('Y-m-d');
        $columns['work_date'] = $currentDate;
    }
}

populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);

echo "td certo";