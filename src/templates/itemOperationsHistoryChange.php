<?php
    /** @var $operations */
    /** @var $changeRealSumRoute */
    /** @var $operationHistoryRoute */
?>

<main class="background-color: bg-white container-fluid text-center">
    <h1>История операций</h1>
    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th scope="col">Месяц</th>
            <th scope="col">Остаток</th>
            <th scope="col">Прибыль</th>
            <th scope="col">Вклад</th>
            <th scope="col">Расходы</th>
            <th scope="col">Теор. сумма</th>
            <th scope="col">Реал. сумма</th>
            <th colspan="2" scope="col">Изменить реальную сумму</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($operations as $operation): ?>
            <tr>
                <td><?= $operation['month']; ?></td>
                <td><?= $operation['balance']; ?></td>
                <td><?= $operation['profit']; ?></td>
                <td><?= $operation['deposit']; ?></td>
                <td><?= $operation['expense']; ?></td>
                <th scope="col"><?= $operation['teor_sum']; ?></th>
                <th scope="col"><?= $operation['real_sum']; ?></th>
                <form name="formOperationHistory" method="POST">
                    <td>
                        <input type=hidden class="form-control" id="operationId" name="operationId" required" value="<?= $operation['id']; ?>">
                        <input type="number" name="realSum" step="0.01" class="form-control" maxlength="20" placeholder="Сумма" required>
                    </td>
                    <td>
                        <input class="btn btn-outline-secondary" formaction="<?= $changeRealSumRoute; ?>" name="changeExistCategory" type="submit" value="Изменить">
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= $operationHistoryRoute; ?>" class="btn btn-secondary mb-3">Выйти из режима редактирования</a>
</main>