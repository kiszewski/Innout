<?php
session_start();
requireValidateSession();

loadModel('WorkingHours');

$date = (new DateTime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

loadTeamplateView("day_records",
    ['today' => $today]);