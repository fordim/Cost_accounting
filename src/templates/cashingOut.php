<main class="background-color: bg-white container-fluid">
    <div class="mainForm text-center">
        <h1 class="p-3">Обналичивание денег</h1>
        <form name="FormAddCashingOut" method="POST">
            <div class="form-group">
                <label for="AddCashingOutName">Имя клиента:</label>
                <input type="text" name="sum" class="form-control small" id="AddCashingOutName" maxlength="30" aria-describedby="NameHelp" placeholder="Имя" required>
                <small id="NameHelp" class="form-text text-muted">Введите имя человека которому обналичиваете</small>
            </div>
            <div class="form-group">
                <label for="AddCashingOutSum">Сумма перевода:</label>
                <input type="number" name="sum" class="form-control small" id="addExpenseSum" maxlength="20" aria-describedby="SumHelp" placeholder="Сумма" required>
                <small id="SumHelp" class="form-text text-muted">Введите сумму (макс. сумма 1 000 000)</small>
            </div>
            <div class="form-group">
                <label for="AddCashingOutMyPurse">Ваш кошелек:</label>
                <select class="form-control" name="myPurse" required>
                    <option disabled>Выберите ваш кошелек</option>
                    <option value="sber">4111 1111 1111 1111</option>
                    <option value="alfa">4222 2222 2222 2222</option>
                    <option value="tinkoff">4333 3333 3333 3333</option>
                </select>
                <small id="PurseHelp" class="form-text text-muted">Выберите ваш кошелек на который переведут деньги</small>
            </div>
            <div class="form-group">
                <label for="AddCashingOutPercent">Процент прибыли:</label>
                <select class="form-control" name="percent" required>
                    <option disabled>Выберите процент</option>
                    <option value=2 >2</option>
                    <option value=2,5 >2,5</option>
                </select>
                <small id="PercentHelp" class="form-text text-muted">Выберите какой процент прибыли</small>
            </div>
            <button class="btn btn-outline-success m-3 btn-lg" name="sendCashingOut" type="submit" value="CashingOut">Добавить</button>
        </form>
    </div>
</main>
