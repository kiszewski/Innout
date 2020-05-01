<main class="content">
    <?php
        echo "Usuarios ativos: $activeUsersCount <br>";
        echo "Horas: $hoursInMonth <br>";
        echo "Usuarios que nao iniciaram trabalho: ";
        print_r($absentUsers);
    ?>
</main>