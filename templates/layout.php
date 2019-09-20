<!DOCTYPE html>
<!-- view внешний вид -->
<!--Ничего с модели-->
<!--Только HTML разметка и одиночные переменные -->
<!--Ещё if and foreach-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= $cssStyle; ?>">
    <script src="<?= $jsStyle; ?>"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
<div class="wrapper">
    <?= $content; ?>
</div>
</body>
</html>
