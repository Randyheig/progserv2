<?php
/**
 * Layout commun à toutes les pages.
 *
 * @var string $content
 * @var string|null $title
 * @var bool|null $hero      true si la page commence par une grande image sous le header
 * @var bool|null $withMap   true pour charger Leaflet
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(($title ?? 'Skatearth') . ' | Skatearth') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <?php if (!empty($withMap)) { ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php } ?>
</head>

<body class="<?= !empty($hero) ? 'has-hero' : '' ?>">
    <div class="app">
        <?php require APP_ROOT . '/views/partials/header.php'; ?>

        <main>
            <?= $content ?>
        </main>

        <?php require APP_ROOT . '/views/partials/footer.php'; ?>
    </div>
</body>

</html>
