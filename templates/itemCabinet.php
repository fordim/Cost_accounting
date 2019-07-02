<header>
    <a class="returnBack" href="index.php"></a>
    <a class="historyPage" href="index.php?page=history"></a>
    <a class="logout" href="templates/logout.php"></a>
    <div class="headerImage"></div>
    <div class="headerText">
        <h1>Внесение расходов</h1>
    </div>
</header>
<main>
    <form class="inputFields" name="formCabinet" action="index.php?page=acceptForm" method="POST">
        <p>Сумма:</p>
        <input class="inputText" type="number" name="sum" size="50" maxlength="20" required placeholder="Amount">
        <p>Комментарий:</p>
        <input class="inputText" id="commentInput" name="comment" type="text" size="50" maxlength="50" required placeholder="Comment">
        <p>Категория:</p>
        <p><select name="categoryId" required>
                <option disabled>Выберите категорию</option>
                <option value="1">Test1</option>
                <option value="2">Test2</option>
                <option value="3">Test3</option>
                <option value="4">Test4</option>
            </select></p>
        <p><input class="subButton" name="sendFormCabinet" type="submit" value="Отправить"></p>
    </form>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
