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
        <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?= $expense['created_at']; ?></td>
                <td><?= $expense['category']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
