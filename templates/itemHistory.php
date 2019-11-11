<main class="background-color: bg-white container-fluid text-center">
    <h1>История расходов</h1>
    <h5>Выберите дату:</h5>
    <div class="formDatePicker">
        <form name="formDatePicker" id="formDatePicker" method="POST">
            <input class="form-control text-center" id="dateRange" type="text" name="dateRange" value="<?= $dateFrom ?> - <?= $dateTo ?>"/>
            <input type="hidden" id="dateFrom" name="dateFrom" value="value"/>
            <input type="hidden" id="dateTo" name="dateTo" value="value"/>
        </form>
    </div>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Дата</th>
                <th scope="col">Сумма</th>
                <th scope="col">Комментарий</th>
                <th scope="col">Категория</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td class="w-25"><?= $expense['created_at']; ?></td>
                    <td class="w-25"><?= $expense['amount']; ?></td>
                    <td class="w-25"><?= $expense['comment']; ?></td>
                    <td class="w-25"><?= $expense['category']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form name="formDownloadAllHistory" method="POST">
        <button class="btn btn-secondary mb-3" name="downloadAllHistory" type="submit" value="DownloadAllHistory">Скачать всю историю, CSV</button>
    </form>
</main>
