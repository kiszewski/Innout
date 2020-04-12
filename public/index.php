<?php
require_once(dirname(__FILE__, 2) . '/src/config/config.php');
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

$user = new User(['nome' => "Leonardo", "email" => "leo@email.com"]);
$user->nome = "Léo";
echo $user->nome;