<?php
$app = require(__DIR__ . '/../app.php');

$console = $app["console"];
$app['capsule'];
$console->add(new Console\GenerateTestDataCommand());
$console->run();