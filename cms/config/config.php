<?php

    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    $admin = $ROOT.'/cms/admin';
    $pub = $ROOT.'/cms';

    require_once $ROOT . '/vendor/autoload.php';

    $dotenv = new Dotenv\Dotenv($ROOT);
    $dotenv->load();

    require_once $pub . '/config/db.php';
    require_once $admin . '/functions.php';

