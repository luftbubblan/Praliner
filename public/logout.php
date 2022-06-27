<?php
    require('../src/config.php');

    unset($_SESSION['id']);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;