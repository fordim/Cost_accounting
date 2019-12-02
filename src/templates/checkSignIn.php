<?php
 /** @var $userName */
/** @var $cabinetRoute */
?>

<main class="background-color: bg-white container-fluid text-center">
    <h1 class="font-weight-bold">Аутентификация</h1>
    <h4>Добро пожаловать, <strong><?= $userName; ?></strong></h4>
    <h4>Вход успешно выполнен.</h4>
    <a class="btn btn-outline-dark m-3" href="<?= $cabinetRoute; ?>">Перейти в Личный кабинет</a>
</main>
