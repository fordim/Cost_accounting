<?php
    /** @var $userName */
    /** @var $userEmail */
    /** @var $userPassword */
    /** @var $cabinetRoute */
?>

<main class="background-color: bg-white container-fluid text-center">
    <h1 class="font-weight-bold">Вы успешно зарегистрировались</h1>
    <h3>Ваши данные:</h3>
    <div class="userData">
        <p class="m-0"><strong>Имя</strong> - <?= $userName; ?></p>
        <p class="m-0"><strong>Почта</strong> - <?= $userEmail; ?></p>
        <p class="m-0"><strong>Пароль</strong> - <?= $userPassword; ?></p>
    </div>
    <a class="btn btn-outline-dark m-3" href="<?= $cabinetRoute; ?>">Перейти в Личный кабинет</a>
</main>
