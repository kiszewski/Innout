<?php 

loadModel("WorkingHours");
$wh = WorkingHours::loadFromUserAndDate(1, date('Y-m-d'));

$interval = $wh->getWorkedInterval()->format('%H:%I:%S');
print_r($interval);

echo '<br>';

$intervalLunch = $wh->getLunchInterval()->format('%H:%I:%S');
print_r($intervalLunch);