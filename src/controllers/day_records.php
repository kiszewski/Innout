<?php
session_start();
requireValidateSession();

$date = (new DateTime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

loadTeamplateView("day_records", ['today' => $today] );