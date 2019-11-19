<main class="background-color: bg-white container-fluid">
    <div class="mainForm text-center">
        <h1 class="p-3">Обналичивание денег</h1>
        <form name="FormAddCashing" method="POST">
            <div class="form-group">
                <label for="AddCashingName">Имя клиента:</label>
                <input type="text" name="name" class="form-control small" id="AddCashingName" maxlength="30" aria-describedby="NameHelp" placeholder="Имя" required>
                <small id="NameHelp" class="form-text text-muted">Введите имя человека которому обналичиваете</small>
            </div>
            <div class="form-group">
                <label for="AddCashingSum">Сумма перевода:</label>
                <input type="number" name="sum" class="form-control small" id="AddCashingSum" maxlength="20" aria-describedby="SumHelp" placeholder="Сумма" required>
                <small id="SumHelp" class="form-text text-muted">Введите сумму (макс. сумма 1 000 000)</small>
            </div>
            <div class="form-group">
                <label for="AddCashingMyCard">Ваш кошелек:</label>
                <select class="form-control" name="card" required>
                    <option disabled>Выберите ваш кошелек</option>
                    <option value="СберБанк : 4111 1111 1111 1111">СберБанк : 4111 1111 1111 1111</option>
                    <option value="АльфаБанк : 2222 2222 2222">АльфаБанк : 2222 2222 2222</option>
                    <option value="Тинькофф : 4333 3333 3333 3333">Тинькофф : 4333 3333 3333 3333</option>
                </select>
                <small id="cardHelp" class="form-text text-muted">Выберите ваш кошелек на который переведут деньги</small>
            </div>
            <div class="form-group">
                <label for="AddCashingPercent">Процент прибыли:</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="percentZero" value=0 name="percent">
                        <label class="form-check-label" for="percentZero">0</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="percentTwo" name="percent" value=2>
                        <label class="form-check-label" for="percentTwo">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="percentTwoFive" value=2.5 name="percent">
                        <label class="form-check-label" for="percentTwoFive">2,5</label>
                    </div>
                </div>
                <small id="PercentHelp" class="form-text text-muted">Выберите какой процент прибыли</small>
            </div>
            <button class="btn btn-outline-success m-3 btn-lg" name="sendCashing" type="submit" value="Cashing">Добавить</button>
        </form>
    </div>
</main>
