<main class="background-color: bg-white container-fluid text-center">
    <h1 class="p-3 font-weight-bold">Категории (редактирование)</h1>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Категория</th>
                <th scope="col">Изменить / Удалить</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
        <form name="formCabinet" action="?page=categoryChange" method="POST">
            <tr>
                <td class="w-25">
                    <input type=hidden class="form-control" id="categoryId" name="categoryId" required" value="<?= $category['id']; ?>"><?= $category['id']; ?>
                </td>
                <td class="w-50">
                    <input type="text" class="form-control" id="categoryName" name="categoryName" maxlength="50" required value="<?= $category['name']; ?>">
                </td>
                <td class="w-25">
                    <input class="btn btn-outline-secondary" name="changeExistCategory" type="submit" value="Изменить">
                    <input class="btn btn-outline-secondary" name="deleteExistCategory" type="submit" value="Удалить">
                </td>
            </tr>
        </form>
        <?php endforeach; ?>
        <form name="formCabinet" action="?page=categoryChange" method="POST">
            <tr>
                <td></td>
                <td>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" maxlength="50" required placeholder="Укажите название новой категории">
                </td>
                <td>
                    <input class="btn btn-outline-secondary" name="addNewCategory" type="submit" value="Добавить">
                </td>
            </tr>
        </form>
        </tbody>
    </table>
    <a href="?page=category" class="btn btn-secondary mb-3">Перейти в обычный режим</a>
</main>