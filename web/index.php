<?php

// hack for static files
if (preg_match('/\.(?:png|gif|js|css)/', $_SERVER["REQUEST_URI"])) {
    return false;
}

$app = require(__DIR__ . '/../app/app.php');

$app->run();