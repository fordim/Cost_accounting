<?php
    /** @var $thisMonth */
    /** @var $lastMonthProfit */
    /** @var $newOperationRoute */
?>

<main class="background-color: bg-white container-fluid">
    <div class="mainForm text-center">
        <h1 class="p-3">Операции</h1>
        <form name="FormAddOperation" action="<?= $newOperationRoute; ?>" method="POST">
            <div class="row">
                <div class="form-group col">
                    <label for="OperationMonth">Текущий месяц</label>
                    <input type="text" name="month" class="form-control small text-center" id="OperationMonth" maxlength="30" aria-describedby="MonthHelp" required readonly value="<?= $thisMonth; ?>">
                    <small id="MonthHelp" class="form-text text-muted">Всегда берется 1-е число месяца</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label for="OperationSum">Остаток</label>
                    <input type="number" name="sum" step="0.01" class="form-control small" id="OperationSum" maxlength="20" aria-describedby="SumHelp" placeholder="Сумма" required>
                    <small id="SumHelp" class="form-text text-muted">Введите сумму (макс. сумма 1 000 000)</small>
                </div>
                <div class="form-group col">
                    <label for="OperationName">Прибыль</label>
                    <input type="number" name="profit" step="0.01" class="form-control small text-center" id="OperationProfit" maxlength="30" aria-describedby="ProfitHelp" required readonly value="<?= $lastMonthProfit; ?>">
                    <small id="ProfitHelp" class="form-text text-muted">Прибыль за прошлый месяц</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label for="OperationSum">Вклад</label>
                    <input type="number" name="deposit" step="0.01" class="form-control small" id="OperationDeposit" maxlength="20" aria-describedby="DepositHelp" placeholder="Сумма" required>
                </div>
                <div class="form-group col">
                    <label for="OperationFlat">Расходы за квартиру</label>
                    <input type="number" name="expenseFlat" step="0.01" class="form-control small" id="OperationExpenseFlat" maxlength="30" placeholder="Сумма" required>
                </div>
            </div>
            <button class="btn btn-outline-success m-3 btn-lg" name="sendOperation" type="submit" value="Cashing">Добавить</button>
        </form>
    </div>
</main>
