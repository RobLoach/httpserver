<?php

error_reporting(E_ALL);

$loader = require __DIR__.'/../src/bootstrap.php';
$loader->add('HttpServer\Test', __DIR__);
