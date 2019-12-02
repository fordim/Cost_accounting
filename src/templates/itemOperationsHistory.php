<?php
    /** @var $operations */
?>

<main class="background-color: bg-white container-fluid text-center">
    <h1>История операций</h1>
    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th scope="col">Месяц</th>
            <th scope="col">Остаток</th>
            <th scope="col">Прибыль</th>
            <th scope="col">Расходы</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($operations as $operation): ?>
            <tr>
                <td class="w-25"><?= $operation['month']; ?></td>
                <td class="w-25"><?= $operation['teor_sum']; ?></td>
                <td class="w-25"><?= $operation['profit']; ?></td>
                <td class="w-25"><?= $operation['deposit']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
