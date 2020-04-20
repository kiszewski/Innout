<?php
session_start();
requireValidateSession();

loadModel('WorkingHours');

$date = (new DateTime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('2020-04-20'));

loadTeamplateView("day_records",
    ['today' => $today,
    'records' => $records
    ]);