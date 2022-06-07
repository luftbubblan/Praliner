<?php
    require('../src/config.php');

    $_SESSION = [];
    session_destroy();

    header('Location: index.php');
    exit;