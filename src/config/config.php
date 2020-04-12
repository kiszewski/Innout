<?php

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'Brazil', 'pt-BR.utf-8', 'portuguese');

// PASTAS
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));

require_once(realpath(dirname(__FILE__) . '/database.php'));