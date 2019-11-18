<main class="background-color: bg-white container-fluid text-center">
    <h1 class="p-3 font-weight-bold">Категории</h1>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Категория</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td class="w-25"><?= $category['id']; ?></td>
                <td class="w-75"><?= $category['name']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="?page=categoryChange" class="btn btn-secondary mb-3">Перейти в режим редактирования</a>
</main>
