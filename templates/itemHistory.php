<header>
    <a class="returnBack" href="?page=cabinet"></a>
    <a class="logout" href="templates/logout.php"></a>
    <div class="headerImage"></div>
</header>
<main>
    <h1 class="mainText">История расходов</h1>
    <div class="inputBlock">
        <input class="inputDate" type="text" name="daterange" value="01/01/2018 - 01/15/2018" />
    </div>
    <table class="mainTable" border="2px">
        <tr>
            <th class="dataСolumn">Дата</th>
            <th class="sumСolumn">Сумма</th>
            <th class="commentСolumn">Комментарий</th>
            <th class="categoryСolumn">Категория</th>
        </tr>
        <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?= formatDateTime($expense['created_at']); ?></td>
                <td><?= $expense['amount']; ?></td>
                <td class="commentLine"><?= $expense['comment']; ?></td>
                <td><?= $expense['category']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
<div class="script">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</div>