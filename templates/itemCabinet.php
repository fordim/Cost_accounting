<header>
    <a class="returnBack" href="index.php"></a>
    <a class="historyPage" href="../history.php"></a>
    <div class="headerImage"></div>
    <div class="headerText">
        <h1>Внесение расходов</h1>
    </div>
</header>
<main>
    <form class="inputFields" action="../action.php" method="POST">
        <p>Сумма:</p>
        <input class="inputText" type="number" size="50" maxlength="20" required placeholder="Amount">
        <p>Комментарий:</p>
        <input class="inputText" id="commentInput" type="text" size="50" maxlength="50" required placeholder="Comment">
        <p>Категория:</p>
        <p><select required>
                <option disabled>Выберите категорию</option>
                <option value="text1">Test1</option>
                <option value="text2">Test2</option>
                <option value="text3">Test3</option>
                <option value="text4">Test4</option>
            </select></p>
        <p><input class="subButton" type="submit" value="Отправить"></p>
    </form>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
