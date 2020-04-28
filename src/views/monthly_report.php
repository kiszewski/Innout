<main class="content">
    <?php
    renderTitle(
        'Relatório Mensal',
        'Acompanhe seu saldo de horas',
        'icofont-ui-calendar'
    )
    ?>
    <div>
        <form class="mb-4" action="#" method="post">
            <select class="form-control" name="period" placeholder="Selecione um período...">
                <?php 
                    foreach($periods as $key => $value) {
                        echo "<option value='{$key}'>{$value}</option>";
                    }
                ?>
            </select>
        </form>
        <table class="table table-striped table-hover">
            <thead>
                <th>Dia</th>
                <th>Entrada 1</th>
                <th>Saída 1</th>
                <th>Entrada 2</th>
                <th>Saída 2</th>
                <th>Saldo</th>
            </thead>
            <tbody>
                <?php foreach($report as $registry): ?>
                    <tr>
                        <td><?= formatDateWithLocale($registry->work_date, '%A, %d de %B de %Y') ?></td>
                        <td><?= $registry->time1 ?></td>
                        <td><?= $registry->time2 ?></td>
                        <td><?= $registry->time3 ?></td>
                        <td><?= $registry->time4 ?></td>
                        <td><?= $registry->getBalance() ?></td>
                    </tr>
                <?php endforeach ?>
                    <tr class="bg-primary text-white">
                        <td>Total de horas trabalhadas</td>
                        <td colspan="3"><?= $sumOfWorkedTime ?></td>
                        <td>Saldo</td>
                        <td><?= $balance ?></td>
                    </tr>
            </tbody>
        </table>
    </div>
</main>