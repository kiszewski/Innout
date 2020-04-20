<?php
session_start();
requireValidateSession();

loadModel("WorkingHours");

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate(1, date('Y-m-d'));

try {
    $currentTime = strftime('%H:%M:%S', time());

    if($_POST['forcedTime']) {
        $currentTime = $_POST['forcedTime'];
    }

    $result = $records->innout($currentTime);
    addSuccessMsg("Ponto marcado com sucesso!");
} catch(AppException $e) {
    addErrorMsg($e->getMessage());
}

header("Location: day_records.php");