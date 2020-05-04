<?php
session_start();
requireValidateSession(true);

$activeUsersCount = User::getActiveUsersCount();

$seconds = WorkingHours::getWorkedTimeInMonth((new DateTime())->format('Y-m'));
$hoursInMonth = explode(':', getStringTimefromSeconds($seconds))[0];

$absentUsers = User::getAbsentUsers();

loadTeamplateView("manager_report", [
    'activeUsersCount' => $activeUsersCount,
    'hoursInMonth' => $hoursInMonth,
    'absentUsers' => $absentUsers
]);