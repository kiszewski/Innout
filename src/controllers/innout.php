<?php
session_start();
requireValidateSession();

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

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