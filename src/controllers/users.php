<?php
session_start();
requireValidateSession();

$users = User::get();

foreach($users as $user) {
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');
    
    if($user->end_date) {
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }
}

loadTeamplateView('users', [
    'users' => $users
]);