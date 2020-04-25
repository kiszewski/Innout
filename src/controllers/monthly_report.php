<?php
session_start();
requireValidateSession();

$user = $_SESSION['user'];

$registries = WorkingHours::getMonthlyReport($user->id, '2020-04-01');

loadTeamplateView("monthly_report", [
    'registries' => $registries
]);