<nav class="navbar navbar-dark navbar-expand-md bg-dark sticky-top container-fluid">
    <a href="#" class="navbar-brand">
        <img src="../../public/img/user.svg" alt="ava" width="50" height="50">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a href="index.php" class="nav-link">Главная</a>
            </li>
            <li class="nav-item active">
                <a href="?page=cabinet" class="nav-link">Личный кабинет</a>
            </li>
            <li class="nav-item active">
                <a href="?page=history" class="nav-link">История</a>
            </li>
            <li class="nav-item active">
                <a href="?page=category" class="nav-link">Категории</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Операции
                </a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-white" href="?page=cashing_out">Обналичивание</a>
                    <a class="dropdown-item text-white" href="#">История обналичивания</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-white" href="#">Операции</a>
                    <a class="dropdown-item text-white" href="#">История операций</a>
                </div>
        </ul>
        <ul class="navbar-nav my-sm-0">
            <li class="nav-item active">
                <a href="#" class="nav-link"><?= $userName['name']; ?></a>
            </li>
            <li class="nav-item active">
                <a class="btn btn-outline-light my-2 my-sm-0" href="../../src/templates/logout.php">Выйти</a>
            </li>
        </ul>
    </div>
</nav>
