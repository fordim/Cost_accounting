<?php
    /** @var $signUpRoute */
?>

<main class="background-color: bg-white container-fluid text-center">
    <div class="mainForm">
        <img src="img/registration.jpg" alt="Sign Up">
        <form name="formSignUp" action="<?= $signUpRoute; ?>" method="POST">
            <div class="form-group">
                <label for="signUnInputName">Имя</label>
                <input type="text" name="name" class="form-control small" id="signUnInputName" maxlength="20" aria-describedby="nameHelp" placeholder="Имя" required>
                <small id="nameHelp" class="form-text text-muted">Введите ваше имя (Латиница)</small>
            </div>
            <div class="form-group">
                <label for="signUnInputEmail">Электронная почта</label>
                <input type="email" name="email" class="form-control" id="signUnInputEmail" maxlength="50" aria-describedby="signUpEmailHelp" placeholder="Почта" required>
                <small id="signUpEmailHelp" class="form-text text-muted">Введите ваш адрес электронной почты</small>
            </div>
            <div class="form-group">
                <label for="signUpInputPass">Пароль</label>
                <input type="password" name="password" class="form-control " id="signUpInputPass" aria-describedby="signUpPassHelp" placeholder="Пароль" required>
                <small id="signUpPassHelp" class="form-text text-muted">Введите ваш пароль</small>
            </div>
            <button class="btn btn-primary m-3" name="sendFormSignUp" type="submit" value="SignUp">Зарегистрироваться</button>
        </form>
    </div>
</main>
<footer class="page-footerfont-small bg-secondary container-fluid text-center">
    <div class="footer-copyright py-1 btn-github">
        Made by Fordim
        <a href="https://github.com/fordim">
            <img src="img/GitHubIcon.svg" alt="GitHub Icon" width="25" height="25">
        </a>
    </div>
</footer>
