<main class="background-color: bg-white container-fluid">
    <div class="text-center mainForm">
        <h1 class="font-weight-bold">Данные успешно добавлены</h1>
        <div class="userData">
            <?php foreach ($userCategory as $category): ?>
                <p class="m-0"><strong>Категория</strong> - <?= $category['name']; ?></p>
            <?php endforeach; ?>
            <p class="m-0"><strong>Сумма</strong> - <?= $userSum; ?></p>
            <p class="m-0"><strong>Комментарий</strong> - <?= $userComment; ?></p>
        </div>
        <div class="row" >
            <a class="btn btn-outline-dark m-3 col" href="?page=cabinet">Добавить ещё запись</a>
            <a class="btn btn-outline-dark m-3 col" href="?page=history">Перейти к истории</a>
        </div>
    </div>
</main>
