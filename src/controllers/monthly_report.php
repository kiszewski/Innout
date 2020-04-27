<?php
session_start();
requireValidateSession();

$user = $_SESSION['user'];

$currentDate = new DateTime();

$registries = WorkingHours::getMonthlyReport($user->id, $currentDate);

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayMonth($currentDate)->format('d');

for ($day = 1; $day <= $lastDay; $day++) {
    $date = $currentDate->format('Y-m') . '-' . sprintf('%02d', $day);
    $registry = $registries[$date];

    if(isPastWorkDay($date)) $workDay++;
    
    if($registry) {
        $sumOfWorkedTime += $registry->worked_time;
        array_push($report, $registry);
    } else {
        array_push($report, new WorkingHours([
            'worked_time' => 0,
            'work_date' => $date
            ]));
    }

}

$expectedTime = $workDay * DAILY_TIME;
$balance = getStringTimefromSeconds(abs($sumOfWorkedTime - $expectedTime));
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';

loadTeamplateView("monthly_report", [
    'report' => $report,
    'sumOfWorkedTime' => getStringTimefromSeconds($sumOfWorkedTime),
    'balance' => "{$sign}{$balance}"
]);