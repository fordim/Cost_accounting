<header>
    <a class="returnBack" href="index.php"></a>
    <div class="headerImage"></div>
    <div class="headerText">
        <h1>Вход</h1>
    </div>
</header>
<main>
    <form class="inputFields" name="formSignIn" action="index.php?page=acceptForm" method="POST">
        <p>Электронная почта:</p>
        <input class="inputText" name="email" type="email" size="50" maxlength="50" required placeholder="E-Mail">
        <p>Пароль:</p>
        <input class="inputText" type="password" name="password" size="50" maxlength="30" required placeholder="Password">
        <input class="subButton" name="senFormSignIn" id="subButton" type="submit" value="Войти">
    </form>
</main>
<footer>
    <p>Made by Fordim</p>
</footer>
