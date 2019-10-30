<header>
    <a class="returnBack" href="?page=cabinet"></a>
    <a class="logout" href="templates/logout.php"></a>
    <div class="headerImage"></div>
</header>
<main>
    <table class="mainTable" border="2px">
        <tr>
            <th class="idСolumn">Id</th>
            <th class="categoryСolumn">Категория</th>
            <th>Изменить / Удалить</th>
        </tr>
        <?php foreach ($categories as $category): ?>
        <form class="inputFields" name="formCabinet" action="?page=categoryChange" method="POST">
            <tr>
                <td>
                    <input type=hidden class="inputText" id="categoryId" name="categoryId" required" value="<?= $category['id']; ?>"><?= $category['id']; ?>
                </td>
                <td>
                    <input class="inputText" id="categoryName" name="categoryName" type="text" size="50" maxlength="50" required value="<?= $category['name']; ?>">
                </td>
                <td>
                    <input class="subButton" name="changeExistCategory" type="submit" value="Изменить">
                    <input class="subButton" name="deleteExistCategory" type="submit" value="Удалить">
                </td>
            </tr>
        </form>
        <?php endforeach; ?>
        <form name="formCabinet" action="?page=categoryChange" method="POST">
            <tr>
                <td></td>
                <td>
                    <input class="inputAddCategory" id="categoryName" name="categoryName" type="text" size="50" maxlength="50" required placeholder="Укажите название новой категории">
                </td>
                <td>
                    <input class="subButton" name="addNewCategory" type="submit" value="Добавить">
                </td>
            </tr>
        </form>
    </table>
    <div class="mainForm">
        <form class="inputFields" name="formMode" action="?page=category" method="POST">
            <p><input class="subButton" name="changeCategoryMode" type="submit" value="Перейти в обычный режим"></p>
        </form>
    </div>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>