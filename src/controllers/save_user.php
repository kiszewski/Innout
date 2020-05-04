<?php
session_start();
requireValidateSession();

$exception = null;
$userData = [];

if(count($_POST) === 0 && isset($_GET['update'])) {
    $user = User::getOne(['id' => $_GET['update']]);
    $userData = $user->getValues();
    $userData->password = null;
} elseif(count($_POST) > 0) {
    try {
        if(is_null($_POST['id']) || $_POST['id'] === '') {
            unset($_POST['id']);
            $dbUser = new User($_POST);
            $dbUser->insert();
            addSuccessMsg('Usuário inserido com sucesso!');
        } else {
            $dbUser = new User($_POST);
            $dbUser->update();
            header("Location: users.php");
            addSuccessMsg('Usuário atualizado com sucesso!');
        }
        $_POST = [];
    } catch(Exception $e) {
        $exception = $e;
    } finally {
        $userData = $_POST;
    }
}

loadTeamplateView('save_user', $userData + [
    'exception' => $exception
]);