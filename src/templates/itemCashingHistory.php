<main class="background-color: bg-white container-fluid text-center">
    <h1>История обналичивания</h1>
    <h5>Выберите дату:</h5>
    <div class="formDatePicker">
        <form name="formDatePicker" id="formDatePicker" method="POST">
            <input class="form-control text-center" id="dateRange" type="text" name="dateRange" value="<?= $dateFrom ?> - <?= $dateTo ?>"/>
            <input type="hidden" id="dateFrom" name="dateFrom" value="value"/>
            <input type="hidden" id="dateTo" name="dateTo" value="value"/>
        </form>
    </div>
    <h5 class="mb-3">Итого: Cумма = <?= $allAmount?> руб. <strong> Прибыль = <?= $allProfit?> руб.</strong></h5>
    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Имя</th>
            <th scope="col">Сумма</th>
            <th scope="col">Моя карточка</th>
            <th scope="col">Процент %</th>
            <th scope="col">Прибыль</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cashingOut as $cashing): ?>
            <tr>
                <td class="w-25"><?= $cashing['created_at']; ?></td>
                <td><?= $cashing['name']; ?></td>
                <td><?= $cashing['amount']; ?></td>
                <td class="w-25"><?= $cashing['card']; ?></td>
                <td><?= $cashing['percent']; ?></td>
                <th scope="row"><?= $cashing['profit']; ?></th>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
