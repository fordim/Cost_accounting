<header>
    <a class="returnBack" href="index.php"></a>
    <div class="headerImage"></div>
    <div class="headerText">
        <h1>Регистрация</h1>
    </div>
</header>
<main>
    <form class="inputFields" name="formSignUp" action="?page=acceptForm" method="POST">
        <p>Ваше Имя:</p>
        <input class="inputText" id="nameInput" name="name" type="text" size="50" maxlength="20" required placeholder="Name">
        <p>Электронная почта:</p>
        <input class="inputText" type="email" name="email" size="50" maxlength="50" required placeholder="E-Mail">
        <p>Пароль:</p>
        <input class="inputText" type="password" name="password" size="50" maxlength="30" required placeholder="Password">
        <input class="subButton" id="subButton" name="sendFormSignUp" type="submit" value="Зарегистрироватся">
    </form>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
