<main class="background-color: bg-white container-fluid">
    <div class="mainForm text-center">
        <img src="../img/money.jpg" alt="Sign Up">
        <h1>Внесение расходов</h1>
        <form name="FormAddExpense" method="POST">
            <div class="form-group">
                <label for="addExpenseSum">Сумма:</label>
                <input type="number" name="sum" class="form-control small" id="addExpenseSum" maxlength="20" aria-describedby="sumHelp" placeholder="Сумма" required>
                <small id="sumHelp" class="form-text text-muted">Введите сумму расхода (макс. сумма 1 000 000)</small>
            </div>
            <div class="form-group">
                <label for="addExpenseComment">Комментарий</label>
                <input type="text" name="comment" class="form-control" id="addExpenseComment" maxlength="100" aria-describedby="commentHelp" placeholder="Комментарий" required>
                <small id="commentHelp" class="form-text text-muted">Введите комментарий по сумме</small>
            </div>
            <div class="form-group">
                <label for="categoryId">Категория</label>
                <select class="form-control" name="categoryId" required>
                    <option disabled>Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <small id="historyHelp" class="form-text text-muted">Выберите категорию соответствующею сумме</small>
            </div>
            <button class="btn btn-outline-success m-3 btn-lg" name="sendFormCabinet" type="submit" value="AddExpense">Добавить</button>
        </form>
    </div>
</main>
