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
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id']; ?></td>
                <td><?= $category['name']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="mainForm">
        <h3>Вы можете добавить новую категорию:</h3>
        <form class="inputFields" name="formCabinet" action="?page=category" method="POST">
            <p>Новоя категория:</p>
            <input class="inputText" id="categoryName" name="categoryName" type="text" size="50" maxlength="50" required placeholder="Write new name">
            <p><input class="subButton" name="addNewCategory" type="submit" value="Добавить"></p>
        </form>
        <h3>Вы можете изменить существующею категорию:</h3>
        <form class="inputFields" name="formCabinet" action="?page=category" method="POST">
            <p>Выберите категорию:</p>
            <p><select name="categoryId" required>
                    <option disabled>Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select></p>
            <p>Новое название:</p>
            <input class="inputText" id="categoryName" name="categoryName" type="text" size="50" maxlength="50" required placeholder="Write new name">
            <p><input class="subButton" name="changeExistCategory" type="submit" value="Изменить"></p>
        </form>
        <h3>Вы можете удалить существующею категорию:</br><span>если она ранее не была использована в таблице Истории</span></h3>
        <form class="inputFields" name="formCabinet" action="?page=category" method="POST">
            <p>Выберите категорию:</p>
            <p><select name="categoryId" required>
                    <option disabled>Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select></p>
            <p><input class="subButton" name="deleteExistCategory" type="submit" value="Удалить"></p>
        </form>
    </div>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
