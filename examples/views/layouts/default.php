<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= $this->registerCSS(':assets:css:bootstrap.min.css') ?>
    <?= $this->registerCSS(':assets:css:select2.min.css') ?>
    <?= $this->registerCSS(':assets:css:style.css') ?>
    <title><?= $this->title ?></title>
</head>
<body>
    <header>
        <?= $this->render_partial('layouts:partials:nav') ?>
    </header>

    <main class="container">
        <?= $page ?>
    </main>

    <footer class="text-muted bg-dark">
        <?= $this->render_partial('layouts:partials:footer') ?>
    </footer>

    <?= $this->registerJS(':assets:js:jquery-3.4.1.min.js') ?>
    <?= $this->registerJS(':assets:js:bootstrap.min.js') ?>
    <?= $this->registerJS(':assets:js:select2.min.js') ?>

    <script>
        $(document).ready(function() { $('.custom-select').select2(); });
    </script>
</body>
</html>