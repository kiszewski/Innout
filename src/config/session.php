<?php

function requireValidateSession($requiresAdmin = false) {
    $user = $_SESSION['user'];
    if(!isset($user)) {
        header("Location: login.php");
        exit();
    }
    if($requiresAdmin && !$user->is_admin) {
        addErrorMsg("Acesso negado");
        header("Location: day_records.php");
        exit();
    }
}