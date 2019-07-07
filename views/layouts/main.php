<?php
/**
 * @var system\core\Controller $this
 */

use system\core\App;
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/templates/css/bootstrap.min.css" rel="stylesheet">
    <link href="/templates/css/site.css" rel="stylesheet">
</head>
<body>
<div class="wrap">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/">Телефонная книга</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/contact/index">Контакты</a>
                </li>
                <li class="nav-item">
                    <?php if (App::$components->session->isGuest()): ?>
                        <a class="nav-link" href="/auth/login">Войти</a>
                    <?php else: ?>
                        <a class="nav-link" href="/auth/logout">
                            Выйти(<?= App::$components->user->NAME ?>)
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>

    <main role="main" class="container">
        <div class="starter-template">
            <?= $this->getContent() ?>
        </div>
    </main>
</div>
<footer>
</footer>
<script src="/templates/js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="/templates/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>

