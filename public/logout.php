<?php
    require('../src/config.php');

    $_SESSION['id'] = [];
    unset($_SESSION['id']);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;