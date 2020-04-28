<?php
session_start();
requireValidateSession();

$user = $_SESSION['user'];
$selectedUserId = $user->id;
$users = [];
if($user->is_admin) {
    $users = User::get();
    $selectedUserId = $_POST['user'] ? $_POST['user'] : $user->id;
}

$currentDate = new DateTime();

$selectedPeriod = $_POST['period'] ? $_POST['period'] : $currentDate->format('Y-m');
$periods = [];
for ($YearDiff = 0; $YearDiff < 2; $YearDiff++) {
    $Year = date('Y') - $YearDiff;
    for ($month = 12; $month >= 1; $month--) {
        $date = new DateTime("{$Year}-{$month}-1");
        $periods[$date->format('Y-m')] = strftime("%B de %Y", $date->getTimestamp());
    }
}

$registries = WorkingHours::getMonthlyReport($selectedUserId, $selectedPeriod);

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
    'balance' => "{$sign}{$balance}",
    'selectedPeriod' => $selectedPeriod,
    'periods' => $periods,
    'selectedUserId' => $selectedUserId,
    'users' => $users,
    'user' => $user
]);