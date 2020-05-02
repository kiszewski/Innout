<?php
session_start();
requireValidateSession();

$exception = null;

if(count($_POST) > 0) {
    try {
        $newUser = new User($_POST);
        $sql = $newUser->insert();
        addSuccessMsg('Usuário inserido com sucesso!');
        $_POST = [];
    } catch(Exception $e) {
        $exception = $e;
    }
}

loadTeamplateView('save_user', $_POST + [
    'exception' => $exception,
    'sql' => $sql
]);