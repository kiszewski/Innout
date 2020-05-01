<main class="content">
    <?php
        renderTitle(
            'Cadastro de usuários',
            'Mantenha os dados dos usuários atualizados',
            'icofont-users'
        );

        include(TEMPLATE_PATH . '/messages.php')
    ?>

    <a  class="btn btn-primary mb-2"
        href="save_user.php">Novo Usuário</a>

    <table class="table table-hover table-striped">
        <thead>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Admissão</th>
            <th>Data de Desligamento</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td> <?= $user->name ?></td>
                    <td> <?= $user->email ?></td>
                    <td> <?= $user->start_date ?></td>
                    <td> <?= $user->end_date ?></td>
                    <td>
                        <a class="btn btn-warning rounded-circle mr-2"
                        href="save_user.php/update=<?= $user->id ?>">
                            <i class="icofont-edit"></i>
                        </a>
                        <a class="btn btn-danger rounded-circle mr-2"
                        href="?delete=<?= $user->id ?>">
                            <i class="icofont-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>