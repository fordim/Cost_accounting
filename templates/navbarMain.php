<nav class="navbar navbar-dark navbar-expand-md bg-dark sticky-top container-fluid">
    <a href="index.php" class="navbar-brand">
        <img src="../img/Superman-Logo.png" alt="logo" width="50" height="50">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a href="?page=signUp" class="nav-link">Регистрация</a>
            </li>
            <li class="nav-item active">
                <a href="#" class="nav-link disabled">О нас</a>
            </li>
        </ul>
        <button class="btn btn-outline-light my-2 my-sm-0" data-toggle="modal" data-target="#signInModal">Войти</button>
    </div>
</nav>
<div class="modal fade" id="signInModal" role="dialog" aria-label="signInModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signInModalLabel">Регистрация</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form name="formSignIn" method="POST">
                        <div class="form-group">
                            <label for="signInInputEmail">Электронная почта</label>
                            <input type="email" name="email" class="form-control" id="signInInputEmail" aria-describedby="signInEmailHelp" placeholder="Почта" required>
                            <small id="signInEmailHelp" class="form-text text-muted">Введите ваш адрес электронной почты</small>
                        </div>
                        <div class="form-group">
                            <label for="signInInputPass">Пароль</label>
                            <input type="password" name="password" class="form-control" id="signInInputPass" aria-describedby="signInPassHelp" placeholder="Пароль" required>
                            <small id="signInPassHelp" class="form-text text-muted">Введите ваш пароль</small>
                        </div>
                        <button type="submit" name="sendFormSignIn" class="btn btn-primary" value="SignIn">Войти</button>
                        <small id="regHelp" class="form-text text-muted">Если у вас нет учетной записи, пройдите
                            <a href="?page=signUp" class="link">регистрацию</a>
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>