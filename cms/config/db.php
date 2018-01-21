<?php

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'cms');

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    /* change character set to utf8 */
    if (!mysqli_set_charset($connection, "utf8")) {
        printf("Error loading character set utf8: %s\n", mysqli_error($connection));
    }

?>