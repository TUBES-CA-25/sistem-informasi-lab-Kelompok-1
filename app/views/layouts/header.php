<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ICLABS' ?> - Laboratory Information System</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <?php if (isset($adminLayout) && $adminLayout): ?>
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <?php endif; ?>
</head>
<body>
