<?php
session_start();
requireValidateSession();

loadModel("WorkingHours");

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

$currentTime = strftime('%H:%M:%S', time());
$result = $records->innout($currentTime); //erro da nessa linha
header("Location: day_records.php");