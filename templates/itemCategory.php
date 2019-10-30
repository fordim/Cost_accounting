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
        <form class="inputFields" name="formMode" action="?page=categoryChange" method="POST">
            <p><input class="subButton" name="changeCategoryMode" type="submit" value="Перейти в режим редактирования"></p>
        </form>
    </div>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
