<?php
session_start();
requireValidateSession(true);

$exception = [];

if(isset($_GET['delete'])) {
    try {
        $resultado = User::deleteById($_GET['delete']);
        addSuccessMsg('Usuário excluído com sucesso!');
    } catch (Exception $e) {
        $exception = $e;
    }
}

$users = User::get();

foreach($users as $key => $user) {
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');
    
    if($user->end_date) {
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }

    if(is_string($user->deleted_at)) {
        unset($users[$key]);
    }
}

loadTeamplateView('users', [
    'users' => $users,
    'exception' => $exception
]);