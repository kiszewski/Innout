<?php
session_start();
requireValidateSession();

$exception = null;

if(count($_POST) > 0) {
    try {
        $newUser = new User($_POST);
        $newUser->insert();
        addSuccessMsg('Usuário inserido com sucesso!');
    } catch(Exception $e) {
        $exception = $e;
    }
}

loadTeamplateView('save_user', [
    'exception' => $exception
]);