<header>
    <h1>Вы успешно зарегистрировались</h1>
</header>
<main>
    <h3>Ваши данные:</h3>
    <div class="userData">
        <p>Имя - <?= $userName; ?></p>
        <p>Почта - <?= $userEmail; ?></p>
        <p>Пароль - <?= $userPassword; ?></p>
    </div>
    <div class="buttonsSignForm">
    <a class="mainButton" href="index.php">Перейти в Личный кабинет</a>
    </div>
</main>