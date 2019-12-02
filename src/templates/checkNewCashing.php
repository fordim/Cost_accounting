<?php
    /** @var $userName */
    /** @var $userSum */
    /** @var $userCard */
    /** @var $userPercent */
    /** @var $cashingRoute */
    /** @var $cashingHistoryRoute */
?>

<main class="background-color: bg-white container-fluid">
    <div class="text-center mainForm">
        <h1 class="font-weight-bold">Данные успешно добавлены</h1>
        <div class="userData">
            <p class="m-0"><strong>Имя</strong> - <?= $userName; ?></p>
            <p class="m-0"><strong>Сумма</strong> - <?= $userSum; ?></p>
            <p class="m-0"><strong>Карточка</strong> - <?= $userCard; ?></p>
            <p class="m-0"><strong>Процент</strong> - <?= $userPercent; ?></p>
        </div>
        <div class="row" >
            <a class="btn btn-outline-dark m-3 col" href="<?= $cashingRoute; ?>">Добавить ещё запись</a>
            <a class="btn btn-outline-dark m-3 col" href="<?= $cashingHistoryRoute; ?>">Перейти к истории</a>
        </div>
    </div>
</main>
