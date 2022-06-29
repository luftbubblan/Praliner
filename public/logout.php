<?php
    require('../src/config.php');

    unset($_SESSION['id']);

    header('Location: index.php');
    exit;